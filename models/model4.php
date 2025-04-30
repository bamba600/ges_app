<?php

return [
    'getAllReferentiels' => function($page = 1, $parPage = 4, $search = '') {
        $filePath = __DIR__ . '/../data/data.json';
        if (!file_exists($filePath)) {
            return ['referentiels' => [], 'total' => 0, 'parPage' => $parPage, 'page' => $page];
        }

        $data = json_decode(file_get_contents($filePath), true);
        $referentiels = $data['referentiels'] ?? [];

        // Nettoyer la chaîne de recherche
        $search = trim(strtolower($search));

        // Filtrer les résultats si un mot de recherche est fourni
        if (!empty($search)) {
            $referentiels = array_filter($referentiels, function($ref) use ($search) {
                return stripos(strtolower(trim($ref['nom'])), $search) !== false;
            });
        }

        $total = count($referentiels);
        $offset = ($page - 1) * $parPage;
        $referentielsPage = array_slice($referentiels, $offset, $parPage);

        return [
            'referentiels' => $referentielsPage,
            'total' => $total,
            'parPage' => $parPage,
            'page' => $page
        ];
    }
];
