<?php 
	require_once "config.php";
    require "funciones.php";  
    require "../inc/conn.php";

    if (perfil_valido(1)) {
		header("location:../vistas/veABMProducto.php");
        exit;
	}

    $nombre =(isset($_POST["nombre"]) && !empty($_POST["nombre"]))? trim($_POST["nombre"]):"";
    $apellido =(isset($_POST["apellido"]) && !empty($_POST["apellido"]))? trim($_POST["apellido"]):""; 
    $email =(isset($_POST["email"]) && !empty($_POST["email"]))? trim($_POST["email"]):"";
    $texto_ingresado =(isset($_POST["txtIngresado"]) && !empty($_POST["txtIngresado"]))? trim($_POST["txtIngresado"]):"";
    
    if($nombre == ""){
        header("location:../vistas/contacto.php?error=1");  
        exit;
    }
    else if ($apellido == ""){
        header("location:../vistas/contacto.php?error=2");  
        exit;
    }
    else if ($email == "" && !isset($_SESSION["servicio"]) && $user == ""){
        header("location:../vistas/contacto.php?error=3"); 
        exit; 
    }
    else if ($texto_ingresado == ""){
        header("location:../vistas/contacto.php?error=4"); 
        exit; 
    }
    else if(isset($_SESSION["servicio"]) || isset($_SESSION["idUsuario"])){  
        global $db;

        if (isset($_SESSION["idUsuario"])){ //si se inició sesion desde una cuenta nativa
            $id_usuario = $_SESSION["idUsuario"];
        }
        else if (isset($_SESSION["id"])){ //Si se inicio sesion desde Google
            $id_usuario = $_SESSION["id"];
        }
        // else if (isset($_SESSION["id_tw"])){ //Si se inicio sesion desde twitter
        //     $id_usuario = $_SESSION["id_tw"];
        // }

        $sql = "INSERT INTO `consulta` (`nombre`, `apellido`, `texto`,`usuario_id`) 
                VALUES ('$nombre','$apellido','$texto_ingresado','$id_usuario')
        "; 

        $rs = $db->query($sql);

        header("location:../vistas/contacto.php?consulta=exito"); 
        exit;                      
    }  
    else{
        global $db;

        $sql = "INSERT INTO `consulta` (`email`, `nombre`, `apellido`, `texto`) 
                VALUES ('$email','$nombre','$apellido','$texto_ingresado')
        "; 

        $rs = $db->query($sql);

        header("location:../vistas/contacto.php?consulta=exito");
        exit;
    }

?>