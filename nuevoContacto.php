<?php 
	include('config.php');
    require 'funciones.php';  
    require 'inc/conn.php';

    if (perfil_valido(1)) {
		header("location:veABMProducto.php");
	}

    $nombre =(isset($_POST['nombre']) && !empty($_POST['nombre']))? trim($_POST['nombre']):"";
    $apellido =(isset($_POST['apellido']) && !empty($_POST['apellido']))? trim($_POST['apellido']):""; 
    $email =(isset($_POST['email']) && !empty($_POST['email']))? trim($_POST['email']):"";
    $txtIngresado =(isset($_POST['txtIngresado']) && !empty($_POST['txtIngresado']))? trim($_POST['txtIngresado']):"";
    
    $msjError = "";

    if( $nombre == ""){
        $msjError .= "Debe ingresar su nombre"; 
    }
    else if ($apellido == ""){
        $msjError .= "Debe ingresar apellido";
    }
    else if ($email == "" && !isset($_SESSION['servicio']) && $user == ""){
        $msjError .= "Debe ingresar su email"; 
    }
    else if ($txtIngresado == ""){
        $msjError .= "Debe ingresar su consulta";
    }
    else if(isset($_SESSION['servicio']) || ($user != "")){  
        global $db;

        if (isset($_SESSION['idUsuario'])){ //si se inició sesion desde una cuenta nativa
            $id_usuario = $_SESSION['idUsuario'];
        }
        else if (isset($_SESSION['id'])){ //Si se inicio sesion desde Google
            $id_usuario = $_SESSION['id'];
        }
        else if (isset($_SESSION["id_tw"])){ //Si se inicio sesion desde twitter
            $id_usuario = $_SESSION["id_tw"];
        }

        $sql = "INSERT INTO `consulta` (`nombre`, `apellido`, `texto`,`usuario_id`) 
                VALUES ('$nombre','$apellido','$txtIngresado','$id_usuario')
        "; 

        $rs = $db->query($sql);

        header("location:consultaUsuario.php");                       
    }  
    else{
        global $db;

        $sql = "INSERT INTO `consulta` (`email`, `nombre`, `apellido`, `texto`) 
                VALUES ('$email','$nombre','$apellido','$txtIngresado')
        "; 

        $rs = $db->query($sql);

        header("location:contacto.php?consulta=exito");
    }
?>