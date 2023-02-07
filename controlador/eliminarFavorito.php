<?php  
    require_once "config.php";
    include_once "../inc/conn.php";

    global $db;

    $idProducto = $_GET["id"];

    if (isset($_SESSION["idUsuario"])){ //si se inició sesion desde una cuenta nativa
        $idUsuario = $_SESSION["idUsuario"];
    }
    else if (isset($_SESSION["id"])){ //Si se inicio sesion desde Google
        $idUsuario = $_SESSION["id"];
    }
    // else if (isset($_SESSION["user_id"])){ //Si se inicio sesion desde twitter
    //     $idUsuario = $_SESSION["user_id"];
    // }

    if (!isset($_SESSION["idUsuario"])){
        $sql = "SELECT u.id
                FROM usuario as u
                INNER JOIN usuario_rs as rs ON rs.id = u.id
                WHERE rs.id_social = $idUsuario
        ";

        $rs = $db->query($sql);

        foreach ($rs as $row){
            $idUsuario = $row["id"];
        }
    }

    $sql = "DELETE FROM favorito
            WHERE (id_producto = '$idProducto' AND id_usuario = '$idUsuario')
    ";
    
    $rs = $db->query($sql);

    $datos = "ok";

    echo $datos;
?>