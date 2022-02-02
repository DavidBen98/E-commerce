<?php  
    require_once 'config.php';

    if ((isset($_POST['id'])) && (isset($_POST['cantidad']))){
        $id = $_POST['id'];
        $cantidad = $_POST['cantidad'];

        if (isset($_SESSION['carrito']['productos'][$id])){
            $_SESSION['carrito']['productos'][$id] = $cantidad;
        }

        $datos['numero'] = count ($_SESSION['carrito']['productos']);
        $datos['ok'] = true;
    }
    else{
        $datos['ok'] = false;
    }

    echo json_encode ($datos);
?>