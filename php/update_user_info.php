<?php
// Démarrer la session pour accéder aux données de session
session_start();

// Vérifier si l'utilisateur est connecté et s'il s'agit d'un client ou d'un administrateur
if (isset($_SESSION['connected']) && $_SESSION['connected'] == 1 && isset($_SESSION['customerId'])) {
    // Inclure ici le code de connexion à la base de données
    require_once("db_connect.php");

    // Récupérer les nouvelles informations de l'utilisateur à partir des données POST
    $newFirstName = $_POST['firstname'];
    $newLastName = $_POST['lastname'];
    $newBirthdate = $_POST['birthdate'];
    $newStreetNumber = $_POST['streetnumber'];
    $newStreetName = $_POST['streetname'];
    $newPostalCode = $_POST['postalcode'];
    $newCity = $_POST['city'];
    $newPhoneNumber = $_POST['phonenumber'];
    $newEmail = $_POST['email'];
    $newPassword = $_POST['password'];

    // Récupérer l'ID de l'utilisateur connecté
    $CustomerId = $_SESSION['customerId'];

    // Préparer et exécuter une requête UPDATE pour mettre à jour les informations de l'utilisateur
    $stmt = $db->prepare("UPDATE Customers SET FirstName = ?, LastName = ?, Birthdate = ?, StreetNumber = ?, StreetName = ?, PostalCode = ?, City = ?, PhoneNumber = ?, Email = ?, Password = ? WHERE CustomerId = ?");
    $stmt->execute([$newFirstName, $newLastName, $newBirthdate, $newStreetNumber, $newStreetName, $newPostalCode, $newCity, $newPhoneNumber, $newEmail, $newPassword, $CustomerId]);

    // Répondre avec un message JSON indiquant que la mise à jour a été effectuée
    echo json_encode(["success" => true, "message" => "Vos informations ont été mises à jour avec succès."]);
} else {
    // L'utilisateur n'est pas connecté ou non autorisé
    echo json_encode(["success" => false, "message" => "Vous n'êtes pas connecté ou non autorisé."]);
}

?>
