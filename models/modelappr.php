<?php
// models/modelappr.php

/**
 * Charge les données depuis le fichier JSON
 */
function loadData() {
    $dataFile = __DIR__ . '/../data/data.json';
    if (file_exists($dataFile)) {
        $jsonData = file_get_contents($dataFile);
        return json_decode($jsonData, true);
    }
    return [
        'apprenants' => [],
        'referentiels' => [],
        'promotions' => [],
        'stats_globales' => [
            'nombre_apprenants' => 0
        ]
    ];
}

/**
 * Récupère tous les apprenants
 */
function getAllApprenants() {
    $data = loadData();
    return $data['apprenants'] ?? [];
}

/**
 * Recherche et filtre les apprenants selon les critères spécifiés
 */
function searchApprenants($searchTerm = '', $referentiel = '', $statut = '') {
    $apprenants = getAllApprenants();
    $resultats = [];
    
    foreach ($apprenants as $apprenant) {
        // Vérifier les critères de recherche
        $matchSearch = empty($searchTerm) || 
            stripos($apprenant['nom'], $searchTerm) !== false || 
            stripos($apprenant['prenom'], $searchTerm) !== false || 
            stripos($apprenant['matricule'], $searchTerm) !== false || 
            stripos($apprenant['adresse'], $searchTerm) !== false || 
            stripos($apprenant['telephone'], $searchTerm) !== false;
            
        $matchReferentiel = empty($referentiel) || $apprenant['referentiel'] === $referentiel;
        $matchStatut = empty($statut) || $apprenant['statut'] === $statut;
        
        if ($matchSearch && $matchReferentiel && $matchStatut) {
            $resultats[] = $apprenant;
        }
    }
    
    return $resultats;
}

/**
 * Récupère tous les référentiels
 */
function getAllReferentiels() {
    $data = loadData();
    return $data['referentiels'] ?? [];
}

/**
 * Enregistre les données dans le fichier JSON
 */
function saveData($data) {
    $dataFile = __DIR__ . '/../data/data.json';
    file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));
    return true;
}

/**
 * Ajoute un nouvel apprenant
 */
function addApprenant($apprenant) {
    $data = loadData();
    $data['apprenants'][] = $apprenant;
    $data['stats_globales']['nombre_apprenants'] = count($data['apprenants']);
    return saveData($data);
}

/**
 * Met à jour un apprenant existant
 */
function updateApprenant($matricule, $updatedData) {
    $data = loadData();
    foreach ($data['apprenants'] as $key => $apprenant) {
        if ($apprenant['matricule'] === $matricule) {
            $data['apprenants'][$key] = array_merge($apprenant, $updatedData);
            return saveData($data);
        }
    }
    return false;
}

/**
 * Supprime un apprenant
 */
function deleteApprenant($matricule) {
    $data = loadData();
    foreach ($data['apprenants'] as $key => $apprenant) {
        if ($apprenant['matricule'] === $matricule) {
            unset($data['apprenants'][$key]);
            $data['apprenants'] = array_values($data['apprenants']); // Réindexe le tableau
            $data['stats_globales']['nombre_apprenants'] = count($data['apprenants']);
            return saveData($data);
        }
    }
    return false;
}