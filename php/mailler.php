<?php
// Inclure la bibliothèque PHPMailer
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

// Créer une nouvelle instance de PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();

// Paramètres SMTP pour Gmail
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com'; // Serveur SMTP de Gmail
$mail->SMTPAuth = true;
$mail->Username = 'dzelatkodiadassise@gmail.com'; // Votre adresse e-mail Gmail
$mail->Password = 'votre_mot_de_passe'; // Mot de passe de votre compte Gmail
$mail->SMTPSecure = 'tls'; // Utiliser TLS
$mail->Port = 587; // Port SMTP de Gmail

// Paramètres de l'expéditeur et du destinataire
$mail->setFrom('votre_adresse_email@gmail.com', 'Votre Nom'); // Adresse d'expéditeur
$mail->addAddress('dzellatkodiadassise@gmail.com', 'Destinataire'); // Adresse du destinataire
$mail->addReplyTo('votre_adresse_email@gmail.com', 'Votre Nom'); // Adresse de réponse

// Contenu du message
$mail->isHTML(true); // Utiliser le format HTML pour le message
$mail->Subject = 'Sujet de l\'e-mail'; // Sujet de l'e-mail
$mail->Body = '<h1>Contenu du message</h1><p>Ceci est un e-mail de test.</p>'; // Contenu du message au format HTML

// Vérifier si l'e-mail a été envoyé avec succès
if ($mail->send()) {
    echo 'L\'e-mail a été envoyé avec succès.';
} else {
    echo 'Une erreur s\'est produite lors de l\'envoi de l\'e-mail : ' . $mail->ErrorInfo;
}
?>
