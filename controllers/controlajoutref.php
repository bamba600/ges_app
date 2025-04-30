<?php
require_once __DIR__ . '/../models/model_ref.php';

$erreurs = [];

ob_start(); // Démarre la mise en tampon de sortie

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $erreurs = $model_referentiel['validerReferentiel']($_POST, $_FILES);

    if (empty($erreurs)) {
        $model_referentiel['ajouterReferentiel']($_POST, $_FILES);
        header('Location: index.php?page=ref2');
        exit;
    }
}

// Inclut la vue dans le tampon
require __DIR__ . '/../views/vues/ajout_ref.php';

$contenu = ob_get_clean(); // Récupère le contenu tamponné
require __DIR__ . '/../views/layout/base.layout.php'; // Affiche le layout avec $contenu
