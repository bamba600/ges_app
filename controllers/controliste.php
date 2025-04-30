<?php
// /controllers/liste_promotions.php



$model = require_once __DIR__ . '/../models/model_liste.php';


$page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$referentiel_filter = isset($_GET['referentiel']) ? $_GET['referentiel'] : '';
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$items_per_page = 5;

$pagination_data = $model['get_paginated_promotions']($page, $items_per_page, $search, $referentiel_filter, $status_filter);
$stats = $model['get_stats']();
$referentiels = $model['get_all_referentiels']();

$start_item = ($pagination_data['offset'] + 1);
$end_item = min($pagination_data['offset'] + $pagination_data['items_per_page'], $pagination_data['total_items']);
$total_items = $pagination_data['total_items'];
$current_page = $pagination_data['current_page'];
$total_pages = $pagination_data['total_pages'];
$active_promotion = $pagination_data['active'];



ob_start();
require __DIR__ . '/../views/vues/vue_liste.php';
$contenu = ob_get_clean();

require __DIR__ . '/../views/layout/base.layout2.php';