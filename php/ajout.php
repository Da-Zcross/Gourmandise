<?php
error_reporting(-1);
require_once("db_connect.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $method = $_POST;
} else {
    $method = $_GET;
}

switch ($method["choice"]) {
    case 'select':
        
            $req = $db->query("SELECT f.*, c.Label AS CategoryLabel FROM Fruits AS f JOIN Categories AS c ON f.CategoryId = c.CategoryId");
            $fruits = $req->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode(["success" => true, "fruits" => $fruits]);
        
        break;

    case "select_id":
        if (!isset($method["ProductId"]) || empty(trim($method["ProductId"]))) {
            echo json_encode(["success" => false, "error" => "ProductId manquant"]);
            die();
        }

        try {
            $req = $db->prepare("SELECT * FROM Fruits WHERE ProductId = ?");
            $req->execute([$method["ProductId"]]);
            $fruit = $req->fetch(PDO::FETCH_ASSOC);

            echo json_encode(["success" => true, "fruit" => $fruit]);
        } catch (PDOException $e) {
            echo json_encode(["success" => false, "error" => "Erreur lors de la récupération du fruit"]);
        }

        break;
        
case 'insert':
    if (!isset($method["Denomination"], $method["Reference"], $method["Price"], $method["CategoryId"], $_FILES["images"])) {
        echo json_encode(["success" => false, "error" => "Données manquantes pour l'ajout"]);
        die();
    }

    $images = $_FILES["images"]["name"];
    // $imagesPath = "../images" . basename($images["name"]);

     
        $req = $db->prepare("INSERT INTO fruits (Denomination, Reference, Price, CategoryId,images) VALUES (?, ?, ?, ?,?)");
        $req->execute([$method["Denomination"], $method["Reference"], $method["Price"], $method["CategoryId"], $images]);

        // Déplacer l'image téléchargée vers le dossier approprié
        if (move_uploaded_file($images["tmp_name"], $imagesPath)) {
            echo json_encode(["success" => true,"images"=>$images]);
        } else {
            echo json_encode(["success" => false, "error" => "Erreur lors de l'ajout de l'image"]);
        }
    
        // echo json_encode(["success" => false, "error" => "Erreur lors de l'ajout du fruit"])

    break;

    case 'update':
        if (!isset($method["ProductId"], $method["Denomination"], $method["Reference"], $method["Price"], $method["CategoryId"])) {
            echo json_encode(["success" => false, "error" => "Données manquantes pour la mise à jour"]);
            die();
        }
    
        // Vérifiez si un nouveau fichier image a été téléchargé
        if (isset($_FILES["images"]) && !empty($_FILES["images"]["name"])) {
            $newImageName = $_FILES["images"]["name"];
            $newImagePath = "../images/" . $newImageName;
            
            // Déplacez le nouveau fichier image vers le dossier approprié
            if (move_uploaded_file($_FILES["images"]["tmp_name"], $newImagePath)) {
                // Mettez à jour le champ "images" dans la base de données
                try {
                    $req = $db->prepare("UPDATE Fruits SET Denomination = ?, Reference = ?, Price = ?, CategoryId = ?, images = ? WHERE ProductId = ?");
                    $req->execute([$method["Denomination"], $method["Reference"], $method["Price"], $method["CategoryId"], $newImageName, $method["ProductId"]]);
                    echo json_encode(["success" => true]);
                } catch (PDOException $e) {
                    echo json_encode(["success" => false, "error" => "Erreur lors de la mise à jour du fruit"]);
                }
            } else {
                echo json_encode(["success" => false, "error" => "Erreur lors de la mise à jour de l'image"]);
            }
        } else {
            // Si aucune nouvelle image n'a été téléchargée, mettez à jour les autres champs uniquement
            try {
                $req = $db->prepare("UPDATE Fruits SET Denomination = ?, Reference = ?, Price = ?, CategoryId = ? WHERE ProductId = ?");
                $req->execute([$method["Denomination"], $method["Reference"], $method["Price"], $method["CategoryId"], $method["ProductId"]]);
                echo json_encode(["success" => true]);
            } catch (PDOException $e) {
                echo json_encode(["success" => false, "error" => "Erreur lors de la mise à jour du fruit"]);
            }
        }
    
        break;
    

    

case 'images':
    if (!isset($method["Denomination"], $method["Reference"], $method["Price"], $method["CategoryId"], $_FILES["images"])) {
        echo json_encode(["success" => false, "error" => "Données manquantes pour l'ajout"]);
        die();
    }

    $simages = $_FILES["images"];
    $imagesPath = "../images" . basename($images["name"]);

    try {
        // Insérer d'abord les autres données du fruit dans la base de données
        $req = $db->prepare("INSERT INTO Fruits (Denomination, Reference, Price, CategoryId) VALUES (?, ?, ?, ?)");
        $req->execute([$method["Denomination"], $method["Reference"], $method["Price"], $method["CategoryId"]]);

        // Ensuite, déplacer l'image téléchargée vers le dossier approprié
        if (move_uploaded_file($images["tmp_name"], $imagesPath)) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => "Erreur lors de l'ajout de l'image"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => "Erreur lors de l'ajout du fruit"]);
    }

    break;




    case 'delete':
        if (!isset($method["ProductId"])) {
            echo json_encode(["success" => false, "error" => "ProductId manquant pour la suppression"]);
            die();
        }

        try {
            $req = $db->prepare("DELETE FROM Fruits WHERE ProductId = ?");
            $req->execute([$method["ProductId"]]);

            if ($req->rowCount()) {
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false, "error" => "Erreur lors de la suppression du fruit"]);
            }
        } catch (PDOException $e) {
            echo json_encode(["success" => false, "error" => "Erreur lors de la suppression du fruit"]);
        }

        break;

    default:
        echo json_encode(["success" => false, "error" => "Ce choix n'existe pas"]);
        break;
}
?>
