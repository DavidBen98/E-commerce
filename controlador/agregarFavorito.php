<?php  
    require_once "config.php";
    include_once "../inc/conn.php";
    require_once "funciones.php";
    
    if (perfil_valido(3)) {
		$datos = "login";
	} 
	else{
        global $db;
    
        $id_producto = intval($_GET["id"]);
    
        if (isset($_SESSION["idUsuario"])){ //si se inició sesion desde una cuenta nativa
            $id_usuario = intval($_SESSION["idUsuario"]);
        }
        else if (isset($_SESSION["id"])){ //Si se inicio sesion desde Google
            $id_usuario = intval($_SESSION["id"]);
        }
        // else if (isset($_SESSION["user_id"])){ //Si se inicio sesion desde twitter
        //     $id_usuario = intval($_SESSION["user_id"]);
        // }
    
        if (!isset($_SESSION["idUsuario"])){
            $sql = "SELECT u.id
                    FROM usuario as u
                    INNER JOIN usuario_rs as rs ON rs.id = u.id
                    WHERE rs.id_social = :id
            ";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(":id", $id_usuario, PDO::PARAM_INT);
            $stmt->execute();
            $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rs as $row){
                $id_usuario = $row["id"];
            }
        }

        $sql = "SELECT * FROM favorito
                WHERE id_producto = :idProducto AND id_usuario = :idUsuario
        ";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":idUsuario", $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(":idProducto", $id_producto, PDO::PARAM_INT);
        $stmt->execute();
        $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $i = 0;
        foreach ($rs as $row){
            $i++;
        }

        if ($i === 0){
            $sql = "INSERT INTO favorito (id_producto, id_usuario)
                    VALUES (:idProducto, :idUsuario)
            ";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(":idProducto", $id_producto, PDO::PARAM_INT);
            $stmt->bindParam(":idUsuario", $id_usuario, PDO::PARAM_INT);
            $stmt->execute();

            $datos = "ok";
        } else {
            $datos = "false";
        }
    }

    echo $datos;
?>