<?php
// Inclusion du modèle (retourne un tableau de fonctions anonymes)
require_once __DIR__ . '/../models/model1.php';

// Récupération individuelle des statistiques
$nombre_apprenants = $statsFunctions['getNombreApprenants']();
$nombre_referentiel = $statsFunctions['getNombreReferentiel']();
$promotion_active_count = $statsFunctions['getPromotionActiveCount']();
$promotion_total_count = $statsFunctions['getPromotionTotalCount']();
$promotion_en_cours = $statsFunctions['getStatsPromotionEnCours']();


// Inclusion de la vue en capturant le contenu
ob_start();
require __DIR__ . '/../views/vues/promotions.php';
$contenu = ob_get_clean();

// Inclusion du layout principal
require __DIR__ . '/../views/layout/base.layout.php';
