<?php  
    require_once "config.php";
    include_once "../inc/conn.php";
    include_once "funciones.php";

    global $db;

    $id_usuario = "";

    if (isset($_SESSION["idUsuario"])) {
        $id_usuario = $_SESSION["idUsuario"];
    } elseif (isset($_SESSION["id"])) {
        $id_usuario = $_SESSION["id"];
    }
    // elseif (isset($_SESSION["user_id"])) {
    //     $id_usuario = $_SESSION["user_id"];
    // }

    $id_producto = intval($_GET["id"]);

    echo eliminar_favorito($db, $id_producto, $id_usuario);
?>