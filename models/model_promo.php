<?php
function chargerJson() {
    $chemin = __DIR__ . '/../data/data.json';
    $contenu = file_get_contents($chemin);
    return json_decode($contenu, true);
}

function enregistrerJson($data) {
    $chemin = __DIR__ . '/../data/data.json';
    file_put_contents($chemin, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function validerNomUnique($nom, $promotions) {
    foreach ($promotions as $promo) {
        if (strtolower($promo['nom']) === strtolower($nom)) {
            return false;
        }
    }
    return true;
}

function validerPhoto($photo) {
    if (!isset($photo) || $photo['error'] === UPLOAD_ERR_NO_FILE) {
        return "Photo obligatoire.";
    }
    
    if ($photo['error'] !== UPLOAD_ERR_OK) {
        return "Erreur d'upload de la photo.";
    }
    
    $typeAutorise = ['image/jpeg', 'image/png'];
    $tailleMax = 2 * 1024 * 1024;
    
    if (!in_array($photo['type'], $typeAutorise)) {
        return "Format non autorisé (JPG ou PNG uniquement).";
    }
    
    if ($photo['size'] > $tailleMax) {
        return "Taille dépassée (max 2MB).";
    }
    
    return true;
}

function validerDate($date) {
    // Vérifier le format de date (JJ/MM/AAAA)
    if (!preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $date)) {
        return false;
    }
    
    // Convertir en objet DateTime pour vérifier si c'est une date valide
    $parts = explode('/', $date);
    if (count($parts) !== 3) {
        return false;
    }
    
    $jour = (int)$parts[0];
    $mois = (int)$parts[1];
    $annee = (int)$parts[2];
    
    return checkdate($mois, $jour, $annee);
}

function formatDatePourStockage($date) {
    // Convertir JJ/MM/AAAA vers AAAA-MM-JJ (format pour le stockage)
    $parts = explode('/', $date);
    return $parts[2] . '-' . $parts[1] . '-' . $parts[0];
}

function enregistrerPhoto($photo) {
    $nomFichier = uniqid() . "_" . basename($photo['name']);
    $cheminWeb = 'assets/images/' . $nomFichier;
    $cheminAbsolu = __DIR__ . '/../../public/' . $cheminWeb;
    
    if (!is_dir(dirname($cheminAbsolu))) {
        mkdir(dirname($cheminAbsolu), 0755, true);
    }
    
    if (!move_uploaded_file($photo['tmp_name'], $cheminAbsolu)) {
        return "Erreur lors du déplacement de l'image. Vérifiez les permissions de 'assets/images'.";
    }
    
    return $cheminWeb;
}

function getReferentielsActifs($json) {
    $actifs = [];
    foreach ($json['promotions'] as $promo) {
        if ($promo['active']) {
            foreach ($promo['referentiels'] as $ref) {
                if (!in_array($ref, $actifs)) {
                    $actifs[] = $ref;
                }
            }
        }
    }
    return $actifs;
}

function ajouterPromotion($post, $fichier) {
    $json = chargerJson();
    
    $nom = trim($post['nom'] ?? '');
    $date_debut = trim($post['date_debut'] ?? '');
    $date_fin = trim($post['date_fin'] ?? '');
    $referentiels = $post['referentiels'] ?? [];
    
    $erreurs = [];
    
    // Validation du nom
    if (empty($nom)) {
        $erreurs['nom'] = "Le nom de la promotion est obligatoire.";
    } elseif (!validerNomUnique($nom, $json['promotions'])) {
        $erreurs['nom'] = "Nom de promotion déjà utilisé.";
    }
    
    // Validation de la date de début
    if (empty($date_debut)) {
        $erreurs['date_debut'] = "La date de début est obligatoire.";
    } elseif (!validerDate($date_debut)) {
        $erreurs['date_debut'] = "Format de date invalide. Utilisez le format JJ/MM/AAAA.";
    }
    
    // Validation de la date de fin
    if (empty($date_fin)) {
        $erreurs['date_fin'] = "La date de fin est obligatoire.";
    } elseif (!validerDate($date_fin)) {
        $erreurs['date_fin'] = "Format de date invalide. Utilisez le format JJ/MM/AAAA.";
    }
    
    // Vérifier que la date de fin est postérieure à la date de début
    if (validerDate($date_debut) && validerDate($date_fin)) {
        $debut = \DateTime::createFromFormat('d/m/Y', $date_debut);
        $fin = \DateTime::createFromFormat('d/m/Y', $date_fin);
        
        if ($fin < $debut) {
            $erreurs['date_fin'] = "La date de fin doit être postérieure à la date de début.";
        }
    }
    
    // Validation des référentiels
    if (empty($referentiels)) {
        $erreurs['referentiels'] = "Au moins un référentiel doit être sélectionné.";
    }
    
    // Validation de la photo
    $validPhoto = validerPhoto($fichier['photo']);
    if ($validPhoto !== true) {
        $erreurs['photo'] = $validPhoto;
    }
    
    if (!empty($erreurs)) {
        return $erreurs;
    }
    
    $photoPath = enregistrerPhoto($fichier['photo']);
    if (!is_string($photoPath)) {
        $erreurs['photo'] = $photoPath;
        return $erreurs;
    }
    
    // Convertir les dates au format stockage
    $date_debut_formattee = formatDatePourStockage($date_debut);
    $date_fin_formattee = formatDatePourStockage($date_fin);
    
    $nouvellePromo = [
        'nom' => $nom,
        'date_debut' => $date_debut_formattee,
        'date_fin' => $date_fin_formattee,
        'photo' => $photoPath,
        'nombre_apprenants' => 0,
        'active' => false,
        'referentiels' => $referentiels
    ];
    
    $json['promotions'][] = $nouvellePromo;
    $json['stats_globales']['promotion_total_count']++;
    
    enregistrerJson($json);
    
    return true;
}