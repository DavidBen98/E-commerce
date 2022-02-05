<?php 
	include('config.php');
    require 'funciones.php';  
    require 'inc/conn.php';

    if (perfil_valido(1)) {
		header("location:ve.php");
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
    else if ($email == ""){
        $msjError .= "Debe ingresar su email"; 
    }
    else if ($txtIngresado == ""){
        $msjError .= "Debe ingresar su consulta";
    }
    else{  
        global $db;

        $sql = "SELECT id 
                FROM `usuario` as u
                WHERE u.email='$email'
        ";
        
        $rs = $db->query($sql);

        $i=0; 

        foreach ($rs as $row) { 
            $i++; 
            $id = $row['id'];       
        }; 

        if ($i > 0){
            $sql2 = " INSERT INTO `consulta` (`email`, `nombre`, `apellido`, `texto`, `respondido`,`usuario_id`) 
                      VALUES ('$email','$nombre','$apellido','$txtIngresado','false','$id')
            "; 
        }
        else{
            $sql2 = " INSERT INTO `consulta` (`email`, `nombre`, `apellido`, `texto`, `respondido`,`usuario_id`) 
                        VALUES ('$email','$nombre','$apellido','$txtIngresado','false',null)
                        ";
        }

        $rs2 = $db->query($sql2);

        if ((isset($_SESSION['user_email_address']) && $email == $_SESSION['user_email_address'])
                    || ((isset($_SESSION['email'])) && $email == $_SESSION['email'])){//usuario registrado
            header("location:consulta_usuario.php");                       
        }   
        else{
            header("location:contacto.php?consulta=exito");
        }
    }  
?>