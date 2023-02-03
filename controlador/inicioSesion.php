<?php 
	require '../inc/conn.php';
	require 'funciones.php'; 
	require_once 'config.php'; 
 
	$login=0;	
	
	$nombreUser =(isset($_POST['nombreUsuario']) && !empty($_POST['nombreUsuario']))? trim($_POST['nombreUsuario']):"";
	$psw =(isset($_POST['psw']) && !empty($_POST['psw']))? trim($_POST['psw']):"";
	
	if ($nombreUser == "" || $psw == ""){
		header("location:../login.php?error=0"); 
	}
	else{
		$sql = "SELECT contrasena, perfil, nombre, apellido, email,id
				FROM usuario 
				WHERE usuario.nombreUsuario =?
		";

		$stmt = $db->prepare($sql);
		$sqlvalue=[$nombreUser];

		if ($stmt -> execute($sqlvalue)) {  
			if ($rs = $stmt->fetch()){		
				$psw_user = $rs['contrasena'];
				$psw_encript = generar_clave_encriptada($psw);

				if ($psw_user == $psw_encript) {		
					$login=1;
 
					$_SESSION['user'] = $nombreUser;
					$_SESSION['perfil'] = $rs['perfil'];
					$_SESSION['nombre'] = "{$rs['apellido']}, {$rs['nombre']}";
					$_SESSION['email'] = $rs['email'];
					$_SESSION['idUsuario'] = $rs['id'];
				} 
				else{
					header("location:../login.php?error=2"); 
				}
			}
			else{
				header("location:../login.php?error=1"); 
			}
		}

		$rs=null;
		$db=null;

		if ($login==0) {
			$_SESSION["user"]="";
		} 
		else if ($_SESSION["perfil"]=="E"){
			header("location:../veABMProducto.php");
		}
		else { 
			header("location:../index.php");	
		}				
	} 
?>