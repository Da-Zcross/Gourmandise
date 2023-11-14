<?php
// Connexion à la base de données (Assurez-vous de personnaliser les informations de connexion)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gourm";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifiez si la connexion a réussi
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Récupérer les catégories "classique" et "exotique" depuis la table "Categories"
$sql = "SELECT * FROM Categories WHERE Denomination IN ('classique', 'exotique')";
$result = $conn->query($sql);

// Tableau pour stocker les catégories récupérées
$categories = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Fermer la connexion à la base de données
$conn->close();
?>
