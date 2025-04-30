<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../models/model6.php';

if (isset($_GET['nom'])) {
    $nom = $_GET['nom'];

    $model = ($model)();
    $model['activatePromoByName']($nom);
}

header('Location: index.php?page=proms1');
exit();
