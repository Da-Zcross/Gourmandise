<?php
session_start();

// Vérifier si l'utilisateur est connecté et s'il s'agit d'un administrateur ou d'un client normal
if (isset($_SESSION['connected']) && $_SESSION['connected'] === true && isset($_SESSION['CustomerId'])) {
    // Inclure ici le code de connexion à la base de données
    require_once("db_connect.php");

    // Récupérer l'ID de l'utilisateur connecté
    $CustomerId = $_SESSION['CustomerId'];

    // Vérifier le rôle de l'utilisateur (Admin ou Customers)
    $role = ($_SESSION['role'] === 'Admin') ? 'Admin' : 'Customers';
    $db = new PDO("mysql:host=localhost;dbname=gourm;charset=utf8", "root", "");
    // Préparer et exécuter une requête SELECT pour récupérer les informations de l'utilisateur
    $stmt = $db->prepare("SELECT * FROM Customers WHERE CustomerId = ?");
    $stmt->execute([$CustomerId]);

    // Récupérer les informations de l'utilisateur sous forme de tableau associatif
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Envoyer les informations de l'utilisateur en réponse JSON
    echo json_encode(["success" => true, "user" => $user, "role" => $role]);
} else {
    // L'utilisateur n'est pas connecté ou non autorisé
    echo json_encode(["success" => false]);
}
?>
