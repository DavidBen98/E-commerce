<?php
    require 'config.php';
    include("encabezado.php"); 
    include("pie.php"); 
    require 'inc/conn.php';
    require 'vendor/autoload.php';

    MercadoPago\SDK::setAccessToken('TEST-5976931908635341-011902-66f238a2e8fba7fb50819cd40a6ecef9-172145106');

    global $db;  

    $productos = isset ($_SESSION['carrito']['productos'])? $_SESSION['carrito']['productos'] : null;

    $lista_carrito = array();

    if ($productos != null){
        foreach ($productos as $clave => $cantidad){
            $sql = $db->prepare("SELECT id, nombre, precio, descuento, $cantidad AS c
                                FROM productos WHERE id=?");
            $sql->execute([$clave]);
            $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
        }
    }
    else{
        header('location: index.php');
        exit;
    }
?>