<?php
// Connexion à la base de données et autres configurations
require_once("db_connect.php");
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $method=$_GET;

}
 else $method=$_POST;


    //? En fonction du paramètre "choice" de ma requête j'execute les instructions de la case correspondante
switch ($method["choice"]) {
    case 'select':
        // Je récupère tous les utilisateurs
        $req = $db->query("SELECT * FROM fruits");

        // J'affecte la totalité de mes résultats à la variable $fruit
        $fruits = $req->fetchAll(PDO::FETCH_ASSOC);

        // J'envoie une réponse avec un success true ainsi que les utilisateurs
        echo json_encode(["success" => true, "fruits" => $fruits]);
        break;
        
          default:
        //! Aucune case ne correspond à mon choix
        // J'envoie une réponse avec un success false et un message d'erreur
        echo json_encode(["success" => false, "error" => "Ce choix n'existe pas"]);
        break;
}





?>
