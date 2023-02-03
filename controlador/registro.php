<?php
    require_once 'config.php';
	require 'funciones.php';  

    $nombre = isset($_POST['nombre'])? trim($_POST['nombre']) : "";
    $apellido = isset($_POST['apellido'])? trim($_POST['apellido']) : "";
    $dni = isset($_POST['dni'])? trim($_POST['dni']) : "";
    $email = isset($_POST['email'])? trim($_POST['email']) : "";
    $provincia = isset($_POST['provincia'])? trim($_POST['provincia']) : "";
    $ciudad = isset($_POST['ciudad'])? trim($_POST['ciudad']) : "";
    $direccion = isset($_POST['direccion'])? $_POST['direccion'] : "";
    $nombreUsuario = (isset($_POST['nombreUsuario']) && !empty($_POST['nombreUsuario']))? trim($_POST['nombreUsuario']) : "";
    $psw = isset($_POST['psw'])? trim($_POST['psw']) : "";
    $psw2 = isset($_POST['psw2'])? trim($_POST['psw2']) : "";
    $suscripcion = ($_POST['suscripcion'] == '1')? 1 : 0;

    $sql = "SELECT nombreUsuario, email
		    FROM usuario 
		    WHERE usuario.nombreUsuario = '$nombreUsuario' OR usuario.email = '$email' OR usuario.nroDni = '$dni'
    ";

    $rs = $db->query($sql);

    $i = 0;
    foreach ($rs as $row){
        $i++;
    }

    if ($i > 0){
        header("location:../login.php?reg=true&error=4");
    }
    else if ($psw != $psw2){
        header("location:../login.php?reg=true&error=1");
    }
    else if (strlen($dni) < 7 || strlen($dni) > 8){
        header("location:../login.php?reg=true&error=2");
    }
    else if ($nombre == "" || $apellido == "" || $dni == "" || $email == "" || $provincia == "" || ($ciudad == "" && $provincia !="02") || $direccion == "" || $nombreUsuario == "" || $psw == ""){
        header("location:../login.php?reg=true&error=3");
    }
    else{
        $psw = generar_clave_encriptada($psw);

        if ($provincia == "02"){
            $provincia = "Ciudad Autónoma de Buenos Aires";
        }
        else if ($provincia == "06"){
            $provincia = "Buenos Aires";
        }
        else if ($provincia == "10"){
            $provincia = "Catamarca";
        }
        else if ($provincia == "14"){
            $provincia = "Córdoba";
        }
        else if ($provincia == "18"){
            $provincia = "Corrientes";
        }
        else if ($provincia == "22"){
            $provincia = "Chaco";
        }
        else if ($provincia == "26"){
            $provincia = "Chubut";
        }
        else if ($provincia == "30"){
            $provincia = "Entre Ríos";
        }
        else if ($provincia == "34"){
            $provincia = "Formosa";
        }
        else if ($provincia == "38"){
            $provincia = "Jujuy";
        }
        else if ($provincia == "42"){
            $provincia = "La Pampa";
        }
        else if ($provincia == "46"){
            $provincia = "La Rioja";
        }
        else if ($provincia == "50"){
            $provincia = "Mendoza";
        }
        else if ($provincia == "54"){
            $provincia = "Misiones";
        }
        else if ($provincia == "58"){
            $provincia = "Neuquén";
        }
        else if ($provincia == "62"){
            $provincia = "Río Negro";
        }
        else if ($provincia == "66"){
            $provincia = "Salta";
        }
        else if ($provincia == "70"){
            $provincia = "San Juan";
        }
        else if ($provincia == "74"){
            $provincia = "San Luis";
        }
        else if ($provincia == "78"){
            $provincia = "Santa Cruz";
        }
        else if ($provincia == "82"){
            $provincia = "Santa Fe";
        }
        else if ($provincia == "86"){
            $provincia = "Santiago del Estero";
        }
        else if ($provincia == "90"){
            $provincia = "Tucumán";
        }
        else if ($provincia == "94"){
            $provincia = "Tierra del Fuego, Antártida e Islas del Atlántico Sur";
        }


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

        header("location:../login.php?reg=true&registro=exitoso");
    }
?>