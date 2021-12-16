<!DOCTYPE html>
<?php  
	require_once('inc/session.php');
	include("encabezado.php");
    include("pie.php");
	
	if (perfil_valido(2)) {
		header("location:informacion_personal.php");
	} 
	else if (perfil_valido(1)) {
		header("ve.php");
	}
?>
<html lang="es"> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Catato Hogar</title>
    <link type="text/css"  href="css/estilos.css" rel="stylesheet"/>
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
	</script> 
	<style>
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

		#main{
			display:flex;
			justify-content:center;
			align-items:start;
			flex-wrap: wrap;
			width:100%;
			padding-bottom:30px;
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

		.btn{
			border-radius:5px;
			border: 2px solid black;
			font-size: 1.1em;
			background-color: white;
			cursor:pointer;
		}
	</style>
</head>
<body>
	<header>
        <?php echo $encab; ?> 
    </header>

	<main id='main'>
		<form action="inicio_sesion.php" method="post" class='form' novalidate>
			<h1>Iniciar Sesión</h1>	
			<div class="cont-campo">
				<label for="nombreUsuario" class="form-label">Nombre de usuario </label>
				<input type="text" class="form-control" name="nombreUsuario" id="nombreUsuario" value="" maxlength="20" required>	
			</div>  
			
			<div class="cont-campo">
				<label for="psw" class="form-label">Contraseña</label>				
				<input type="password" class="form-control" name="psw" id="psw" value="" maxlength="20" required>
			</div>
			
			<p class="e_error" style='display:none;'>
			<?php 
				$error ="";
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
			?> 
			</p>	

			<div class="cont-campo" id='btn-iniciar'>
				<input type="submit" class="btn" name="iniciar" value="Iniciar Sesión" id="iniciar" onclick='javascript:return validar()'>
			</div>	

		</form>		
	</main>
            
    <?php echo $pie; ?>
    
</body>
</html>