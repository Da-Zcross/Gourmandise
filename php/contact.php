<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $telephone = $_POST["telephone"];
    $email = $_POST["email"];
    $message = $_POST["message"];
    
    // Adresse e-mail de destination
    $destinataire = "dzellatkodiadassise@gmail.com";
    
    // Sujet de l'e-mail
    $sujet = "Nouveau message depuis le formulaire de contact de votre site";
    
    // Contenu de l'e-mail
    $contenu = "Nom: $nom\n" .
               "Téléphone: $telephone\n" .
               "E-mail: $email\n" .
               "Message:\n$message";
    
    // Envoi de l'e-mail
    mail($destinataire, $sujet, $contenu);
    
    // Redirection vers une page de confirmation
    header("Location: ../html/contact.html");
    exit;
}
?>
