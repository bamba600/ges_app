<?php
/**
 * Contrôleur pour la gestion du changement de mot de passe
 */

// Démarrer la session si elle n'est pas déjà démarrée
require_once __DIR__ . '/../services/session.service.php';
demarrerSession();

// Inclure le modèle pour le changement de mot de passe
require_once __DIR__ . '/../models/model_changer.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user']) || !is_array($_SESSION['user'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: index.php?page=control_connect');
    exit();
}

// Si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Valider le mot de passe
    $validationPassword = validerMotDePasse($password);
    if (!$validationPassword['valide']) {
        // Stocker le message d'erreur dans la session
        $_SESSION['error_password'] = $validationPassword['message'];
    }

    // Vérifier que les mots de passe correspondent
    $validationCorrespondance = verifierCorrespondanceMotsDePasse($password, $confirmPassword);
    if (!$validationCorrespondance['valide']) {
        // Stocker le message d'erreur dans la session
        $_SESSION['error_confirm_password'] = $validationCorrespondance['message'];
    }

    // Si des erreurs de validation sont présentes, rediriger vers la page de changement de mot de passe
    if (isset($_SESSION['error_password']) || isset($_SESSION['error_confirm_password'])) {
        header('Location: index.php?page=changer_pass');
        exit();
    }

    // Changer le mot de passe
    $login = $_SESSION['user']['login'];
    $resultat = changerMotDePasse($login, $password);

    if ($resultat) {
        // Mettre à jour la session pour indiquer que le mot de passe a été changé
        $_SESSION['user']['password_changed'] = true;

        // Rediriger vers la page de connexion avec un message de succès
        header('Location: index.php?page=connect_detail&success=' . urlencode('Votre mot de passe a été changé avec succès'));
        exit();
    } else {
        // Stocker le message d'erreur dans la session
        $_SESSION['error_general'] = 'Erreur lors du changement de mot de passe';
        header('Location: index.php?page=changer_pass');
        exit();
    }
} else {
    // Si ce n'est pas une requête POST, afficher la vue de changement de mot de passe
    ob_start();
    require_once __DIR__ . '/../views/vues/changer_pass.php';
    $contenu = ob_get_clean();
    require_once __DIR__ . '/../views/layout/base.layout2.php';
}
