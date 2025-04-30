<?php
// Fichier : app/models/model_aj_appr.php

// Fonction pour charger les données depuis le fichier JSON
$loadData = function() {
    $dataPath = dirname(__DIR__) . '/data/data.json';
    if (file_exists($dataPath)) {
        $json = file_get_contents($dataPath);
        return json_decode($json, true);
    }
    throw new Exception("Fichier de données introuvable");
};

// Fonction pour sauvegarder les données dans le fichier JSON
$saveData = function($data) {
    $dataPath = dirname(__DIR__) . '/data/data.json';
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return file_put_contents($dataPath, $json);
};

// Fonction pour valider un email
$validateEmail = function($email, $data) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Format d'email invalide.";
    }

    foreach ($data['apprenants'] ?? [] as $apprenant) {
        if ($apprenant['email'] === $email) {
            return "Cet email est déjà utilisé.";
        }
    }
    return null;
};

// Fonction pour valider un numéro de téléphone
$validateTelephone = function($telephone, $data) {
    // Nettoyer le numéro de téléphone (enlever espaces et autres caractères)
    $clean_tel = preg_replace('/[^0-9]/', '', $telephone);

    // Vérifier le format (commence par +221 77/78/76/70 suivi de 7 chiffres)
    if (!preg_match('/^(221)?(70|76|77|78)\d{7}$/', $clean_tel)) {
        return "Le téléphone doit être au format sénégalais (+221 7X XXX XX XX).";
    }

    foreach ($data['apprenants'] ?? [] as $apprenant) {
        $existing_tel = preg_replace('/[^0-9]/', '', $apprenant['telephone']);
        if ($existing_tel === $clean_tel) {
            return "Ce numéro de téléphone est déjà utilisé.";
        }
    }
    return null;
};

// Fonction pour formater un numéro de téléphone
$formatTelephone = function($telephone) {
    // Nettoyer le numéro
    $clean_tel = preg_replace('/[^0-9]/', '', $telephone);

    // S'assurer qu'il commence par +221
    if (substr($clean_tel, 0, 3) !== '221') {
        $clean_tel = '221' . $clean_tel;
    }

    // Formater comme +221 7X XXX XX XX
    return '+' . substr($clean_tel, 0, 3) . ' ' .
           substr($clean_tel, 3, 2) . ' ' .
           substr($clean_tel, 5, 3) . ' ' .
           substr($clean_tel, 8, 2) . ' ' .
           substr($clean_tel, 10, 2);
};

// Fonction pour valider une date
$validateDate = function($date) {
    // Vérifier le format de la date (YYYY-MM-DD)
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        return "Format de date invalide (AAAA-MM-JJ).";
    }

    // Vérifier si la date est valide
    $timestamp = strtotime($date);
    if ($timestamp === false) {
        return "Date invalide.";
    }

    // Vérifier si la date correspond au format spécifié
    if (date('Y-m-d', $timestamp) !== $date) {
        return "Date invalide.";
    }

    return null;
};

// Fonction pour générer un matricule unique
$generateMatricule = function($data) {
    $last = 0;
    foreach ($data['apprenants'] ?? [] as $apprenant) {
        if (isset($apprenant['matricule'])) {
            $num = (int)substr($apprenant['matricule'], 3);
            if ($num > $last) $last = $num;
        }
    }
    return 'MAT' . str_pad($last + 1, 3, '0', STR_PAD_LEFT);
};

// Fonction pour générer un login
$generateLogin = function($prenom, $nom) {
    // Normaliser les caractères (enlever accents)
    $prenom = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $prenom));
    $nom = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $nom));

    // Supprimer les caractères spéciaux
    $prenom = preg_replace('/[^a-z]/', '', $prenom);
    $nom = preg_replace('/[^a-z]/', '', $nom);

    // Créer le login au format prenom.nom
    return $prenom . '.' . $nom;
};

// Fonction pour générer un mot de passe aléatoire
$generatePassword = function() {
    // Générer un mot de passe aléatoire de 8 caractères
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';
    for ($i = 0; $i < 8; $i++) {
        $password .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $password;
};

// Fonction pour uploader une photo
$uploadPhoto = function($photo) {
    $uploadDir = dirname(dirname(__DIR__)) . '/public/assets/images/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    if (!empty($photo['name']) && $photo['error'] == UPLOAD_ERR_OK) {
        // Vérifier le type de fichier
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($photo['type'], $allowedTypes)) {
            return ['success' => false, 'error' => 'Format de fichier non autorisé.'];
        }

        // Vérifier la taille (2Mo max)
        if ($photo['size'] > 2 * 1024 * 1024) {
            return ['success' => false, 'error' => 'La taille du fichier ne doit pas dépasser 2Mo.'];
        }

        $fileName = time() . '_' . basename($photo['name']);
        $filePath = $uploadDir . $fileName;
        if (move_uploaded_file($photo['tmp_name'], $filePath)) {
            return ['success' => true, 'path' => 'assets/images/' . $fileName];
        }

        return ['success' => false, 'error' => "Erreur lors du téléchargement de l'image."];
    }
    return ['success' => true, 'path' => 'assets/images/default.png'];
};

