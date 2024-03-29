<?php  
	//Contraste de boton google ignorado
	// require_once "../app/TwitterAuth.php";
	require_once "../vendor/autoload.php";
	require_once "../controlador/config.php";
	include "encabezado.php";
    include "modalNovedades.php";
    include "pie.php";

	if (perfil_valido(2)) {
		header("location:informacionPersonal.php");
		exit;
	} 
	else if (perfil_valido(1)) {
		header("veABMProducto.php");
		exit;
	}

	// $auth = new TwitterAuth($cliente);
	$google= $google_client->createAuthUrl();
	// $twitter = $auth->getAuthUrl();

	$login_button = "<a href='" . $google . "' class='btn-google'>Iniciar sesión con Google</a>";
	// 				 <a href=".$twitter." class='btn-twitter'>Iniciar sesión con Twitter</a>
	// ";

	if (isset($_GET["reg"])){
	    include_once("../controlador/apiDatos.php");
	    
		$ruta = "<ol class='ruta'>
					<li><a href='index.php'>Inicio</a></li>
					<li>Registro</li>
				</ol>
		";

		$formulario = "
			<form action='../controlador/registro.php' onsubmit='return validarRegistro()' method='post'  id='form-registro'>
				<div class='form'>
					<div class='cont-reg'>
						<label for='nombre' class='form-label'>Nombre</label>
						<input type='text' class='form-control' name='nombre' id='nombre' value='' maxlength='40' autocomplete='given-name'>	
					</div>  

					<div class='cont-reg'>
						<label for='apellido' class='form-label'>Apellido</label>				
						<input type='text' class='form-control' name='apellido' id='apellido' value='' maxlength='40' autocomplete='family-name'>
					</div>

					<div class='cont-reg'>
						<label for='dni' class='form-label'>Número de DNI </label>
						<input type='text' class='form-control' name='dni' id='dni' value='' maxlength='8'>	
					</div>
					
					<div class='cont-reg'>
						<label for='email' class='form-label'>Email</label>
						<input type='text' class='form-control' name='email' id='email' value='' maxlength='40' autocomplete='email'>	
					</div> 
					
					<div class='cont-reg'>
						<label for='provincia' class='form-label'>Provincia </label>
						$select
					</div> 
					
					<div class='cont-reg' id='cont-ciudad'>
					</div> 
					
					<div class='cont-reg'>
						<p class='form-label'>Dirección </p>
						<label class='form-label l-direccion' for='calle'>Calle </label>
						<input type='text' class='form-control direccion' name='direccion[]' id='calle' value='' placeholder='Calle'>	
						<label class='form-label l-direccion' for='numero'>Numero</label>
						<input type='number' class='form-control direccion' name='direccion[]' id='numero' value='' placeholder='Número'>	
						<label class='form-label l-direccion' for='piso' >Piso</label>
						<input type='text' class='form-control direccion' name='direccion[]' id='piso' value='' placeholder='Piso'>	
					</div> 

					<div class='cont-reg'>
					</div> 
					
					<div class='cont-reg'>
						<label for='nombre-usuario' class='form-label'>Nombre de usuario </label>
						<input type='text' autocomplete='username' class='form-control' name='nombre-usuario' id='nombre-usuario' value='' maxlength='20'>	
					</div> 
					
					<div class='cont-reg'>
						<label for='psw' class='form-label'>Contraseña</label>				
						<input type='password' autocomplete='new-password' class='form-control' name='psw' id='psw' value='' maxlength='50'>
					</div>
						
					<div class='cont-reg'>
						<label for='psw2' class='form-label'>Repetir contraseña</label>				
						<input type='password' autocomplete='new-password' class='form-control' name='psw2' id='psw2' value='' maxlength='50'>
					</div>

					<div class='cont-reg'>
					</div>

					<div class='cont-reg l-novedades'>
						<label>
							<input type='checkbox' id='novedades' name='suscripcion'  value=''>Suscripción a las novedades
						</label>			
					</div>
					
					<div class='registro'>
		";

		if (isset($_GET["error"])){
			$error = $_GET["error"];

			$formulario .= "<div class='mensaje' id='mensaje'> <p>";
			
			if ($error == "4"){
				$formulario .= "El usuario, email y/o DNI ingresado ya existen";
			}
			else if ($error == "1"){
				$formulario .= "Las contraseñas no coindiden, reintente por favor";
			}
			else if ($error == "2"){
				$formulario .= "El dni ingresado no es válido";
			}
			else if ($error == "3"){
				$formulario .= "Falta ingresar al menos un campo";
			}
			else if ($error == "5"){
				$formulario .= "La contraseña debe tener al menos 6 caracteres";
			}

			$formulario .= "</p></div>";
		}
		else if (isset($_GET["registro"])){
			$formulario .= "<div id ='reg-exito'><p>El registro ha sido exitoso</p></div>";
		}
		
		$formulario .= " 
						<button id='registrarse'>Registrarse</button>
					</div>
				</div>
				<div class='redes redes-reg'>
					$login_button
				</div>
			</form>
		";
		
		$login_button;
	}
	else if (!isset($_GET["login"])){
		$ruta = "<ol class='ruta'>
					<li><a href='index.php'>Inicio</a></li>
					<li>Inicio de sesión</li>
				</ol>
		";

		$formulario = "<form action='../controlador/inicioSesion.php' onsubmit='return validarLogin()' method='post' class='formulario' novalidate>
							<div id='sesion'>
								<h1 id='titulo-is'>Iniciar sesión</h1>	
								<div class='cont-campo'>
									<label for='nombre-usuario' class='form-label'>Nombre de usuario </label>
									<input type='text' autocomplete='username' class='form-control' name='nombre-usuario' id='nombre-usuario' value='' maxlength='20' >	
								</div>  

								<div class='cont-campo'>
									<label for='psw' class='form-label'>Contraseña</label>				
									<input type='password' autocomplete='current-password' class='form-control' name='psw' id='psw' value='' maxlength='20' >
								</div>
		";
		
		$error ="";

		if(isset($_GET["error"])){
			$error = $_GET["error"];

			if ($error == "0"){
				$formulario .= "<p class='mensaje'>Complete los campos por favor</p>";
			}
			else if($error == "1"){
				$formulario .= "<p class='mensaje'>El usuario ingresado no existe</p>";
			}
			else if($error == "2"){
				$formulario .= "<p class='mensaje'>La contraseña ingresada es inválida</p>";
			}
			else if ($error == "401"){
				$formulario .= "<p class='mensaje'>Ha ocurrido un error inesperado, reintente nuevamente por favor</p>";
			}
		}						
		
		$formulario .= "
					<div class='cont-campo' id='btn-iniciar'>
						<input type='submit' class='botones' name='iniciar' value='Iniciar sesión' id='iniciar' onclick='javascript:return validarLogin()'>
					</div>
				</div>
				<div class='redes'> $login_button </div>
			</form>	
		";
	}	
