<?php

// Charger le fichier JSON
$lireStats = function() {
    $fichier = __DIR__ . '/../data/data.json';
    if (file_exists($fichier)) {
        return json_decode(file_get_contents($fichier), true);
    }
    return null;  // Si le fichier n'existe pas, retourner null
};

// Tableau des fonctions anonymes pour récupérer les statistiques
$statsFunctions = [
    'getPromotionActiveCount' => function() use ($lireStats) {
        $stats = $lireStats();
        return $stats ? $stats['stats_globales']['promotion_active_count'] : null;
    },

    'getPromotionTotalCount' => function() use ($lireStats) {
        $stats = $lireStats();
        return $stats ? $stats['stats_globales']['promotion_total_count'] : null;
    },

    'getNombreReferentiel' => function() use ($lireStats) {
        $stats = $lireStats();
        return $stats ? $stats['stats_globales']['nombre_referentiel'] : null;
    },

    'getNombreApprenants' => function() use ($lireStats) {
        $stats = $lireStats();
        return $stats ? $stats['stats_globales']['nombre_apprenants'] : null;
    },

    'getStatsPromotionEnCours' => function() use ($lireStats) {
        $stats = $lireStats();
        return $stats ? $stats['stats_promotion_en_cours'] : null;
    }
];

