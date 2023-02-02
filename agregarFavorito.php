<?php  
    require_once 'config.php';
    include_once ("inc/conn.php");
    require_once('funciones.php');
    
    if (perfil_valido(3)) {
		$datos = 'login';
	} 
	else{
        global $db;
    
        $idProducto = $_GET['id'];
    
        if (isset($_SESSION['idUsuario'])){ //si se inició sesion desde una cuenta nativa
            $idUsuario = $_SESSION['idUsuario'];
        }
        else if (isset($_SESSION['id'])){ //Si se inicio sesion desde Google
            $idUsuario = $_SESSION['id'];
        }
        else if (isset($_SESSION["user_id"])){ //Si se inicio sesion desde twitter
            $idUsuario = $_SESSION["user_id"];
        }
    
        if (!isset($_SESSION['idUsuario'])){
            $sql = "SELECT u.id
                    FROM usuario as u
                    INNER JOIN usuario_rs as rs ON rs.id = u.id
                    WHERE rs.id_social = $idUsuario
            ";
    
            $rs = $db->query($sql);
    
            foreach ($rs as $row){
                $idUsuario = $row['id'];
            }
        }
    
        $sql = "SELECT id_producto
                FROM favorito
                WHERE '$idProducto' NOT IN(SELECT id_producto
                                        FROM favorito
                                        WHERE id_usuario = '$idUsuario')
        ";
    
        $rs = $db->query($sql);
    
        $i = 0;
        foreach ($rs as $row){
            $i++;
        }
    
        $sql = "SELECT id_producto
                FROM favorito
                WHERE id_usuario = '$idUsuario'
        ";
    
        $rs = $db->query ($sql);
    
        $j = 0;
        foreach ($rs as $row){
            $j++;
        }
    
        if ($i > 0 || $j == 0){ //Si no está cargado ese producto o todavia no hay ningun producto con ese usuario
            $sql = "INSERT INTO `favorito`(`id_producto`, `id_usuario`) VALUES ('$idProducto','$idUsuario')";
    
            $rs = $db->query ($sql);
            $datos = 'ok';
        }
        else{
            $datos = 'false';
        }
    }

    echo $datos;
?>