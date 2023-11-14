<?php

session_start();
function Admin (){
    if($_SESSION["role"] ==0 )
    {
        echo json_encode(["success" => false, "error" => "Vous êtes pas Admin"]); 
    }
}