<?php
// Fichier: controllers/ReferentielController.php

// Inclure le modèle
require_once __DIR__ . '/../models/model_ref2.php';

// Initialiser les variables
$error = null;
$success = null;

// Traitement de l'ajout de référentiel
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $referentiel = $_POST['ref_add'] ?? '';
    $promo = $_POST['promo_add'] ?? '';
    
    if (!empty($referentiel) && !empty($promo)) {
        $success = ajouterReferentielAPromotion($referentiel, $promo);
    } else {
        $error = "Veuillez sélectionner un référentiel et au moins une promotion.";
    }
}

// Traitement du retrait de référentiel
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'remove') {
    $referentiel = $_POST['ref_remove'] ?? '';
    $promo = $_POST['promo_remove'] ?? '';
    
    if (!empty($referentiel) && !empty($promo)) {
        $result = retirerReferentielDePromotion($referentiel, $promo);
        
        if (strpos($result, "Impossible") !== false) {
            $error = $result;
        } else {
            $success = $result;
        }
    } else {
        $error = "Veuillez sélectionner un référentiel à retirer.";
    }
}

// Récupérer tous les référentiels et les promotions en cours
list($referentiels, $promotions_en_cours) = getReferentielsEtPromotions();

// Récupérer la promotion actuellement active pour le formulaire de retrait
$promo_en_cours = getPromotionEnCours();

// Récupérer les référentiels non associés pour les ajouter à la promotion
$referentiels_non_associes = $promo_en_cours ? getReferentielsNonAssocies($promo_en_cours) : [];

// Capturer le contenu de la vue
ob_start();
require __DIR__ . '/../views/vues/ajout_ref2.php';
$contenu = ob_get_clean();

// Inclure la mise en page de base
require __DIR__ . '/../views/layout/base.layout.php';
?>