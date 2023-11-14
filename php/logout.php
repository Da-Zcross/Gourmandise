<?php
// Démarrer la session pour accéder aux données de session
session_start();

// Vider la session et déconnecter l'utilisateur
session_unset();
session_destroy();

// Rediriger vers la page de connexion
header("Location:../login/login.html");
exit();
?>
