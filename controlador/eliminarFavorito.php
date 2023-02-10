<?php  
    require_once "config.php";
    include_once "../inc/conn.php";
    include_once "funciones.php";

    global $db;

    $idUsuario = "";

    if (isset($_SESSION["idUsuario"])) {
        $idUsuario = $_SESSION["idUsuario"];
    } elseif (isset($_SESSION["id"])) {
        $idUsuario = $_SESSION["id"];
    }
    // elseif (isset($_SESSION["user_id"])) {
    //     $idUsuario = $_SESSION["user_id"];
    // }

    $idProducto = intval($_GET["id"]);

    echo eliminarFavorito($db, $idProducto, $idUsuario);
?>