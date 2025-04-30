<?php
$model = [
    'getData' => function () {
        $json = file_get_contents(__DIR__ . '/../data/data.json');
        return json_decode($json, true);
    },
    
    'getStats' => function ($data) {
        return $data['stats_globales'];
    },
    
    'getPromotions' => function ($data) {
        $promotions = $data['promotions'];
        
        // Trier les promotions pour que les actives soient en premier
        usort($promotions, function($a, $b) {
            // Si l'une est active et l'autre pas, l'active vient en premier
            if ($a['active'] && !$b['active']) return -1;
            if (!$a['active'] && $b['active']) return 1;
            
            // Si les deux ont le même statut, trier par nom
            return strcmp($a['nom'], $b['nom']);
        });
        
        return $promotions;
    },
    
    // Fonction de recherche qui maintient l'ordre (actives d'abord)
    'searchPromotions' => function ($data, $searchTerm) {
        $promos = $data['promotions'];
        if (empty($searchTerm)) {
            // Si pas de recherche, retourner toutes les promotions triées
            usort($promos, function($a, $b) {
                if ($a['active'] && !$b['active']) return -1;
                if (!$a['active'] && $b['active']) return 1;
                return strcmp($a['nom'], $b['nom']);
            });
            return $promos;
        }
        
        // Filtrer par terme de recherche
        $filtered = array_filter($promos, function ($promo) use ($searchTerm) {
            return stripos($promo['nom'], $searchTerm) !== false;
        });
        
        // Trier les résultats filtrés
        usort($filtered, function($a, $b) {
            if ($a['active'] && !$b['active']) return -1;
            if (!$a['active'] && $b['active']) return 1;
            return strcmp($a['nom'], $b['nom']);
        });
        
        return $filtered;
    },
    
    // Nouvelle fonction pour paginer en gardant une promotion active en première position
    'getPaginatedPromotions' => function ($promotions, $page, $per_page) {
        // Vérifier s'il y a au moins une promotion active dans la liste
        $has_active = false;
        foreach ($promotions as $promo) {
            if ($promo['active']) {
                $has_active = true;
                break;
            }
        }
        
        if (!$has_active) {
            // S'il n'y a pas de promotions actives, on revient à la pagination classique
            $start_index = ($page - 1) * $per_page;
            return array_slice($promotions, $start_index, $per_page);
        }
        
        // Séparer les promotions actives et inactives
        $actives = [];
        $inactives = [];
        
        foreach ($promotions as $promo) {
            if ($promo['active']) {
                $actives[] = $promo;
            } else {
                $inactives[] = $promo;
            }
        }
        
        // S'il y a au moins une promotion active, on en prend une pour chaque page
        $active_for_current_page = null;
        
        // Si nous avons plusieurs promotions actives, on prend celle qui correspondrait à cette page
        // en faisant une rotation cyclique
        if (count($actives) > 0) {
            $active_index = ($page - 1) % count($actives);
            $active_for_current_page = $actives[$active_index];
            
            // Enlever cette promotion active de la liste complète pour éviter les doublons
            $remaining_promotions = array_filter($promotions, function($promo) use ($active_for_current_page) {
                return $promo['nom'] !== $active_for_current_page['nom'];
            });
        } else {
            $remaining_promotions = $promotions;
        }
        
        // Calculer les indices pour la pagination classique des promotions restantes
        $start_index = ($page - 1) * ($per_page - 1); // -1 car nous avons déjà une promotion active
        $paginated_remaining = array_slice($remaining_promotions, $start_index, $per_page - 1);
        
        // Combiner la promotion active avec les autres promotions paginées
        $result = [];
        if ($active_for_current_page) {
            $result[] = $active_for_current_page;
        }
        
        return array_merge($result, $paginated_remaining);
    }
];
?>