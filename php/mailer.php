<?php
// J'utilise PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
// J'utilise les erreurs de PHPMailer
use PHPMailer\PHPMailer\Exception;

// J'intègre obligatoirement mon fichier autoload (du dossier vendor)
require("../vendor/autoload.php");

/**
 * @desc Permet d'envoyer un mail
 * @param string $to - Destinataire du mail
 * @param string $subject - Sujet du mail
 * @param string $body - Corps du mail
 * @return bool - Renvoie true si l'e-mail a été envoyé avec succès, sinon false.
 */
function mailer($to, $subject, $body)
{
    // Je crée une nouvelle instance de PHPMailer
    $mail = new PHPMailer();

    //? J'exécute les instructions dans le try, si il y a une erreur elle est attrapée dans le catch qui va l'afficher
    try {
        $mail->IsSMTP(); // Simple Mail Transfer Protocol
        $mail->SMTPDebug = 0; // Débug
        $mail->SMTPAuth = true; // Authentification nécessaire
        $mail->SMTPSecure = "tls"; // Sécurité de la couche de transport 
        $mail->Host = "smtp-mail.outlook.com"; // Adresse du host
        $mail->Port = 587; // Port du host
        $mail->Username = "votre_email@example.com"; // Mail de connexion
        $mail->Password = "votre_mot_de_passe"; // Mot de passe de connexion
        $mail->SetFrom("votre_email@example.com", "Votre_Nom"); // Mail de l'expéditeur et Prénom Nom
        $mail->Subject = $subject; // Sujet du mail
        $mail->Body = $body; // Corps du mail
        $mail->AddAddress($to); // Ajout des destinataires

        // J'envoie le mail
        $success = $mail->send();

        // Renvoie true si l'e-mail a été envoyé avec succès, sinon false
        return $success;
    } catch (Exception $e) { //! Si erreur je la stocke dans la variable $e
        // Afficher l'erreur
        echo "error: {$mail->ErrorInfo}";
        return false; // Renvoyer false en cas d'erreur
    }
}

// Utilisation de la fonction mailer()
$to = "destinataire@example.com";
$subject = "Sujet du mail";
$body = "Corps du mail";
$success = mailer($to, $subject, $body);

// Vérifier si l'e-mail a été envoyé avec succès
if ($success) {
    echo "L'e-mail a été envoyé avec succès!";
} else {
    echo "Une erreur s'est produite lors de l'envoi de l'e-mail.";
}
?>
