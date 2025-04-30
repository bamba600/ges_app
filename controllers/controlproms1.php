<?php
require_once __DIR__ . '/../models/model5.php';

// Récupération des données
$data = $model['getData']();
$stats = $model['getStats']($data);

// Traitement de la recherche
$search = isset($_GET['search']) ? trim(preg_replace('/\s+/', ' ', $_GET['search'])) : '';

// Récupération des promotions (filtrées si recherche)
if (!empty($search)) {
    $promotions = $model['searchPromotions']($data, $search);
} else {
    $promotions = $model['getPromotions']($data);
}

// Statistiques
$promotion_active_count = $stats['promotion_active_count'];
$promotion_total_count = $stats['promotion_total_count'];
$nombre_referentiel = $stats['nombre_referentiel'];
$nombre_apprenants = $stats['nombre_apprenants'];

// PAGINATION
$promos_per_page = 6;
$current_page = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1;
$total_promos = count($promotions);

// Si nous utilisons la nouvelle méthode de pagination qui réserve une place pour une promotion active
// nous devons ajuster le calcul du nombre total de pages
$promos_per_page_adjusted = $promos_per_page;

// Vérifier s'il y a au moins une promotion active
$has_active = false;
foreach ($promotions as $promo) {
    if ($promo['active']) {
        $has_active = true;
        break;
    }
}

// Si nous avons des promotions actives, nous devons ajuster le calcul
if ($has_active) {
    // Nous réservons un emplacement pour une promotion active sur chaque page
    $total_pages = max(1, ceil(($total_promos - 1) / ($promos_per_page - 1)));
} else {
    // Pagination standard
    $total_pages = max(1, ceil($total_promos / $promos_per_page));
}

// Utilisation de la fonction personnalisée de pagination
$promotions_paginated = $model['getPaginatedPromotions']($promotions, $current_page, $promos_per_page);

// Inclusion de la vue
ob_start();
require __DIR__ . '/../views/vues/promotions.php';
$contenu = ob_get_clean();

require __DIR__ . '/../views/layout/base.layout.php';
?>