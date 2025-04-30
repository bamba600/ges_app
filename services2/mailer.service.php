<?php
// Fichier : app/services2/mailer.service.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../phpmailer/PHPMailer.php';
require_once __DIR__ . '/../phpmailer/SMTP.php';
require_once __DIR__ . '/../phpmailer/Exception.php';

/**
 * Envoie un email via PHPMailer
 * 
 * @param string $to Adresse email du destinataire
 * @param string $subject Sujet de l'email
 * @param string $body Corps du message (HTML supporté)
 * @param string $altBody Corps du message en texte brut (optionnel)
 * @return bool Succès de l'envoi
 */
function sendMail($to, $subject, $body, $altBody = '') {
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 0; // Affiche les détails (à désactiver en production)
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'nafissatou3582@gmail.com';
        $mail->Password   = 'dwvicwzcjwzjaeng'; // mot de passe d'application, OK
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('fpapi5148@gmail.com', 'Système de Gestion des Apprenants');
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        if (!empty($altBody)) {
            $mail->AltBody = $altBody;
        }

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo; // Affiche l'erreur
        return false;
    }
}

/**
 * Envoie un email de confirmation d'inscription à un apprenant
 * 
 * @param array $apprenant Données de l'apprenant
 * @return bool Succès de l'envoi
 */
function envoyerEmailConfirmation($apprenant) {
    $to = $apprenant['email'];
    $subject = "Confirmation d'inscription";
    
    // Corps HTML du message
    $body = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
            h1 { color: #333; }
            .details { background-color: #f9f9f9; padding: 15px; border-radius: 5px; margin: 20px 0; }
            .footer { margin-top: 20px; font-size: 12px; color: #777; }
        </style>
    </head>
    <body>
        <div class='container'>
            <h1>Bienvenue {$apprenant['prenom']} {$apprenant['nom']} !</h1>
            <p>Votre compte a été créé avec succès dans notre système de gestion des apprenants.</p>
            
            <div class='details'>
                <p><strong>Matricule :</strong> {$apprenant['matricule']}</p>
                <p><strong>Login :</strong> {$apprenant['login']}</p>
                <p><strong>Mot de passe :</strong> {$apprenant['mot_de_passe']}</p>
                <p><strong>Référentiel :</strong> {$apprenant['referentiel']}</p>
            </div>
            
            <p>Nous vous souhaitons une excellente formation.</p>
            
            <div class='footer'>
                <p>Ceci est un message automatique, merci de ne pas y répondre.</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    // Corps texte brut (alternative)
    $altBody = "Bienvenue {$apprenant['prenom']} {$apprenant['nom']} !\n\n" .
               "Votre compte a été créé avec succès dans notre système de gestion des apprenants.\n\n" .
               "Matricule : {$apprenant['matricule']}\n" .
               "Login : {$apprenant['login']}\n" .
               "Mot de passe : {$apprenant['mot_de_passe']}\n" .
               "Référentiel : {$apprenant['referentiel']}\n\n" .
               "Nous vous souhaitons une excellente formation.\n\n" .
               "Ceci est un message automatique, merci de ne pas y répondre.";
    
    return sendMail($to, $subject, $body, $altBody);
}