?>
<!DOCTYPE html>
<html lang="es"> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Muebles Giannis</title>
    <link type="text/css"  href="../assets/css/estilos.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="../images/iconos/logo_sitio.png">
	<script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/funciones.js"></script>
	<script>
		$(document).ready(function(){
			actualizarCiudadRegistro();

			$("#provincia").change (function (){
				actualizarCiudadRegistro();
			});

		});

		function actualizarCiudadRegistro (){
			$.ajax ({
				type: "POST",
				url: "rellenarSelect.php",
				data: "provincia=" + $("#provincia").val(),
				success: function (r){
					$("#cont-ciudad").html (r);
				}
			});
		}	
	</script> 
	<style>
		#main{
			display:flex;
			justify-content:center;
			align-items:start;
			flex-wrap: wrap;
			width:100%;
			padding-bottom:30px;
		}

		.cont-campo{
			width:100%;
			display:flex;
			flex-flow:wrap;
			margin:4px;
		}

		h2{
			display: flex;
			justify-content: center;
			width: 100%;
			font-size: 25px;
			font-weight: normal;
			font-family: "Salesforce Sans",Sans-serif;
			background-color: #000;
			color: white;
			margin: 0 0 15px 0;
			padding: 4px 0;
		}

		.form-label{
			width: 100%;
			padding-left: 4px;
			text-align: center;
		}

		#cambiar-contra{
			width:100%;
			display: flex;
    		justify-content: center;
			align-items:start;
			margin:2px;
		}

		.form-control{
			width:100%;
			margin:2px;
			height:30px;
			border-radius: .1875rem;
			border: 1px solid #000;
		}

		#btn-iniciar{
			display:flex;
    		justify-content: center;
			margin: 24px 4px 8px 4px;
		}

		.l-direccion{
			display:none;
		}

		.botones{
			border-radius:5px;
			border: 2px solid black;
			font-size: 1.1em;
			background-color: white;
			cursor:pointer;
		}

		.cont-reg{
			width:50%;
			display:flex;
			justify-content:center;
			flex-wrap:wrap;
		}

		.cont-reg input{
			width: 80%;
		}

		#registrarse{
			width:100%;
			border: 2px solid black;
			font-size:1.1em;
			background-color: white;
		    border-radius: .1875rem;
		    padding: 2%;
		}

		.registro{
			width:90%;
			display:flex;
			flex-wrap: wrap;
			align-items:end;
			margin: 2%;
		}

		#registrarse:hover, #iniciar:hover{
			background-color: rgba(147, 81, 22,0.7);
            transition: all 0.3s linear;
            cursor:pointer;
			color: white
	    }

		#form-registro{
			display: flex;
			flex-wrap: wrap;
			justify-content: center;
			width: 70%;
			border: solid 2px black;
			border-radius: 5px;
			background-color: white;
			align-items: center;
			padding: 4%;
		}
		
		.cont-reg label{
			text-align:center;
			padding: 0;
		}

		.cont-reg select{
			text-align:center;
			width:83%;
			height:30px;
			border: solid #000 0.994px;
			padding: 1px 2px;
		    border-radius: .1875rem;
		}

		#calle{
			width:80%;
		}

		#numero{
			width:19%;
		}

		#piso{
			width:11%;
		}

		#error-reg{
			color: red;
		}

		#reg-exito{
			color: green;
		}

		.redes{
			display:flex;
			justify-content:center;
			flex-wrap:wrap;
			background-color:white;
			width:92%;
			margin: 0 auto;
		}

		/* .redes-reg{

		} */

		.btn{
			margin: 0;
		}

		.btn-google, .btn-twitter{
			border-radius: 5px; 
			color: white; 
			display: block; 
			font-weight: bold; 
			padding: 15px; 
			text-align: center; 
			text-decoration: none; 
			width: 100%;
			font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
    		font-size: 14px;
			margin: 1%;
            transition: all 0.3s linear;
			border: 2px solid #000;
		}

		.btn-google{
			background: #dd4b39; 
		}

		.btn-google:hover{
			background-color: #FF4500;
            transition: all 0.3s linear;
		}

		.btn-twitter{
			background-color: #55acee;
		}

		.btn-twitter:hover{
			background-color: #00BFFF;
            transition: all 0.3s linear;
		}
	
		#sesion{
			display:flex;
			justify-content:center;
			flex-wrap:wrap;
			padding: 0 4%;
		}

		.form{
			width: 100%;
			height: 100%;
			border: none;
			border-radius: 0px;
			padding: 2%;
		}

		.formulario{
			display: flex;
			align-items: center;
			flex-wrap: wrap;
			width: 40%;
			background-color: white;
			border-radius: 5px;
			border: 2px solid black;
			margin-block-end: 0;
			padding: 2%;	
		}

		#iniciar{
			width: 100%;
			height: 50px;
			margin: 0;
			margin-bottom: 2px;
			border: 2px solid black;
			font-size: 1.1em;
			background: rgba(147, 81, 22,0.5);
			color: white;
		}

		#titulo-is{
			font-family: museosans500,arial,sans-serif; 
			height: 30px; 
			width:100%;
			border-bottom: 1px solid #D3D3D3;
			text-align:center;
			padding-bottom:10px;
			font-size: 1.8rem;
		}

		main ::placeholder{
			text-align:center;
		}
		
		.l-novedades{
		    width:100%; 
		    justify-content:start; 
		    margin-left:4%; 
		    margin-top:2%;
		}

		#novedades{
			width:auto;
		}
		
		.l-novedades label{
		    text-align:start;
		}

		.ruta li{
			margin-left:5px;
		}

		.ruta li:last-child{
            border:none;
            text-decoration: none;
        }

		.mensaje{
			width:100%;
			margin: 20px 4px;
		}
		
		@media screen and (max-width:860px){
		    .formulario{
		        width: 90%;
		        margin: auto;
		    }
		    
		    .cont-reg{
		        width: 90%;
		        margin: auto;
		    }
		    
		    .l-novedades{
		        justify-content:center;
		        margin-top: 2%;
		    }
		}
	</style>
</head>
<body>
	<?= imprimir_encabezado($encabezado, $encabezado_mobile); ?>


	<main id="main">
		<?= $ruta; ?>

		<?= $formulario; ?>
	</main>

	<?= $modal_novedades; ?> 
	<?= $modal_novedades_error; ?>
            
    <footer id="pie">
		<?= $pie; ?> 
	</footer> 
</body>
</html>