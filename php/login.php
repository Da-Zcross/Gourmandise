<?php
//! Permet l'affichage des erreurs - A ne pas commit
error_reporting(-1);

//? Permet de démarrer la session sur ce fichier et donc d'utiliser la superglobale $_SESSION
session_start();

//? J'intègre le contenu du fichier de connexion à ma bdd dans mon fichier actuel
require_once("db_connect.php");

//? Si je n'ai pas les paramètres "email" et "pwd" dans ma superglobale $_POST alors
if (!isset($_POST["email"], $_POST["password"])) {
    echo json_encode(["success" => false, "error" => "Données manquantes"]);
    die; //! J'arrête l'exécution du script
}

//? Si les paramètres "email" et "pwd" dans ma superglobale $_POST sont vides alors
if (empty(trim($_POST["email"])) || empty(trim($_POST["password"]))) {
    echo json_encode(["success" => false, "error" => "Données vides"]);
    die; //! J'arrête l'exécution du script
}
$db = new PDO("mysql:host=localhost;dbname=gourm;charset=utf8", "root", "");
// J'écris ma requête préparée pour sélectionner toutes les données de l'utilisateur
$req = $db->prepare("SELECT * FROM Customers WHERE Email = ?");
$req->execute([$_POST["email"]]);

// J'affecte à ma variable $user le résultat unique (ou pas de résultat) de ma requête SQL
$customers = $req->fetch(PDO::FETCH_ASSOC);

//? Si ma variable $customer a une valeur ET que le mot de passe correspond au hash de celui de l'utilisateur alors
if ($customers && password_verify($_POST["password"], $customers["Password"])) {
    $_SESSION["connected"] = true; // J'affecte à la clé "connected" la valeur true
    $_SESSION["customerId"] = $customers["CustomerId"]; // J'affecte à la clé "customerId" la valeur de l'id de l'utilisateur qui vient de se connecter
    $_SESSION["role"] = $customers["Admin"]; // J'affecte à la clé "role" le rôle de l'utilisateur (Admin ou Customers)


     // J'envoie une réponse avec un success true et les données de l'utilisateur
    echo json_encode(["success" => true, "customers" => $customers]);

} else {
    // Je vide ma session
    $_SESSION = [];
    session_destroy();

    // J'envoie une réponse avec un success false et un message d'erreur
    echo json_encode(["success" => false, "error" => "Aucun utilisateur"]);
}
?>
