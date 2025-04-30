<?php

// Page actuelle
$page = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1;
$search = $_GET['search'] ?? '';

// Charger modèle
$modele = require __DIR__ . '/../models/model4.php';

// Récupérer les référentiels filtrés
$data = $modele['getAllReferentiels']($page, 4, $search);
$referentiels = $data['referentiels'];
$total = $data['total'];
$parPage = $data['parPage'];
$currentPage = $data['page'];
$totalPages = ceil($total / $parPage);

// Inclure la vue
ob_start();
require __DIR__ . '/../views/vues/referentiels2.php';
$contenu = ob_get_clean();

require __DIR__ . '/../views/layout/base.layout.php';
