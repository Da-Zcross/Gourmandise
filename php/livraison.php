<?php
session_start();

// Vérifier si le panier de fruits existe dans la session
if (isset($_SESSION['fruits']) && !empty($_SESSION['fruits'])) {
    $totalPanier = getTotalPanier();
} else {
    // Rediriger l'utilisateur vers la page des fruits s'il n'y a pas de fruits dans le panier
    header("Location: ../html/fruit.html");
    exit();
}

function getTotalPanier()
{
    $total = 0;
    foreach ($_SESSION['fruits'] as $fruit) {
        $total += $fruit['prix'];
    }
    return $total;
}

// Traiter les informations de livraison si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si toutes les informations nécessaires sont fournies (vous pouvez ajouter plus de validations si nécessaire)
    if (isset($_POST['FirstName']) && isset($_POST['StreetNumber']) && isset($_POST['City']) ) {
        $nom = $_POST['Fistname'];
        $adresse = $_POST['adresse'];
        $ville = $_POST['City'];

        // Vous pouvez ajouter ici le code pour sauvegarder les informations de livraison dans une base de données ou les traiter d'une autre manière selon vos besoins.

        // Réinitialiser le panier après la livraison (simulé ici, vous pouvez le modifier pour répondre à vos besoins réels)
        unset($_SESSION['fruits']);

        // Rediriger vers une page de confirmation ou de remerciement après la livraison
        header("Location: ../html/confirmation.html");
        exit();
    } else {
        // Rediriger l'utilisateur vers le formulaire de livraison avec un message d'erreur s'il manque des informations
        header("Location: ../html/livraison.html?error=missing_info");
        exit();
    }
}
?>
