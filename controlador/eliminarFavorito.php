<?php  
    require_once "config.php";
    include_once "../inc/conn.php";
    include_once "funciones.php";

    global $db;

    // function deleteFavorito($db, $idProducto, $idUsuario) {
    //     $idUsuario = intval($idUsuario);
    //     if (!isset($_SESSION["idUsuario"])){
    //         $sql = "SELECT id
    //                 FROM usuario
    //                 WHERE id_social = ?";
    //         $stmt = $db->prepare($sql);
    //         $stmt->bind_param("i", $idUsuario);
    //         $stmt->execute();
    //         $stmt->bind_result($idUsuario);
    //         $stmt->fetch();
    //         $stmt->close();
    //     }

    //     $sql = "DELETE FROM favorito
    //             WHERE (id_producto = ? AND id_usuario = ?)";
    //     $stmt = $db->prepare($sql);
    //     $stmt->bind_param("ii", $idProducto, $idUsuario);
    //     $stmt->execute();
    //     $stmt->close();

    //     return "ok";
    // }

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