<?php 
	$dbhost="localhost"; 
	$dbport ="";
	
	$dbname="muebles_giannis"; 
	$usuario="usuario_bd";
	$contrasenia="2021_trabajoF147!";

	$strCnx = "mysql:dbname=$dbname;host=$dbhost";
	
	$db =""; 

	try {
		$db = new PDO($strCnx, $usuario, $contrasenia);
		$db->setAttribute(PDO::ATTR_CASE,PDO::CASE_LOWER); 
		$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC); 
		
	} catch (PDOException $e) {
		print "Error: " . $e->getMessage() . "<br/>";   
		die();
	}
?>