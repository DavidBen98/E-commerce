<?php
    require_once "config.php";
	require "funciones.php";  

    $nombre = (isset($_POST["nombre"]) && trim($_POST["nombre"]) != "")? trim($_POST["nombre"]) : "";
    $apellido = (isset($_POST["apellido"]) && trim($_POST["apellido"]) != "")? trim($_POST["apellido"]) : "";
    $dni = (isset($_POST["dni"]) && strlen(trim($_POST["dni"])) > 6)? trim($_POST["dni"]) : "";
    $email = (isset($_POST["email"]) && trim($_POST["email"]) != "")? trim($_POST["email"]) : "";
    $provincia = (isset($_POST["provincia"]) && trim($_POST["provincia"]) != "")? trim($_POST["provincia"]) : "";
    $ciudad = (isset($_POST["ciudad"]) && trim($_POST["ciudad"]) != "")? trim($_POST["ciudad"]) : "";
    $direccion = (isset($_POST["direccion"]) && trim($_POST["direccion"][0]) != "")? $_POST["direccion"] : "";
    $nombre_usuario = (isset($_POST["nombre-usuario"]) && !empty($_POST["nombre-usuario"]) && trim($_POST["nombre-usuario"]) != "")? trim($_POST["nombre-usuario"]) : "";
    $psw = (isset($_POST["psw"]) && trim($_POST["psw"]) != "")? trim($_POST["psw"]) : "";
    $psw2 = (isset($_POST["psw2"]) && trim($_POST["psw2"]) != "")? trim($_POST["psw2"]) : "";
    $suscripcion = ($_POST["suscripcion"] == "1")? 1 : 0;

    $sql = "SELECT nombre_usuario, email
		    FROM usuario as u
		    WHERE u.nombre_usuario = '$nombre_usuario' OR u.email = '$email' OR u.nro_dni = '$dni'
    ";

    $rs = $db->query($sql);

    $i = 0;
    foreach ($rs as $row){
        $i++;
    }

    if ($i > 0){
        header("location:../vistas/login.php?reg=true&error=4");
        exit;
    }
    else if ($psw != $psw2){
        header("location:../vistas/login.php?reg=true&error=1");
        exit;
    }
    else if (strlen($dni) < 7 || strlen($dni) > 8){
        header("location:../vistas/login.php?reg=true&error=2");
        exit;
    }
    else if ($nombre == "" || $apellido == "" || $dni == "" || $email == "" || $provincia == "" || ($ciudad == "" && $provincia !="02") || $direccion == "" || $nombre_usuario == "" || $psw == ""){
        header("location:../vistas/login.php?reg=true&error=3");
        exit;
    } else if (strlen($psw) < 6) {
        header("location:../vistas/login.php?reg=true&error=5");
        exit;
    }
    else{
        $psw = generar_clave_encriptada($psw);

        $nombre_provincia = obtener_nombre_provincia($provincia);

        $dire = "";
        for ($i=0;$i<count($direccion);$i++){
            if ($i == 2){
                $dire .= ", " . $direccion[$i];
            }else{
                $dire .= $direccion[$i] . " ";
            }
        }

        $dire = trim($dire);

        $insertar = "INSERT INTO `usuario`(`nombre_usuario`, `contrasena`, `perfil`, `nro_dni`, `nombre`, `apellido`, `email`, `provincia`, `ciudad`, `direccion`,`suscripcion`) 
                     VALUES ('$nombre_usuario','$psw','U','$dni','$nombre','$apellido','$email','$nombre_provincia','$ciudad','$dire','$suscripcion')
        ";

        $rs = $db->query($insertar);

        header("location:../vistas/login.php?reg=true&registro=exitoso&apellido=$apellido");
        exit;
    }
?>