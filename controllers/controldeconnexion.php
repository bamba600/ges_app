<?php
require __DIR__ . '/../app/services/session.service.php';

deconnecterUtilisateur();

// Redirection vers la page de connexion
header('Location: index.php?page=con');
exit;
