<?php
// delete_account.php

session_start();

if (isset($_POST["deleteAccount"]) && $_POST["deleteAccount"] === "1") {

    // Après avoir supprimé le compte, vous voudrez peut-être déconnecter l'utilisateur et le rediriger vers la page de connexion
    session_unset();
    session_destroy();
    header("Location:../php/login.php");
    exit();
} else {
    // Gérez d'autres scénarios ou redirigez vers une page d'erreur si nécessaire
    header("Location: ../php/compte.php");
    exit();
}
