<?php

$model_referentiel = [];

$model_referentiel['validerReferentiel'] = function($data, $files) {
    $errors = [];
    $jsonPath = __DIR__ . '/../data/data.json';
    $jsonData = json_decode(file_get_contents($jsonPath), true);

    // Validation du nom
    $nom = trim($data['nom'] ?? '');
    if (empty($nom)) {
        $errors[] = "Le nom est requis.";
    } else {
        foreach ($jsonData['referentiels'] as $ref) {
            if (strcasecmp($ref['nom'], $nom) === 0) {
                $errors[] = "Ce nom de référentiel existe déjà.";
                break;
            }
        }
    }

    // Validation de la description
    if (empty(trim($data['description'] ?? ''))) {
        $errors[] = "La description est requise.";
    }

    // Validation de la capacité
    if (empty($data['capacite']) || !ctype_digit($data['capacite'])) {
        $errors[] = "La capacité est requise et doit être un nombre.";
    }

    // Validation des sessions
    if (empty($data['sessions']) || !ctype_digit($data['sessions'])) {
        $errors[] = "Le nombre de sessions est requis et doit être un nombre.";
    }

    // Validation de la photo
    if (empty($files['photo']['name']) || $files['photo']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "La photo est requise.";
    } else {
        $ext = strtolower(pathinfo($files['photo']['name'], PATHINFO_EXTENSION));
        $mime = mime_content_type($files['photo']['tmp_name']);
        $taille = $files['photo']['size'];

        if (!in_array($mime, ['image/jpeg', 'image/png'])) {
            $errors[] = "Format non autorisé (JPG ou PNG uniquement)";
        }

        if ($taille > 2 * 1024 * 1024) {
            $errors[] = "La taille de la photo ne doit pas dépasser 2MB.";
        }
    }

    return $errors;
};

$model_referentiel['ajouterReferentiel'] = function($data, $files) {
    $jsonPath = __DIR__ . '/../data/data.json';
    $jsonData = json_decode(file_get_contents($jsonPath), true);

    // Création du nom de fichier unique
    $nomFichierOriginal = basename($files['photo']['name']);
    $nomFichier = uniqid('ref_') . '_' . $nomFichierOriginal;

    // Chemin relatif pour le JSON
    $cheminWeb = 'assets/images/' . $nomFichier;

    // Chemin absolu pour le déplacement
    $cheminServeur = realpath(__DIR__ . '/../../public') . '/' . $cheminWeb;

    // S'assurer que le dossier existe
    $dossierImages = dirname($cheminServeur);
    if (!is_dir($dossierImages)) {
        mkdir($dossierImages, 0755, true);
    }

    // Déplacement du fichier
    if (!move_uploaded_file($files['photo']['tmp_name'], $cheminServeur)) {
        die("Erreur lors du déplacement de l'image. Vérifiez les permissions du dossier 'assets/images'.");
    }

    // Création du référentiel
    $nouveauReferentiel = [
        'nom' => htmlspecialchars(trim($data['nom'])),
        'description' => htmlspecialchars(trim($data['description'])),
        'capacite' => $data['capacite'],
        'sessions' => $data['sessions'],
        'photo' => $cheminWeb
    ];

    // Ajout au JSON
    $jsonData['referentiels'][] = $nouveauReferentiel;
    file_put_contents($jsonPath, json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
};

?>
