<?php
/**
 * Modèle pour la gestion du changement de mot de passe
 */

/**
 * Valide un mot de passe selon les critères définis
 *
 * @param string $password Le mot de passe à valider
 * @return array Array contenant le statut de validation et un message d'erreur éventuel
 */
function validerMotDePasse($password) {
    // Vérifier la longueur minimale
    if (strlen($password) < 6) {
        return [
            'valide' => false,
            'message' => 'Le mot de passe doit contenir au moins 6 caractères'
        ];
    }

    // Vous pouvez ajouter d'autres règles de validation ici
    // Par exemple, vérifier la présence de majuscules, chiffres, caractères spéciaux, etc.

    return [
        'valide' => true,
        'message' => ''
    ];
}

/**
 * Vérifie que les deux mots de passe correspondent
 *
 * @param string $password Le mot de passe
 * @param string $confirmPassword La confirmation du mot de passe
 * @return array Array contenant le statut de validation et un message d'erreur éventuel
 */
function verifierCorrespondanceMotsDePasse($password, $confirmPassword) {
    if ($password !== $confirmPassword) {
        return [
            'valide' => false,
            'message' => 'Les mots de passe ne correspondent pas'
        ];
    }

    return [
        'valide' => true,
        'message' => ''
    ];
}

/**
 * Met à jour le mot de passe de l'utilisateur
 *
 * @param string $login L'identifiant de l'utilisateur
 * @param string $nouveauMotDePasse Le nouveau mot de passe
 * @return bool True si la mise à jour a réussi, False sinon
 */
function changerMotDePasse($login, $nouveauMotDePasse) {
    // Chemin vers le fichier JSON
    $filePath = __DIR__ . '/../data/data.json';

    // Charger les données
    $jsonData = file_get_contents($filePath);
    $data = json_decode($jsonData, true);

    if (!$data || !isset($data['apprenants']) || !is_array($data['apprenants'])) {
        return false;
    }

    // Parcourir les apprenants pour trouver celui avec le login correspondant
    $updated = false;
    foreach ($data['apprenants'] as &$apprenant) {
        if ($apprenant['login'] === $login) {
            $apprenant['mot_de_passe'] = password_hash($nouveauMotDePasse, PASSWORD_BCRYPT);
            $apprenant['password_changed'] = true;
            $updated = true;
            break;
        }
    }

    // Si l'utilisateur a été trouvé et mis à jour, enregistrer les modifications
    if ($updated) {
        $newJsonData = json_encode($data, JSON_PRETTY_PRINT);
        return file_put_contents($filePath, $newJsonData) !== false;
    }

    return false;
}
