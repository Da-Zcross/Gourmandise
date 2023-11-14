<?php
session_start();
require_once("../php/db_connect.php"); // Inclure la connexion à la base de données

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['connected']) && $_SESSION['connected'] == true) {
    // Vérifier si l'utilisateur est administrateur (vous devez avoir une colonne "Admin" dans votre table Customers)
    $stmt = $db->prepare("SELECT Admin FROM Customers WHERE CustomerId = ?");
    $stmt->execute([$_SESSION['customerId']]);
    $isAdmin = $stmt->fetchColumn();

    if ($isAdmin == 1) { // Si l'utilisateur est administrateur
        // Récupérer l'action à partir de la requête POST
        $action = $_POST['action'];

        if ($action === 'addUser') {
            // Récupérer les données du formulaire
            $firstName = $_POST['firstname'];
            $lastName = $_POST['lastname'];
            $birthdate = $_POST['birthdate'];
            $streetNumber = $_POST['streetnumber'];
            $streetName = $_POST['streetname'];
            $postalCode = $_POST['postalcode'];
            $city = $_POST['city'];
            $phoneNumber = $_POST['phonenumber'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Hacher le mot de passe
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insérer les données dans la base de données pour l'ajout
            $stmt = $db->prepare("INSERT INTO Customers (LastName, FirstName, BirthDate, StreetNumber, StreetName, PostalCode, City, PhoneNumber, Email, Password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$lastName, $firstName, $birthdate, $streetNumber, $streetName, $postalCode, $city, $phoneNumber, $email, $hashedPassword]);

            echo json_encode(["success" => true, "message" => "Utilisateur ajouté avec succès."]);
        } elseif ($action === 'deleteUser') {
            $customerId = $_POST['CustomerId'];

            // Supprimer l'utilisateur de la base de données pour la suppression
            $stmt = $db->prepare("DELETE FROM Customers WHERE CustomerId = ?");
            $stmt->execute([$customerId]);

            echo json_encode(["success" => true, "message" => "Utilisateur supprimé avec succès."]);
        } elseif ($action === 'getUsers') {
            // Récupérer la liste des utilisateurs depuis la base de données
            $stmt = $db->prepare("SELECT * FROM Customers");
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($users);
        } else {
            echo json_encode(["success" => false, "message" => "Action non reconnue."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Vous n'avez pas les autorisations d'administrateur pour effectuer cette action."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Vous n'êtes pas connecté en tant qu'administrateur."]);
}
?>
