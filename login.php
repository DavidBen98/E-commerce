<?php  
	require_once('vendor/autoload.php');
	require_once('config.php');
    include("pie.php");
    include("modalNovedades.php");
	include("encabezado.php");

	if (perfil_valido(2)) {
		header("location:informacionPersonal.php");
	} 
	else if (perfil_valido(1)) {
		header("veABMProducto.php");
	}

// 	$auth = new TwitterAuth($cliente);
// 	$google= $google_client->createAuthUrl();
// 	$twitter = $auth->getAuthUrl();

// 	$login_button = "<a href=" . $google . " class='btn-google'>Iniciar sesión con Google</a>
// 					 <a href=".$twitter." class='btn-twitter'>Iniciar sesión con Twitter</a>
// 	";

	if (isset($_GET['reg'])){
	    include_once('apiDatos.php');
	    
		$ruta = "<ol class='ruta'>
					<li style='margin-left:5px;'><a href='index.php'>Inicio</a></li>
					<li style='border:none;text-decoration: none;'>Registro</li>
				</ol>
		";

		$formulario = "<form action='registro.php' onsubmit='return validarRegistro()' method='post' class='' id='form-registro'>
							<div class='form'>
								<div class='cont-reg'>
									<label for='nombre' class='form-label'>Nombre</label>
									<input type='text' class='form-control' name='nombre' id='nombre' value='' maxlength='40' required>	
								</div>  

								<div class='cont-reg'>
									<label for='apellido' class='form-label'>Apellido</label>				
									<input type='text' class='form-control' name='apellido' id='apellido' value='' maxlength='40' required>
								</div>

								<div class='cont-reg'>
									<label for='dni' class='form-label'>Número de DNI </label>
									<input type='text' class='form-control' name='dni' id='dni' value='' maxlength='8' required>	
								</div>
								
								<div class='cont-reg'>
									<label for='email' class='form-label'>Email</label>
									<input type='text' class='form-control' name='email' id='email' value='' maxlength='40' required>	
								</div> 
								
								<div class='cont-reg'>
									<label for='provincia' class='form-label'>Provincia </label>
									$select
								</div> 
								
								<div class='cont-reg' id='ciudad'>
									<label for='ciudad' class='form-label'>Ciudad</label>
								</div> 
								
								<div class='cont-reg'>
									<label class='form-label'>Dirección </label>
									<label class='form-label' for='calle' style='display:none;'>Calle </label>
									<input type='text' class='form-control direccion' name='direccion[]' id='calle' value='' maxlength='50' placeholder='Calle' required>	
									<label class='form-label' for='numero' style='display:none;'>Numero</label>
									<input type='text' class='form-control direccion' name='direccion[]' id='numero' value='' maxlength='50' placeholder='Número' required>	
									<label class='form-label' for='piso' style='display:none;'>Piso</label>
									<input type='text' class='form-control direccion' name='direccion[]' id='piso' value='' maxlength='50' placeholder='Piso' >	
								</div> 

								<div class='cont-reg'>
								</div> 
								
								<div class='cont-reg'>
									<label for='nombreUsuario' class='form-label'>Nombre de usuario </label>
									<input type='text' class='form-control' name='nombreUsuario' id='nombreUsuario' value='' maxlength='20' required>	
								</div> 
								
								<div class='cont-reg'>
									<label for='psw' class='form-label'>Contraseña</label>				
									<input type='password' class='form-control' name='psw' id='psw' value='' maxlength='50' required>
								</div>
									
								<div class='cont-reg'>
									<label for='psw2' class='form-label'>Repetir contraseña</label>				
									<input type='password' class='form-control' name='psw2' id='psw2' value='' maxlength='50' required>
								</div>

								<div class='cont-reg'>
								</div>

								<div class='cont-reg l-novedades'>
									<label>
										<input type='checkbox' id='novedades' style='width:auto;' name='suscripcion'  value='1'>Suscripción a las novedades
									</label>			
								</div>
								
								<div class='registro'>
									<button id='registrarse'>Registrarse</button>
								</div>
		";

		if (isset($_GET['error'])){
			$error = isset($_GET['error']);

			$formulario .= "<div id='error-reg'> <p>";
			
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
			$formulario .= "</p></div>";
		}
		else if (isset($_GET['registro'])){
			$formulario .= "<div id ='reg-exito'><p>El registro ha sido exitoso</p></div>";
		}
		
		$formulario .= "</div>
				<div class='redes'>
					
				</div>
			</form>
		";
		
		//$login_button
	}
	else if (!isset($_GET['login'])){
		$ruta = "<ol class='ruta'>
					<li style='margin-left:5px;'><a href='index.php'>Inicio</a></li>
					<li style='border:none;text-decoration: none;'>Inicio de sesión</li>
				</ol>
		";

		$formulario = "<form action='inicioSesion.php' onsubmit='return validarLogin()' method='post' class='formulario' novalidate>
							<div id='sesion'>
								<h1 id='titulo-is'>Iniciar Sesión</h1>	
								<div class='cont-campo'>
									<label for='nombreUsuario' class='form-label'>Nombre de usuario </label>
									<input type='text' class='form-control' name='nombreUsuario' id='nombreUsuario' value='' maxlength='20' required>	
								</div>  

								<div class='cont-campo'>
									<label for='psw' class='form-label'>Contraseña</label>				
									<input type='password' class='form-control' name='psw' id='psw' value='' maxlength='20' required>
								</div>

								<p class='p_error' id='p_error' style='display:none;'></p>
		";
		
		$error ='';

		if(isset($_GET['error'])){
			$error = $_GET['error'];
			if ($error == '0'){
				$formulario .= "<p class='p_error'>Complete los campos por favor</p>";
			}
			else if($error == '1'){
				$formulario .= "<p class='p_error'>El usuario ingresado no existe</p>";
			}
			else if($error == '2'){
				$formulario .= "<p class='p_error'>La contraseña ingresada es inválida</p>";
			}
			else if ($error == '401'){
				$formulario .= "<p class='p_error'>Ha ocurrido un error inesperado, reintente nuevamente por favor</p>";
			}
		}						
		
		$formulario .= "
					<div class='cont-campo' id='btn-iniciar'>
						<input type='submit' class='botones' name='iniciar' value='Iniciar Sesión' id='iniciar' onclick='javascript:return validarLogin()'>
					</div>
				</div>
			</form>	
		";
		//<div class='redes'> $login_button </div>
	}	
