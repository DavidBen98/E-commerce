<?php 
	require "../inc/conn.php";
	require "funciones.php"; 
	require_once "config.php"; 
 
	$nombre_usuario = trim($_POST["nombre-usuario"] ?? "");
	$psw = trim($_POST["psw"] ?? "");
	
	if ($nombre_usuario === "" || $psw === "") {
		header("location:../vistas/login.php?error=0"); 
		exit;
	}
	
	$stmt = $db->prepare("SELECT contrasena, perfil, nombre, apellido, email,id
						  FROM usuario 
						  WHERE usuario.nombre_usuario =?
	");
	
	$stmt->execute([$nombre_usuario]);
	
	if ($rs = $stmt->fetch()) {
		$psw_user = $rs["contrasena"];
		$psw_encript = generar_clave_encriptada($psw);
	
		if ($psw_user === $psw_encript) {
			$_SESSION["user"] = $nombre_usuario;
			$_SESSION["perfil"] = $rs["perfil"];
			$_SESSION["nombre"] = "{$rs["apellido"]}, {$rs["nombre"]}";
			$_SESSION["email"] = $rs["email"];
			$_SESSION["idUsuario"] = $rs["id"];
			$login = 1;
		} else {
			header("location:../vistas/login.php?error=2"); 
			exit;
		}
	} else {
		header("location:../vistas/login.php?error=1"); 
		exit;
	}
	
	if ($login === 0) {
		$_SESSION["user"] = "";
	} else if ($_SESSION["perfil"] === "E") {
		header("location:../vistas/veABMProducto.php");
		exit;
	} else {
		header("location:../vistas/index.php");
		exit;
	}
?>