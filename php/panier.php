<?php
session_start();

// Vérifier si le panier de fruits existe dans la session, sinon le créer
if (!isset($_SESSION['fruits'])) {
    $_SESSION['fruits'] = array();
}

// Fonction pour ajouter un fruit au panier
function ajouterAuPanier($reference, $denomination, $price)
{
    $_SESSION['fruits'][] = array(
        'reference' => $reference,
        'denomination' => $denomination,
        'prix' => $price
    );

    // Répondre avec un message JSON pour indiquer que le fruit a été ajouté au panier
    echo json_encode(array('message' => 'Le fruit a été ajouté au panier.'));
}

// Fonction pour supprimer un fruit du panier
function supprimerDuPanier($reference)
{
    foreach ($_SESSION['fruits'] as $key => $fruit) {
        if ($fruit['reference'] == $reference) {
            unset($_SESSION['fruits'][$key]);
            break;
        }
    }

    // Répondre avec un message JSON pour indiquer que le fruit a été supprimé du panier
    echo json_encode(array('message' => 'Le fruit a été supprimé du panier.'));
}

// Gérer les actions en fonction de la requête
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'ajouterAuPanier' && isset($_POST['reference']) && isset($_POST['denomination']) && isset($_POST['price'])) {
        $reference = $_POST['reference'];
        $denomination = $_POST['denomination'];
        $price = floatval($_POST['price']);

        ajouterAuPanier($reference, $denomination, $price);
    }

    if ($action === 'supprimerDuPanier' && isset($_POST['reference'])) {
        $reference = $_POST['reference'];
        supprimerDuPanier($reference);
    }
}

// Calculer le montant total du panier
function getTotalPanier()
{
    $total = 0;
    foreach ($_SESSION['fruits'] as $fruit) {
        $total += $fruit['prix'];
    }
    return $total;
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Les balises meta et les liens CSS vont ici -->
</head>
<body>
    <!-- Le contenu HTML de votre page, y compris l'affichage du panier et les boutons de paiement -->
</body>
</html>
