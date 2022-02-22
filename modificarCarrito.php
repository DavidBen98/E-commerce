<?php  
    require_once 'config.php';
    include_once ("inc/conn.php");
    require_once 'vendor/autoload.php';

    MercadoPago\SDK::setAccessToken('TEST-5976931908635341-011902-66f238a2e8fba7fb50819cd40a6ecef9-172145106');

    if ((isset($_POST['id'])) && (isset($_POST['cantidad']))){
        $id = $_POST['id'];
        $cantidad = $_POST['cantidad'];

        if (isset($_SESSION['carrito']['productos'][$id])){
            $_SESSION['carrito']['productos'][$id] = $cantidad;
        }

        global $preference; 
        $datos['numero'] = count ($_SESSION['carrito']['productos']);
        $datos['ok'] = true;
        $datos['item'] = $preference->items[0];
    }
    else{
        $datos['ok'] = false;
    }

    echo json_encode ($datos);
?>