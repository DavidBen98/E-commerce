<?php  
    require_once 'config.php';
    include_once ("inc/conn.php");

    global $db;

    $id_prod = $_GET['id'];

    if (isset($_SESSION['idUsuario'])){ //si se inició sesion desde una cuenta nativa
        $id_usuario = $_SESSION['idUsuario'];
    }
    else if (isset($_SESSION['id'])){ //Si se inicio sesion desde Google
        $id_usuario = $_SESSION['id'];
    }
    else if (isset($_SESSION["user_id"])){ //Si se inicio sesion desde twitter
        $id_usuario = $_SESSION["user_id"];
    }

    if (!isset($_SESSION['idUsuario'])){
        $sql = "SELECT u.id
                FROM usuarios as u
                INNER JOIN usuarios_rs as rs ON rs.id = u.id
                WHERE rs.id_social = $id_usuario
        ";

        $rs = $db->query($sql);

        foreach ($rs as $row){
            $id_usuario = $row['id'];
        }
    }

    $sql = "SELECT id_producto
            FROM favorito
            WHERE $id_prod NOT IN(SELECT id_producto
                                  FROM favorito
                                  WHERE id_usuario = $id_usuario)
    ";
    
    $rs = $db->query($sql);

    $i = 0;
    foreach ($rs as $row){
        $i++;
    }

    if ($i == 0){
        $sql = "INSERT INTO `favorito`(`id_producto`, `id_usuario`) VALUES ('$id_prod','$id_usuario')";

        $rs = $db->query ($sql);
    }

    header ('location:index.php');

?>