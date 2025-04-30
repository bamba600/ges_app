<?php
$modele = require __DIR__ . '/../models/model3.php';

// Get search parameter if it exists
$search = $_POST['search_ref'] ?? '';

// Get referentiels from "En cours" promotion that match the search
$referentiels = $modele['getReferentielsPromoEnCours']($search);
$promotionEnCours = $modele['getPromotionEnCours']();

// Load the view
ob_start();
require __DIR__ . '/../views/vues/referentiels.php';
$contenu = ob_get_clean();

require __DIR__ . '/../views/layout/base.layout.php';