<!DOCTYPE html>
<?php  
	require_once('config.php');
    include("pie.php");
	require_once('vendor/autoload.php');
	include("encabezado.php");
	include('apiDatos.php');


	if (perfil_valido(2)) {
		header("location:informacionPersonal.php");
	} 
	else if (perfil_valido(1)) {
		header("ve.php");
	}

	$auth = new TwitterAuth($cliente);

	$login_button = "<a href=" . $google_client->createAuthUrl() . " class='btn-google'>Iniciar sesión con Google</a>
					<a href=".$auth->getAuthUrl()." class='btn-twitter'>Iniciar sesión con Twitter</a>";

	$google= $google_client->createAuthUrl();
	
?>
<html lang="es"> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Muebles Giannis</title>
    <link type="text/css"  href="assets/css/estilos.css" rel="stylesheet"/>
    <link rel="icon" type="image/png" href="images/logo_sitio.png">
	<script src="JS/jquery-3.3.1.min.js"></script>
    <script src="js/funciones.js"></script>
	<script>
        function validar(){
            document.getElementById('e_error').innerHTML="";

			nombreUser = document.getElementById('nombreUsuario').value;
			psw = document.getElementById('psw').value;
			
			txtErrores = "";

            if(nombreUser == null || nombreUser.trim() == ""){
				txtErrores += "Debe ingresar el nombre de usuario";
            }     
			else if(psw == null || psw.trim() == ""){
				txtErrores += "Debe ingresar la contraseña";
            }          
			
			let devolucion = false;
            
            if(txtErrores == ""){
				devolucion = true;
			}

            if (!devolucion){
                let error = document.getElementById('e_error');
				error.style.display = 'block';
                let hijo = document.createTextNode(txtErrores);
				error.appendChild(hijo);
            }

            return devolucion;
		}

		$(document).ready(function(){
			actualizarCiudad();

		$('#provincia').change (function (){
			actualizarCiudad();
		});

		});

		function actualizarCiudad (){
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
			height:55%;
			margin-bottom: 2px;
			border: 2px solid black;
			font-size:1.1em;
			background-color: white;
		    border-radius: .1875rem;
		}

		.registro{
			width:100%;
			height:66px;
			display:flex;
			align-items:end;
		}

		#registrarse:hover, #iniciar:hover{
			background-color: rgba(147, 81, 22,0.5);
            transition: all 0.3s linear;
            cursor:pointer;
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
			width:50%;
			padding: 0 20px;
			border-right: 1px solid #D3D3D3;
		}

		.form{
			width:60%;
			height:100%;
			border: none;
			border-radius: 0px;
			border-right: 1px solid #D3D3D3;
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
			border-radius: .1875rem;
		}

		#titulo-is{
			font-family: "Open Sans"; 
			height: 30px; 
			width:100%;
			border-bottom: 1px solid #D3D3D3;
			text-align:center;
			padding-bottom:10px;
			color: #979A9A;
		}

		::placeholder{
			text-align:center;
		}
	</style>
</head>
<body>
	<?php 
		echo $encab;
	?>

	<main id='main'>
		<?php
			if (isset($_GET['reg'])){
				echo "<ol class='ruta'>
                        <li style='margin-left:5px;'><a href='index.php'>Inicio</a></li>
                        <li style='border:none;text-decoration: none;'>Registro</li>
                  </ol>
            	";

				echo "<form action='registro.php' method='post' class='' id='form-registro'>
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
								<label for='direccion[]' class='form-label'>Dirección </label>
								<input type='text' class='form-control direccion' name='direccion[]' id='calle' value='' maxlength='50' placeholder='Calle' required>	
								<input type='text' class='form-control direccion' name='direccion[]' id='numero' value='' maxlength='50' placeholder='Número' required>	
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
								<label for='psw' class='form-label'>Repetir contraseña</label>				
								<input type='password' class='form-control' name='psw2' id='psw2' value='' maxlength='50' required>
							</div>

							<div class='cont-reg'>
							</div>

							<div class='cont-reg' style='width:100%; justify-content:start; margin-left:20px; margin-top:10px;'>
								<label style='margin-top:10px; text-align:start;'>
									<input type='checkbox' id='novedades' style='width:auto;' name='suscripcion'  value='1'>Suscripción a las novedades
								</label>			
							</div>
							
							<div class='registro'>
								<button id='registrarse'>Registrarse</button>
							</div>
						";

						if (isset($_GET['error'])){
							$error = isset($_GET['error']);

							echo "<div id='error-reg'> <p>";
							
							if ($error == "4"){
								echo "El usuario, email y/o DNI ingresado ya existen";
							}
							else if ($error == "1"){
								echo "Las contraseñas no coindiden, reintente por favor";
							}
							else if ($error == "2"){
							 	echo "El dni ingresado no es válido";
							}
							else if ($error == "3"){
							 	echo "Falta ingresar al menos un campo";
							}
							echo "</p></div>";
						}
						else if (isset($_GET['registro'])){
							echo "<div id ='reg-exito'><p>El registro ha sido exitoso</p></div>";
						}
						echo "</div>
								<div class='redes'>
									 $login_button 
								</div>
								</form>";
			}
			else if (!isset($_GET['login'])){
				echo "<ol class='ruta'>
                        <li style='margin-left:5px;'><a href='index.php'>Inicio</a></li>
                        <li style='border:none;text-decoration: none;'>Inicio de sesión</li>
                  	</ol>
            	";
				echo "<form action='inicioSesion.php' method='post' class='formulario' novalidate>
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

								<p class='e_error' style='display:none;'>";
									$error ='';
									if(isset($_GET['error'])){
										$error = $_GET['error'];
										if ($error == '0'){
											echo "<p class='e_error'>Complete los campos por favor</p>";
										}
										else if($error == '1'){
											echo "<p class='e_error'>El usuario ingresado no existe</p>";
										}
										else if($error == '2'){
											echo "<p class='e_error'>La contraseña ingresada es inválida</p>";
										}
									}						
						echo "</p>	

								<div class='cont-campo' id='btn-iniciar'>
									<input type='submit' class='botones' name='iniciar' value='Iniciar Sesión' id='iniciar' onclick='javascript:return validar()'>
								</div>
						</div>
								<div class='redes'>" . $login_button . "
									
								</div>
							</form>	";
			}
		?>
	</main>
            
    <?php echo $pie; ?>  
</body>
</html>