<?php
require_once __DIR__ . '/../models/model_promo.php';

$erreurs = [];
$succes = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resultat = ajouterPromotion($_POST, $_FILES);
    
    if ($resultat === true) {
        $succes = true;
    } else {
        $erreurs = $resultat;
    }
}

$referentielsActifs = getReferentielsActifs(chargerJson());

// Inclure la vue
require __DIR__ . '/../views/vues/ajout_promotion.php';