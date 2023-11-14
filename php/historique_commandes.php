<?php
// Inclure la connexion à la base de données
require_once "db_connect.php";

// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["CustomerId"])) {
    // Rediriger l'utilisateur vers la page de connexion si non connecté
    header("Location:../login/login.html");
    exit();
}

// Récupérer l'ID du client connecté
$customerId = $_SESSION["CustomerId"];

// Requête SQL pour récupérer l'historique des commandes du client
$sql = "SELECT * FROM Orders WHERE CustomerId = ? ORDER BY OrderDateTime DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customerId);
$stmt->execute();
$result = $stmt->get_result();

// Fermer la connexion
$stmt->close();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Commandes</title>
</head>
<body>
    <header>
        <h1>Historique des Commandes</h1>
    </header>

    <main>
        <section>
            <h2>Vos commandes passées :</h2>
            <ul>
                <?php
                // Parcourir les résultats de la requête et afficher les commandes
                while ($row = $result->fetch_assoc()) {
                    $orderDate = date("Y-m-d", strtotime($row["OrderDateTime"]));
                    $orderAmount = calculateOrderAmount($row["OrderId"]);
                    echo "<li>Commande du $orderDate - Montant : $orderAmount EUR</li>";
                }
                ?>
            </ul>
        </section>
    </main>

    <footer>
        <p>© Gourmandise</p>
    </footer>


</body>
</html>

<?php
// Fonction pour calculer le montant total d'une commande
function calculateOrderAmount($orderId) {
    // Inclure la connexion à la base de données
    require "db_connect.php";

    $sql = "SELECT SUM(f.Price) AS totalAmount
            FROM OrderFruits ofr
            JOIN Fruits f ON ofr.ProductId = f.ProductId
            WHERE ofr.OrderId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Fermer la connexion
    $stmt->close();

    return number_format($row["totalAmount"], 2);
}
?>
