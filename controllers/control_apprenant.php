<?php
// controllers/apprenantController.php

require_once __DIR__ . '/../models/modelappr.php';

// Récupérer les paramètres de recherche et filtrage
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$referentielFilter = isset($_GET['referentiel']) ? $_GET['referentiel'] : '';
$statutFilter = isset($_GET['statut']) ? $_GET['statut'] : '';
$perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
$page = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1;

// Récupérer les apprenants filtrés
if (!empty($searchTerm) || !empty($referentielFilter) || !empty($statutFilter)) {
    $apprenants = searchApprenants($searchTerm, $referentielFilter, $statutFilter);
} else {
    $apprenants = getAllApprenants();
}

// Calculer la pagination
$total_apprenants = count($apprenants);
$offset = ($page - 1) * $perPage;
$apprenants = array_slice($apprenants, $offset, $perPage);

// Récupérer les référentiels pour les filtres
$referentiels = getAllReferentiels();

// Statistiques pour l'affichage
$pageStart = $total_apprenants > 0 ? $offset + 1 : 0;
$pageEnd = min($offset + $perPage, $total_apprenants);
$totalPages = ceil($total_apprenants / $perPage);

// Inclure la vue
ob_start();
require __DIR__ . '/../views/vues/vue_apprenant.php';
$contenu = ob_get_clean();
require __DIR__ . '/../views/layout/base.layout2.php';