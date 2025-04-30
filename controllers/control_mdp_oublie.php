<?php
$model = require __DIR__ . '/../models/model_mdp_oublie.php';
$message = "";
$showPasswordChangeForm = false;
$login = $_POST['login'] ?? '';

// Étape 1 : Si formulaire envoyé
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['new_password'], $_POST['confirm_password'])) {
        // Étape 2 : changement de mot de passe
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        if ($newPassword === $confirmPassword) {
            $file = __DIR__ . '/../data/data.json';
            $data = json_decode(file_get_contents($file), true);

            foreach ($data['utilisateurs'] as &$u) {
                if ($u['nom'] === $login) {
                    $u['mot_de_passe'] = $newPassword;
                    break;
                }
            }

            file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
            $message = "Mot de passe mis à jour avec succès pour <strong>{$login}</strong>.";
            header('Location: index.php?page=con');
            exit;
        } else {
            $message = "Les deux mots de passe sont différents.";
            $showPasswordChangeForm = true;
        }
    } else {
        // Étape 1 : vérifie que l'utilisateur existe
        $user = $model["findUserByLogin"]($login);
        if ($user) {
            $message = "Utilisateur trouvé. Veuillez entrer un nouveau mot de passe.";
            $showPasswordChangeForm = true;
        } else {
            $message = "Utilisateur non trouvé.";
        }
    }
}

require __DIR__ . '/../views/vues/mdp_oublie.php';