?>
<!DOCTYPE html>
<html lang="es"> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Muebles Giannis</title>
    <link type="text/css"  href="assets/css/estilos.css" rel="stylesheet"/>
    <link rel="icon" type="image/png" href="images/logo_sitio.png">
	<script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/funciones.js"></script>
	<script>
		$(document).ready(function(){
			actualizarCiudadRegistro();

			$('#provincia').change (function (){
				actualizarCiudadRegistro();
			});

		});

		function actualizarCiudadRegistro (){
			$.ajax ({
				type: "POST",
				url: "rellenarSelect.php",
				data: "provincia=" + $('#provincia').val(),
				success: function (r){
					$('#ciudad').html (r);
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
			display:flex;
			justify-content:center;
			width:100%;
			font-size: 25px;
			font-weight: normal;
			font-family: "Salesforce Sans",Sans-serif;
			background-color: #000;
			color: white;
			margin: 0 0 15px 0;
			padding: 4px 0;
		}

		.form-label{
			width:100%;
			padding-left:4px;
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
			margin:8px;
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
			align-items:end;
			margin: 2%;
		}

		#registrarse:hover, #iniciar:hover{
			background-color: rgba(147, 81, 22,0.5);
            transition: all 0.3s linear;
            cursor:pointer;
			color: white
	    }

		#form-registro{
			display:flex;
			flex-wrap:wrap;
			justify-content:center;
			width:70%;
			border: solid 2px black;
			border-radius: 5px;
			background-color: white;
			align-items:center;
			padding:10px;
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
			width:290px;
			margin: 0 auto;
		}

		.btn-google{
			background: #dd4b39; 
			border-radius: 5px; 
			color: white; 
			display: block; 
			font-weight: bold; 
			padding: 20px; 
			text-align: center; 
			text-decoration: none; 
			width: 250px;
			font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
    		font-size: 14px;
			margin:8px;
            transition: all 0.3s linear;
		}

		.btn-google:hover{
			background-color: #FF4500;
            transition: all 0.3s linear;
		}

		.btn-twitter{
			background-color: #55acee;
			border-radius: 5px; 
			color: white; 
			display: block; 
			font-weight: bold; 
			padding: 20px; 
			text-align: center; 
			text-decoration: none; 
			width: 250px;
			font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
    		font-size: 14px;
			margin:8px;
            transition: all 0.3s linear;
		}

		.btn-twitter:hover{
			background-color: #00BFFF;
            transition: all 0.3s linear;
		}
	
		#sesion{
			display:flex;
			justify-content:center;
			flex-wrap:wrap;
			padding: 0 20px;
			/*border-right: 1px solid #D3D3D3;*/
		}

		.form{
			width:100%;
			height:100%;
			border: none;
			border-radius: 0px;
			/*border-right: 1px solid #D3D3D3;*/
			padding:5px;
		}

		.formulario{
			display:flex;
			align-items:center;
			flex-wrap: wrap;
			width:60%;
			background-color: white;
			border-radius:5px;
			border: 2px solid black;
			margin-block-end: 0;
			padding: 10px;	
		}

		#iniciar{
			width: 100%;
			height: 50px;
			margin-bottom: 2px;
			border: 2px solid black;
			font-size: 1.1em;
			background-color: white;
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
		
		.l-novedades label{
		    text-align:start;
		}

		.p_error{
			width: 100%;
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
	<?= $encabezado; ?>
	<?= $encabezado_mobile; ?>


	<main id='main'>
		<?= $ruta; ?>

		<?= $formulario; ?>
	</main>

	<?= $modalNovedades; ?>
            
    <footer id='pie'>
		<?= $pie; ?> 
	</footer> 
</body>
</html>