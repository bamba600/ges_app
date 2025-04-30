<?php
// Fichier : app/controllers/control_ajt_appr.php

// Chargement du modèle et du service d'envoi de mail
$model = require_once __DIR__ . '/../models/model_aj_appr.php';
require_once __DIR__ . '/../services2/mailer.service.php';

// Initialisation des variables
$errors = [];
$success = false;
$mailSent = false;

// Initialisation des variables du formulaire
$nom = $prenom = $email = $telephone = $adresse = $referentiel = '';
$date_naissance = $lieu_naissance = '';
$tuteur_prenom_nom = $lien_parente = $tuteur_adresse = $tuteur_telephone = '';

// Récupération des référentiels
$referentiels = $model['getReferentiels']();

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire - Informations de l'apprenant
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $date_naissance = trim($_POST['date_naissance'] ?? '');
    $lieu_naissance = trim($_POST['lieu_naissance'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $adresse = trim($_POST['adresse'] ?? '');
    $referentiel = trim($_POST['referentiel'] ?? '');

    // Récupération des données du tuteur
    $tuteur_prenom_nom = trim($_POST['tuteur_prenom_nom'] ?? '');
    $lien_parente = trim($_POST['lien_parente'] ?? '');
    $tuteur_adresse = trim($_POST['tuteur_adresse'] ?? '');
    $tuteur_telephone = trim($_POST['tuteur_telephone'] ?? '');

    // Récupération de la photo
    $photo = $_FILES['photo'] ?? null;

    // Validation des champs obligatoires
    if (!$nom) $errors['nom'] = "Le nom est obligatoire.";
    if (!$prenom) $errors['prenom'] = "Le prénom est obligatoire.";
    if (!$date_naissance) $errors['date_naissance'] = "La date de naissance est obligatoire.";
    if (!$lieu_naissance) $errors['lieu_naissance'] = "Le lieu de naissance est obligatoire.";
    if (!$email) $errors['email'] = "L'email est obligatoire.";
    if (!$telephone) $errors['telephone'] = "Le téléphone est obligatoire.";
    if (!$adresse) $errors['adresse'] = "L'adresse est obligatoire.";
    if (!$referentiel) $errors['referentiel'] = "Le référentiel est obligatoire.";

    // Validation des champs tuteur
    if (!$tuteur_prenom_nom) $errors['tuteur_prenom_nom'] = "Le nom et prénom du tuteur sont obligatoires.";
    if (!$lien_parente) $errors['lien_parente'] = "Le lien de parenté est obligatoire.";
    if (!$tuteur_adresse) $errors['tuteur_adresse'] = "L'adresse du tuteur est obligatoire.";
    if (!$tuteur_telephone) $errors['tuteur_telephone'] = "Le téléphone du tuteur est obligatoire.";

    // Si pas d'erreurs, procéder à l'inscription
    if (empty($errors)) {
        // Préparer les données de l'apprenant
        $donnees = [
            'nom' => $nom,
            'prenom' => $prenom,
            'date_naissance' => $date_naissance,
            'lieu_naissance' => $lieu_naissance,
            'email' => $email,
            'telephone' => $telephone,
            'adresse' => $adresse,
            'referentiel' => $referentiel,
            'tuteur' => [
                'nom' => explode(' ', $tuteur_prenom_nom)[count(explode(' ', $tuteur_prenom_nom)) - 1],
                'prenom' => substr($tuteur_prenom_nom, 0, strrpos($tuteur_prenom_nom, ' ')),
                'lien_parente' => $lien_parente,
                'adresse' => $tuteur_adresse,
                'telephone' => $tuteur_telephone
            ]
        ];

        // Inscription de l'apprenant
        $result = $model['inscrireApprenant']($donnees, $photo);

        if ($result['success']) {
            $success = true;

            // Envoi d'email avec PHPMailer
            $mailSent = envoyerEmailConfirmation($result['apprenant']);

            // Si l'envoi du mail échoue, on le signale mais l'inscription reste valide
            if (!$mailSent) {
                $errors['mail'] = "L'inscription a réussi mais l'email de confirmation n'a pas pu être envoyé.";
            }

            // Réinitialisation des champs du formulaire après succès
            $nom = $prenom = $email = $telephone = $adresse = $referentiel = '';
            $date_naissance = $lieu_naissance = '';
            $tuteur_prenom_nom = $lien_parente = $tuteur_adresse = $tuteur_telephone = '';
        } else {
            // Ajout des erreurs retournées par le modèle
            $errors = array_merge($errors, $result['errors']);
        }
    }
}

// Affichage de la vue
$page_title = "Ajout d'un apprenant";
ob_start();
require __DIR__ . '/../views/vues/ajt_appr.php';
$contenu = ob_get_clean();
require __DIR__ . '/../views/layout/base.layout2.php';
