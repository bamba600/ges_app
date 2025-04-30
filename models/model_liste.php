<?php
// /models/model_liste.php

return [
    'load_data' => function () {
        $jsonData = file_get_contents(__DIR__ . '/../data/data.json');
        $data = json_decode($jsonData, true);

        if ($data === null) {
            die("Erreur lors du chargement des données JSON");
        }

        return $data;
    },

    'get_stats' => function () {
        $data = (require __FILE__)['load_data']();
    $stats = $data['stats_globales'];
    
    // Compter directement les apprenants depuis le tableau des apprenants
    $nombre_apprenants = count($data['apprenants']);
    
    // Mettre à jour la statistique dans l'array
    $stats['nombre_apprenants'] = $nombre_apprenants;
    
    return $stats;
    },

    'get_all_referentiels' => function () {
        $data = (require __FILE__)['load_data']();
        return $data['referentiels'];
    },

    'get_paginated_promotions' => function ($page = 1, $items_per_page = 5, $search = '', $referentiel_filter = '', $status_filter = '') {
        $data = (require __FILE__)['load_data']();
        $promotions = $data['promotions'];

        $active_promotion = null;
        $inactive_promotions = [];

        // Séparation des promotions actives et inactives
        foreach ($promotions as $promo) {
            // Si un filtre de référentiel est appliqué, vérifier si la promotion a ce référentiel
            if (!empty($referentiel_filter) && !in_array($referentiel_filter, $promo['referentiels'])) {
                continue; // Ignorer cette promotion si elle n'a pas le référentiel recherché
            }
            
            if ($promo['active']) {
                // Ne filtrer la promotion active par recherche que si nécessaire
                if (empty($search) || stripos($promo['nom'], $search) !== false) {
                    $active_promotion = $promo;
                }
            } else {
                // Filtrage par recherche pour les promotions inactives
                if (empty($search) || stripos($promo['nom'], $search) !== false) {
                    $inactive_promotions[] = $promo;
                }
            }
        }

        // Si le filtre de statut est "active", ignorer les inactives
        if ($status_filter == 'active') {
            $inactive_promotions = [];
        }
        // Si le filtre de statut est "inactive", ignorer l'active
        else if ($status_filter == 'inactive') {
            $active_promotion = null;
        }

        $total_items = count($inactive_promotions);
        $total_pages = max(1, ceil($total_items / $items_per_page));
        $page = max(1, min($page, $total_pages));
        $offset = ($page - 1) * $items_per_page;

        $paginated_promotions = array_slice(array_values($inactive_promotions), $offset, $items_per_page);

        foreach ($paginated_promotions as &$promotion) {
            $promotion['date_debut_formatted'] = date('d/m/Y', strtotime($promotion['date_debut']));
            $promotion['date_fin_formatted'] = date('d/m/Y', strtotime($promotion['date_fin']));
        }

        if ($active_promotion) {
            $active_promotion['date_debut_formatted'] = date('d/m/Y', strtotime($active_promotion['date_debut']));
            $active_promotion['date_fin_formatted'] = date('d/m/Y', strtotime($active_promotion['date_fin']));
        }

        return [
            'active' => $active_promotion,
            'promotions' => $paginated_promotions,
            'current_page' => $page,
            'total_pages' => $total_pages,
            'total_items' => $total_items,
            'items_per_page' => $items_per_page,
            'offset' => $offset
        ];
    }
];