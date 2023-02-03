<?php  
    require_once 'config.php';

    if (isset($_POST['id'])){
        $id = $_POST['id'];

        unset($_SESSION['carrito']['productos'][$id]);

        $datos['numero'] = count ($_SESSION['carrito']['productos']);
        $datos['ok'] = true;
    }
    else{
        $datos['ok'] = false;
    }

    echo json_encode ($datos);
?>