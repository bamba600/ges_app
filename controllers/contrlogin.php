<?php
require_once __DIR__ . '/../models/model2.php';  // Inclusion du modèle pour vérifier la connexion

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // Si le formulaire est soumis
    $login = $_POST['login'] ?? '';  // Récupère le login
    $password = $_POST['password'] ?? '';  // Récupère le mot de passe

    $user = $model['verifierConnexion']($login, $password);  // Vérifie la connexion

    if ($user) {
        session_start();  // Démarre la session
        $_SESSION['user'] = $user;  // Stocke l'utilisateur dans la session
        header('Location: index.php?page=prom');  // Redirection vers la page du tableau de bord
    } else {
        require __DIR__ . '/../views/connect/login.php';  // Retour au formulaire de connexion avec erreur
    }
}
else
{
    require __DIR__ . '/../views/connect/login.php';  // Affiche le formulaire de connexion
}
?>
