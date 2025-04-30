<?php
return [
    "findUserByLogin" => function($login) {
        $file = __DIR__ . '/../data/data.json';
        $data = json_decode(file_get_contents($file), true);
        
        foreach ($data['utilisateurs'] as $user) {
            if ($user['nom'] === $login) {
                return $user;
            }
        }
        return null;
    },
    
    "updatePassword" => function($login, $newPassword) {
        $file = __DIR__ . '/../data/data.json';
        $data = json_decode(file_get_contents($file), true);

        foreach ($data['utilisateurs'] as &$user) {
            if ($user['nom'] === $login) {
                $user['mot_de_passe'] = $newPassword;
                break;
            }
        }

        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
    }
];
