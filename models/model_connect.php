<?php
function verifierApprenant($login, $password) {
    // Chemin vers le fichier JSON
    $filePath = __DIR__ . '/../data/data.json';

    // Vérifiez si le fichier existe
    if (!file_exists($filePath)) {
        error_log("Fichier JSON introuvable : $filePath");
        return null;
    }

    // Charger les données
    $jsonData = file_get_contents($filePath);
    if ($jsonData === false) {
        error_log("Erreur lors de la lecture du fichier JSON : $filePath");
        return null;
    }

    $data = json_decode($jsonData, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log("Erreur lors du décodage du JSON : " . json_last_error_msg());
        return null;
    }

    if (!isset($data['apprenants']) || !is_array($data['apprenants'])) {
        error_log("Structure JSON invalide : clé 'apprenants' manquante ou invalide");
        return null;
    }

    // Parcourir les apprenants pour trouver celui avec le login correspondant
    foreach ($data['apprenants'] as $apprenant) {
        if ($apprenant['login'] === $login && password_verify($password, $apprenant['mot_de_passe'])) {
            return $apprenant;
        }
    }

    return null;
}
