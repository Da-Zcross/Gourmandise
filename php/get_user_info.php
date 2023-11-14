<?php
session_start();

// Vérifier si l'utilisateur est connecté et s'il s'agit d'un client ou d'un administrateur
if (isset($_SESSION['connected']) && $_SESSION['connected'] === true && isset($_SESSION['customerId'])) {
    require_once("db_connect.php");

    // Récupérer l'ID du client connecté depuis la session
    $customerId = $_SESSION['customerId'];
    $db = new PDO("mysql:host=localhost;dbname=gourm;charset=utf8", "root", "");

    // Préparer et exécuter une requête SELECT pour récupérer les informations de l'utilisateur
    $stmt = $db->prepare("SELECT FirstName, LastName, Admin FROM Customers WHERE CustomerId = ?");
    $stmt->execute([$customerId]);

    // Récupérer les informations de l'utilisateur sous forme de tableau associatif
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'utilisateur est un administrateur ou un client normal
    $role = $user['Admin'] ? "Admin" : "Customer";
print_r($_SESSION);
    // Afficher les informations de l'utilisateur
    echo "Bonjour " . $user['FirstName'] . " " . $user['LastName'] . ". Vous êtes un " . $role . ".";
} else {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: login.php");
    exit;
}
?>
