<?php
// Fichier: models/ReferentielModel.php

/**
 * Récupère les référentiels et les promotions en cours
 * @return array Tableau contenant les référentiels et les promotions en cours
 */
function getReferentielsEtPromotions() {
    $path = __DIR__ . '/../data/data.json';
    $data = json_decode(file_get_contents($path), true);
    
    $referentiels = $data['referentiels'] ?? [];
    $promotions_en_cours = array_filter($data['promotions'] ?? [], function($promo) {
        return isset($promo['etat']) && $promo['etat'] === 'En cours';
    });
    
    return [$referentiels, $promotions_en_cours];
}

/**
 * Ajoute un référentiel à une promotion
 * @param string $referentiel_nom Nom du référentiel à ajouter
 * @param string $promotion_nom Nom de la promotion
 * @return string Message de résultat
 */
function ajouterReferentielAPromotion($referentiel_nom, $promotion_nom) {
    $path = __DIR__ . '/../data/data.json';
    $data = json_decode(file_get_contents($path), true);
    
    $resultats = [];
    
    foreach ($data['promotions'] as &$promo) {
        if ($promo['nom'] === $promotion_nom) {
            if (!isset($promo['referentiels'])) {
                $promo['referentiels'] = [];
            }
            
            if (!in_array($referentiel_nom, $promo['referentiels'])) {
                $promo['referentiels'][] = $referentiel_nom;
                $resultats[] = "Référentiel ajouté avec succès à la promotion " . $promo['nom'];
            } else {
                $resultats[] = "Le référentiel est déjà associé à la promotion " . $promo['nom'];
            }
        }
    }
    
    file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));
    
    return implode("\n", $resultats);
}

/**
 * Retire un référentiel d'une promotion en cours
 * La fonction vérifie spécifiquement si le référentiel a des apprenants associés
 * @param string $referentiel_nom Nom du référentiel à retirer
 * @param string $promotion_nom Nom de la promotion
 * @return string Message de résultat
 */
function retirerReferentielDePromotion($referentiel_nom, $promotion_nom) {
    $path = __DIR__ . '/../data/data.json';
    $data = json_decode(file_get_contents($path), true);
    
    foreach ($data['promotions'] as &$promo) {
        if ($promo['nom'] === $promotion_nom && isset($promo['etat']) && $promo['etat'] === 'En cours') {
            // Vérifier si le référentiel spécifique a des apprenants
            if (isset($promo['apprenants'])) {
                foreach ($promo['apprenants'] as $apprenant) {
                    // Vérifier si cet apprenant est associé au référentiel que nous voulons retirer
                    if (isset($apprenant['referentiel']) && $apprenant['referentiel'] === $referentiel_nom) {
                        return "Impossible de retirer le référentiel car il a au moins un apprenant associé.";
                    }
                }
            }
            
            // Si nous arrivons ici, le référentiel n'a pas d'apprenants et peut être retiré
            $index = array_search($referentiel_nom, $promo['referentiels']);
            if ($index !== false) {
                array_splice($promo['referentiels'], $index, 1);
                file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));
                return "Référentiel retiré avec succès de la promotion " . $promo['nom'];
            } else {
                return "Ce référentiel n'est pas associé à la promotion " . $promo['nom'];
            }
        }
    }
    
    return "Promotion non trouvée ou non en cours.";
}

/**
 * Récupère la promotion actuellement en cours
 * @return array|null La promotion en cours ou null si aucune
 */
function getPromotionEnCours() {
    $path = __DIR__ . '/../data/data.json';
    $data = json_decode(file_get_contents($path), true);
    
    foreach ($data['promotions'] as $promo) {
        if (isset($promo['etat']) && $promo['etat'] === 'En cours') {
            return $promo;
        }
    }
    
    return null;
}

/**
 * Récupère les référentiels non associés à une promotion
 * @param array $promo La promotion
 * @return array Liste des référentiels non associés
 */
function getReferentielsNonAssocies($promo) {
    $path = __DIR__ . '/../data/data.json';
    $data = json_decode(file_get_contents($path), true);
    
    $all_referentiels = $data['referentiels'] ?? [];
    $promo_referentiels = $promo['referentiels'] ?? [];
    
    $non_associes = [];
    foreach ($all_referentiels as $ref) {
        if (!in_array($ref['nom'], $promo_referentiels)) {
            $non_associes[] = $ref;
        }
    }
    
    return $non_associes;
}
?>