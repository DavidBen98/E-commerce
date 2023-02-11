<?php  
    require_once "config.php";

    if (isset($_POST["id"])){
        $id = htmlspecialchars($_POST["id"]);

        if (isset($_SESSION["carrito"]["productos"][$id])){
            $_SESSION["carrito"]["productos"][$id] += 1;
        }
        else{
            $_SESSION["carrito"]["productos"][$id] = 1;    
        }

        $datos["numero"] = count ($_SESSION["carrito"]["productos"]);
        $datos["ok"] = true;
    }
    else{
        $datos["ok"] = false;
    }

    echo json_encode ($datos);
?>