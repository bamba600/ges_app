<?php
return [
    'getPromotionEnCours' => function () {
        $filePath = __DIR__ . '/../data/data.json';
        if (!file_exists($filePath)) return null;
        
        $data = json_decode(file_get_contents($filePath), true);
        foreach ($data['promotions'] ?? [] as $promo) {
            if (isset($promo['etat']) && $promo['etat'] === 'En cours') {
                return $promo;
            }
        }
        return null;
    },
    
    'getReferentielsPromoEnCours' => function ($search = '') {
        $filePath = __DIR__ . '/../data/data.json';
        if (!file_exists($filePath)) return [];
        
        $data = json_decode(file_get_contents($filePath), true);
        $promoEnCours = null;
        
        // Find the promotion with "En cours" status
        foreach ($data['promotions'] ?? [] as $promo) {
            if (isset($promo['etat']) && $promo['etat'] === 'En cours') {
                $promoEnCours = $promo;
                break;
            }
        }
        
        // If no "En cours" promotion found, return empty array
        if (!$promoEnCours) return [];
        
        // Get referential names from "En cours" promotion
        $refPromo = $promoEnCours['referentiels'] ?? [];
        
        // Filter referentiels based on "En cours" promotion and search term
        $filteredRefs = [];
        foreach ($data['referentiels'] ?? [] as $ref) {
            if (in_array($ref['nom'], $refPromo) && 
                (empty($search) || stripos($ref['nom'], $search) !== false)) {
                $filteredRefs[] = $ref;
            }
        }
        
        return $filteredRefs;
    },
    
    // Keep the original functions for backward compatibility
    'getPromotionActive' => function () {
        $filePath = __DIR__ . '/../data/data.json';
        if (!file_exists($filePath)) return null;
        
        $data = json_decode(file_get_contents($filePath), true);
        foreach ($data['promotions'] ?? [] as $promo) {
            if (!empty($promo['active'])) return $promo;
        }
        return null;
    },
    
    'getReferentielsPromoActive' => function ($search = '') {
        $filePath = __DIR__ . '/../data/data.json';
        if (!file_exists($filePath)) return [];
        
        $data = json_decode(file_get_contents($filePath), true);
        $promos = $data['promotions'] ?? [];
        
        foreach ($promos as $promo) {
            if (!empty($promo['active'])) {
                $refPromo = $promo['referentiels'] ?? [];
                
                return array_filter($data['referentiels'] ?? [], function ($ref) use ($refPromo, $search) {
                    return in_array($ref['nom'], $refPromo) &&
                        (empty($search) || stripos($ref['nom'], $search) !== false);
                });
            }
        }
        
        return [];
    }
];