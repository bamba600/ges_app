<?php

$model = function () {
    return [

        'activatePromoByName' => function ($nom) {
            $file = __DIR__ . '/../data/data.json';

            // Lire le fichier JSON
            $data = json_decode(file_get_contents($file), true);

            if ($data === null) {
                die("Erreur de lecture du fichier JSON.");
            }

            // Vérifier si la promotion est déjà active
            $dejaActive = false;
            foreach ($data['promotions'] as $promo) {
                if ($promo['nom'] === $nom && $promo['active']) {
                    $dejaActive = true;
                    break;
                }
            }

            // Si elle est déjà active, ne rien faire
            if ($dejaActive) {
                return;
            }

            // Sinon, activer celle sélectionnée et désactiver toutes les autres
            foreach ($data['promotions'] as &$promo) {
                $promo['active'] = ($promo['nom'] === $nom);
            }

            // Écrire les modifications dans le fichier JSON
            if (file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT)) === false) {
                die("Erreur d'écriture dans le fichier JSON.");
            }
        }

    ];
};