// Fonction pour inscrire un apprenant
$inscrireApprenant = function($infos, $photo) use (
    $loadData,
    $saveData,
    $validateEmail,
    $validateTelephone,
    $validateDate,
    $formatTelephone,
    $generateMatricule,
    $generateLogin, // Correctement importé ici
    $generatePassword,
    $uploadPhoto
) {
    $data = $loadData();
    $errors = [];

    // Validation des données
    if ($error = $validateEmail($infos['email'], $data)) {
        $errors['email'] = $error;
    }

    if ($error = $validateTelephone($infos['telephone'], $data)) {
        $errors['telephone'] = $error;
    }

    if ($error = $validateTelephone($infos['tuteur']['telephone'], $data)) {
        $errors['tuteur_telephone'] = $error;
    }

    if ($error = $validateDate($infos['date_naissance'])) {
        $errors['date_naissance'] = $error;
    }

    if (!empty($errors)) {
        return ['success' => false, 'errors' => $errors];
    }

    // Upload de la photo
    $photoResult = $uploadPhoto($photo);
    if (!$photoResult['success']) {
        return ['success' => false, 'errors' => ['photo' => $photoResult['error']]];
    }

    // Formater les numéros de téléphone
    $formatted_tel = $formatTelephone($infos['telephone']);
    $formatted_tuteur_tel = $formatTelephone($infos['tuteur']['telephone']);

    // Générer login et mot de passe
    $login = $generateLogin($infos['prenom'], $infos['nom']);
    $mot_de_passe = $generatePassword();

    // Créer l'apprenant
    $apprenant = [
        'photo' => $photoResult['path'],
        'matricule' => $generateMatricule($data),
        'nom' => $infos['nom'],
        'prenom' => $infos['prenom'],
        'date_naissance' => $infos['date_naissance'],
        'lieu_naissance' => $infos['lieu_naissance'],
        'adresse' => $infos['adresse'],
        'telephone' => $formatted_tel,
        'email' => $infos['email'],
        'referentiel' => $infos['referentiel'],
        'statut' => 'actif',
        'login' => $login,
        'mot_de_passe' => $mot_de_passe,
        'password_changed' => false,
        'tuteur' => [
            'nom' => $infos['tuteur']['nom'],
            'prenom' => $infos['tuteur']['prenom'],
            'lien_parente' => $infos['tuteur']['lien_parente'],
            'adresse' => $infos['tuteur']['adresse'],
            'telephone' => $formatted_tuteur_tel
        ]
    ];

    // Ajouter l'apprenant aux données
    if (!isset($data['apprenants'])) {
        $data['apprenants'] = [];
    }

    $data['apprenants'][] = $apprenant;

    // Mettre à jour les statistiques globales
    if (!isset($data['stats_globales']['nombre_apprenants'])) {
        $data['stats_globales']['nombre_apprenants'] = 0;
    }
    $data['stats_globales']['nombre_apprenants'] += 1;

    // Sauvegarder les données
    if ($saveData($data)) {
        return ['success' => true, 'apprenant' => $apprenant];
    }

    return ['success' => false, 'errors' => ['global' => "Erreur lors de l'enregistrement."]];
};

// Fonction pour récupérer les référentiels
$getReferentiels = function() use ($loadData) {
    $data = $loadData();
    $refs = [];
    foreach ($data['referentiels'] ?? [] as $ref) {
        if (isset($ref['nom'])) {
            $refs[] = $ref['nom'];
        }
    }
    return $refs;
};

// Export des fonctions
return [
    'loadData' => $loadData,
    'saveData' => $saveData,
    'validateEmail' => $validateEmail,
    'validateTelephone' => $validateTelephone,
    'validateDate' => $validateDate,
    'generateMatricule' => $generateMatricule,
    'generateLogin' => $generateLogin,
    'generatePassword' => $generatePassword,
    'uploadPhoto' => $uploadPhoto,
    'inscrireApprenant' => $inscrireApprenant,
    'getReferentiels' => $getReferentiels
];
