<?php   
session_start();  

	$user = (isset($_SESSION["user"]) && !empty($_SESSION["user"]))? trim($_SESSION["user"]):""; 
	$perfil = (isset($_SESSION["perfil"]) && !empty($_SESSION["perfil"]))? trim($_SESSION["perfil"]):""; 

	if ($user=="") {
		unset($_SESSION["user"]);
		$_SESSION = array();
		
		session_destroy();  
	} 
?>