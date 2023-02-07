<?php  
    require_once "config.php";
    include_once "../inc/conn.php";
    require_once "funciones.php";
    
    if (perfil_valido(3)) {
		$datos = "login";
	} 
	else{
        global $db;
    
        $idProducto = intval($_GET["id"]);
    
        if (isset($_SESSION["idUsuario"])){ //si se inició sesion desde una cuenta nativa
            $idUsuario = intval($_SESSION["idUsuario"]);
        }
        else if (isset($_SESSION["id"])){ //Si se inicio sesion desde Google
            $idUsuario = intval($_SESSION["id"]);
        }
        // else if (isset($_SESSION["user_id"])){ //Si se inicio sesion desde twitter
        //     $idUsuario = intval($_SESSION["user_id"]);
        // }
    
        if (!isset($_SESSION["idUsuario"])){
            $sql = "SELECT u.id
                    FROM usuario as u
                    INNER JOIN usuario_rs as rs ON rs.id = u.id
                    WHERE rs.id_social = ?
            ";
    
            $stmt = $db->prepare($sql);
            $stmt->bind_param("i", $idUsuario);
            $stmt->execute();
            $rs = $stmt->get_result();
    
            foreach ($rs as $row){
                $idUsuario = $row["id"];
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
            $stmt = $db->prepare("INSERT INTO favorito (id_producto, id_usuario) VALUES (?, ?)");
            $stmt->bind_param("ii", $idProducto, $idUsuario);
            $stmt->execute();
            $datos = "ok";
        }
        else{
            $datos = "false";
        }
    }

    echo $datos;
?>