<?php 
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
    }else if( $apellido == ""){
        $msjError .= "Debe ingresar apellido";
    }else if( $email == ""){
        $msjError .= "Debe ingresar su email"; 
    }else if( $txtIngresado == ""){
        $msjError .= "Debe ingresar su consulta";
    }
    else{  
        global $db;
        
        $sql  = " INSERT INTO `consulta` (`email`, `nombre`, `apellido`, `texto`, `respondido`, `id_usuario`) 
                VALUES ('$email','$nombre','$apellido','$txtIngresado',false, NULL)
        "; 

        $rs = $db->query($sql);

        $sql1 = "SELECT c.id 
                FROM `consulta` as c INNER JOIN `usuario` as u ON (c.email = u.email)
                WHERE c.email='$email'
                GROUP BY c.id 
        ";     
        $i=0; 
 
        $rs1 = $db->query($sql); 
        
        foreach ($rs1 as $row) { 
            $i++;        
            if($i !=0)   {
                $sql1 ="UPDATE `consulta`
                    SET `id_usuario` = {$row[c.id]}
                ";
            }
        }; 
        if ($i == 0){
            header("location:contacto.php");
        }  
        else {//si un usuario registrado ingreso una consulta           
            header("location:consulta_usuario.php");                       
        }   
    }  
?>