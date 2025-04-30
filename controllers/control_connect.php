<?php
require_once __DIR__ . '/../services/session.service.php';
require_once __DIR__ . '/../models/model_connect.php';

demarrerSession();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';

    // Vérifier que les champs ne sont pas vides
    if (empty($login)) {
        $_SESSION['error_login'] = "L'identifiant ou l'email est requis.";
    }
    if (empty($password)) {
        $_SESSION['error_password'] = "Le mot de passe est requis.";
    }

    // Si des erreurs de validation sont présentes, rediriger vers la page de connexion
    if (isset($_SESSION['error_login']) || isset($_SESSION['error_password'])) {
        header("Location: index.php?page=connect_detail");
        exit();
    }

    // Appel à la fonction pour vérifier dans les "apprenants"
    $user = verifierApprenant($login, $password);

    if ($user) {
        $_SESSION['user'] = $user;

        if (isset($user['password_changed']) && $user['password_changed'] === false) {
            header("Location: index.php?page=changer_pass");
            exit();
        } else {
            header("Location: ../views/vues/detail.php");
            exit();
        }
    } else {
        // Mauvais identifiants
        $_SESSION['error_general'] = "Identifiants invalides";
        header("Location: index.php?page=connect_detail");
        exit();
    }
}

// Si la requête est GET, on affiche le formulaire de connexion
ob_start();
require __DIR__ . '/../views/vues/connect_detail.php';
$contenu = ob_get_clean();
require __DIR__ . '/../views/layout/base.layout2.php';
