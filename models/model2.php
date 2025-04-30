<?php

$model = [
    'getUsersFromJson' => function () {
        $file = __DIR__ . '/../data/data.json';  // Chemin du fichier JSON
        $json = file_get_contents($file);  // Chargement du fichier JSON
        return json_decode($json, true)['utilisateurs'];  // Retourne les utilisateurs
    },

    'verifierConnexion' => function ($login, $motDePasse) use (&$model) {
        $utilisateurs = $model['getUsersFromJson']();  // Récupère la liste des utilisateurs
        foreach ($utilisateurs as $user) {
            if ($user['nom'] === $login && $user['mot_de_passe'] === $motDePasse) {
                return $user;  // Retourne l'utilisateur si les identifiants sont valides
            }
        }
        return null;  // Retourne null si la connexion échoue
    }
];
?>
