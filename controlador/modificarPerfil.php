<?php  
    include "../inc/conn.php";
    require_once "config.php";
    require_once "funciones.php";
    
    global $db;

    // $id_usuario = "";

    // if (isset($_SESSION["idUsuario"])){
    //     $id_usuario = $_SESSION["idUsuario"];
    // }
    // else if (isset($_SESSION["user"])){
    //     $id_usuario = $_SESSION["user"];
    //     $mail = false;
    // }
    // // else if ($_SESSION["id_tw"]){
    // //     $id_usuario = $_SESSION["id_tw"];
    // // }

    // if (!isset($_SESSION["idUsuario"])){
    //     $rs = obtener_usuario_con_rs($id_usuario);

    //     foreach ($rs as $row){
    //         $id_usuario = $row["id"];
    //     }
    // }

    $id_usuario = $_SESSION["idUsuario"] ?? $_SESSION["user"] ?? null;
    $mail = true;

    if (!isset($_SESSION["idUsuario"]) && isset($id_usuario)) {
        $rs = obtener_usuario_con_rs($id_usuario);
        $id_usuario = $rs[0]["id"] ?? null;
        $mail = false;
    }

    function getPostData($key) {
        $value = (isset($_POST[$key]) && trim($_POST[$key]) != "") ? $_POST[$key] : null;
      
        if ($key === "dni") {
          $value = (strlen($value) > 6) ? $value : null;
        } else if ($key === "suscripcion") {
          $value = (isset($_POST["suscripcion"])) ? 1 : 0;
        } else if ($key === "provincia") {
          $value = ($value != -1) ? $value : null;
        }
      
        return $value;
    }

    $nombre_usuario = getPostData("nombre-usuario");
    $nombre = getPostData("nombre");
    $apellido = getPostData("apellido");
    $dni = getPostData("dni");
    $email = getPostData("email");
    $provincia = (isset($_POST["provincia"]) && trim($_POST["provincia"]) != "" && $_POST["provincia"] != -1)? trim($_POST["provincia"]) : null;
    $ciudad = (isset($_POST["ciudad"]) && trim($_POST["ciudad"]) != "")? trim($_POST["ciudad"]) : null;
    $direccion = (isset($_POST["direccion"]) && trim($_POST["direccion"][0]) != "" && trim($_POST["direccion"][1]) != "")? $_POST["direccion"] : null;
    $suscripcion = getPostData("suscripcion");

    $query = "SELECT id FROM usuario WHERE nombre_usuario = :nombreUsuario AND id != :idUsuario";
    
    $statement = $db->prepare($query);
    $statement->bindParam(":nombreUsuario", $nombre_usuario);
    $statement->bindParam(":idUsuario", $id_usuario);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        header("location: ../vistas/informacionPersonal.php?error=1#mensaje");
        exit;
    }

    if ($nombre === null || $apellido === null || $dni === null || $email === null || $provincia === null 
    || ($ciudad === null && $provincia !== "02") || $direccion === null || $nombre_usuario === null) {
        header("location:../vistas/informacionPersonal.php?error=2");
        exit;
    } else {
        $nombre_provincia = obtener_nombre_provincia($provincia);

        if ($nombre_provincia == ""){
            $ciudad = "";
        }

        $dire = "";

        if ($direccion[0] != "" && $direccion[1] != ""){
            $cantidad = count($direccion);
            for ($i=0; $i<$cantidad; $i++){
                if ($direccion[$i] != "") {
                    if ($i == 2){
                        $dire .= ", " . $direccion[$i];
                    }else{
                        $dire .= $direccion[$i] . " ";
                    }
                }
            }
        }

        $dire = trim($dire);

        $query = "UPDATE usuario SET nombre_usuario = :nombreUsuario, nro_dni = :dni, nombre = :nombre, apellido = :apellido, provincia = :provinciaNombre, ciudad = :ciudad, direccion = :direccion, suscripcion = :suscripcion WHERE id = :idUsuario";

        $stmt = $db->prepare($query);
        $stmt->bindParam(":nombreUsuario", $nombre_usuario);
        $stmt->bindParam(":dni", $dni);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":apellido", $apellido);
        $stmt->bindParam(":provinciaNombre", $nombre_provincia);
        $stmt->bindParam(":ciudad", $ciudad);
        $stmt->bindParam(":direccion", $dire);
        $stmt->bindParam(":suscripcion", $suscripcion);
        $stmt->bindParam(":idUsuario", $id_usuario);
        $stmt->execute();

        header("location: ../vistas/informacionPersonal.php?modif=exito#mensaje");
        exit;
    }
?>