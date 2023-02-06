<?php
    require_once 'config.php';
	require 'funciones.php';  

    $nombre = (isset($_POST['nombre']) && trim($_POST['nombre']) != "")? trim($_POST['nombre']) : "";
    $apellido = (isset($_POST['apellido']) && trim($_POST['apellido']) != "")? trim($_POST['apellido']) : "";
    $dni = (isset($_POST['dni']) && strlen(trim($_POST['dni'])) > 6)? trim($_POST['dni']) : "";
    $email = (isset($_POST['email']) && trim($_POST['email']) != "")? trim($_POST['email']) : "";
    $provincia = (isset($_POST['provincia']) && trim($_POST['provincia']) != "")? trim($_POST['provincia']) : "";
    $ciudad = (isset($_POST['ciudad']) && trim($_POST['ciudad']) != "")? trim($_POST['ciudad']) : "";
    $direccion = (isset($_POST['direccion']) && trim($_POST['direccion'][0]) != "")? $_POST['direccion'] : "";
    $nombreUsuario = (isset($_POST['nombreUsuario']) && !empty($_POST['nombreUsuario']) && trim($_POST['nombreUsuario']) != "")? trim($_POST['nombreUsuario']) : "";
    $psw = (isset($_POST['psw']) && trim($_POST['psw']) != "")? trim($_POST['psw']) : "";
    $psw2 = (isset($_POST['psw2']) && trim($_POST['psw2']) != "")? trim($_POST['psw2']) : "";
    $suscripcion = ($_POST['suscripcion'] == '1')? 1 : 0;

    $sql = "SELECT nombreUsuario, email
		    FROM usuario as u
		    WHERE u.nombreUsuario = '$nombreUsuario' OR u.email = '$email' OR u.nroDni = '$dni'
    ";

    $rs = $db->query($sql);

    $i = 0;
    foreach ($rs as $row){
        $i++;
    }

    if ($i > 0){
        header("location:../vistas/login.php?reg=true&error=4");
    }
    else if ($psw != $psw2){
        header("location:../vistas/login.php?reg=true&error=1");
    }
    else if (strlen($dni) < 7 || strlen($dni) > 8){
        header("location:../vistas/login.php?reg=true&error=2");
    }
    else if ($nombre == "" || $apellido == "" || $dni == "" || $email == "" || $provincia == "" || ($ciudad == "" && $provincia !="02") || $direccion == "" || $nombreUsuario == "" || $psw == ""){
        header("location:../vistas/login.php?reg=true&error=3");
    } else if (strlen($psw) < 6) {
        header("location:../vistas/login.php?reg=true&error=5");
    }
    else{
        $psw = generar_clave_encriptada($psw);

        $provincia = obtenerNombreProvincia($provincia);

        $dire = "";
        for ($i=0;$i<count($direccion);$i++){
            if ($i == 2){
                $dire .= ', ' . $direccion[$i];
            }else{
                $dire .= $direccion[$i] . ' ';
            }
        }

        $dire = trim($dire);

        $insertar = "INSERT INTO `usuario`(`nombreUsuario`, `contrasena`, `perfil`, `nroDni`, `nombre`, `apellido`, `email`, `provincia`, `ciudad`, `direccion`,`suscripcion`) 
                     VALUES ('$nombreUsuario','$psw','U','$dni','$nombre','$apellido','$email','$provincia','$ciudad','$dire','$suscripcion')
        ";

        $rs = $db->query($insertar);

        header("location:../vistas/login.php?reg=true&registro=exitoso&apellido=$apellido");
    }
?>