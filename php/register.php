    <?php
    //! Permet l'affichage des erreurs - À ne pas commettre en production
    error_reporting(-1);

    //? J'intègre le contenu du fichier de connexion à ma bdd dans mon fichier actuel
    require_once("db_connect.php");
    $db = new PDO("mysql:host=localhost;dbname=gourm;charset=utf8", "root", "");

    //? Si ma méthode de requête est différente de POST
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        // J'envoie une réponse avec un success false et un message d'erreur
        echo json_encode(["success" => false, "error" => "Mauvaise méthode"]);
        die;
    }

    //? Si mes paramètres nécessaires à l'inscription n'existent pas alors
    if (!isset($_POST["FirstName"], $_POST["LastName"], $_POST["BirthDate"], $_POST["StreetNumber"], $_POST["StreetName"], $_POST["PostalCode"], $_POST["City"], $_POST["PhoneNumber"],$_POST["Email"], $_POST["Password"])) {
        // J'envoie une réponse avec un success false et un message d'erreur
        echo json_encode(["success" => false, "error" => "Données manquantes"]);
        die; //! J'arrête l'exécution du script
    }

    //? Si au moins un des paramètres est vide alors
    if (
        empty(trim($_POST["FirstName"])) ||
        empty(trim($_POST["LastName"])) ||
        empty(trim($_POST["BirthDate"])) ||
        empty(trim($_POST["StreetNumber"])) ||
        empty(trim($_POST["StreetName"])) ||
        empty(trim($_POST["PostalCode"])) ||
        empty(trim($_POST["City"])) ||
        empty(trim($_POST["PhoneNumber"])) ||
        empty(trim($_POST["Email"])) ||
        empty(trim($_POST["Password"]))
    ) {
        // J'envoie une réponse avec un success false et un message d'erreur
        echo json_encode(["success" => false, "error" => "Données vides"]);
        die; //! J'arrête l'exécution du script
    }

    $regex = "/^[a-zA-Z0-9-+._]+@[a-zA-Z0-9-]{2,}\.[a-zA-Z]{2,}$/";
    //? Si mon email ne correspond pas à l'ER alors
    if (!preg_match($regex, $_POST["Email"])) {
        // J'envoie une réponse avec un success false et un message d'erreur
        echo json_encode(["success" => false, "error" => "Email au mauvais format"]);
        die; //! J'arrête l'exécution du script
    }

    $regex = "/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])[a-zA-Z0-9]{8,12}$/";
    //? Si mon mot de passe ne correspond pas à l'ER alors
    if (!preg_match($regex, $_POST["Password"])) {
        // J'envoie une réponse avec un success false et un message d'erreur
        echo json_encode(["success" => false, "error" => "Mot de passe au mauvais format"]);
        die; //! J'arrête l'exécution du script
    }

    // Je hash le mot de passe avec la méthode par défaut
    $hash = password_hash($_POST["Password"], PASSWORD_DEFAULT);

    // J'écris la requête préparée d'insertion du nouvel utilisateur
    $req = $db->prepare("INSERT INTO Customers(LastName, FirstName, BirthDate, StreetNumber, StreetName, PostalCode, City, PhoneNumber, Email,  Password) VALUES (:lastname, :firstname, :birthdate, :streetnumber, :streetname, :postalcode, :city, :phonenumber, :email, :password)");
    // J'affecte à chaque clé les valeurs correspondantes grâce au bindValue
    $req->bindValue(":lastname", $_POST["LastName"]);
    $req->bindValue(":firstname", $_POST["FirstName"]);
    $req->bindValue(":birthdate", $_POST["BirthDate"]);
    $req->bindValue(":streetnumber", $_POST["StreetNumber"]);
    $req->bindValue(":streetname", $_POST["StreetName"]);
    $req->bindValue(":postalcode", $_POST["PostalCode"]);
    $req->bindValue(":city", $_POST["City"]);
    $req->bindValue(":phonenumber", $_POST["PhoneNumber"]);
    $req->bindValue(":email", $_POST["Email"]);
    $req->bindValue(":password", $hash);
    // $req->execute();

    if ($req->rowCount()) {
        echo json_encode(["success" => true]);
    }
    ?>
