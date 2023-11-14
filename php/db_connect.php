<?php

//* Paramètres de connexion à la base de données

$host = "localhost"; 

$username = "root"; 
$password = ""; 

$dbname = "gourm"; 

 

//? J'exécute les instructions dans le try, si il y a une erreur elle est attrapée dans le catch qui va l'afficher

try {

   

    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

   

} catch (ErrorException $e) {

    echo $e;

}