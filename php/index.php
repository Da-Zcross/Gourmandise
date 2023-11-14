<?php
// Démarrer la session sur chaque page où vous avez besoin de récupérer les informations de session.
session_start();

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['connected'])) {
    // Récupérer le rôle de l'utilisateur depuis la session
    $role = $_SESSION['role'];

    if ($role === 'Admin') {
        // Afficher les fonctionnalités spécifiques à l'administrateur
        echo "Bienvenue Admin ! Vous avez la main sur tout.";
    } elseif ($role === 'Customers') {
        // Afficher les fonctionnalités spécifiques aux Customers (utilisateurs normaux)
        echo "Bienvenue Customers ! Vous avez des droits limités.";
    } else {
        // Au cas où le rôle n'est pas correctement défini, afficher un message générique
        echo "Bienvenue !";
    }
} else {
    // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: login.php");
    exit();
}
?>
