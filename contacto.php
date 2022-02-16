<!DOCTYPE html>
<?php  
	include('config.php');
    include("encabezado.php");
    include("pie.php");

	if (perfil_valido(1)) {
        header("location:ve.php");
    }  
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Muebles Giannis</title>
    <link type="text/css"  href="assets/css/estilos.css" rel="stylesheet"/>
    <link rel="icon" type="image/png" href="images/logo_sitio.png">
    <script src="js/funciones.js"></script>
    <style>
		body{
			margin: 0;
		}
		
		main{
			display:flex;
			justify-content:center;
			flex-wrap:wrap;
		}

		h1{
			text-align:center;
			font-size: 2.3rem;
			margin: 0 auto;
			font-family: museosans500,arial,sans-serif;
		}

		.cont-con{
			display:flex;
			flex-flow: column;
			justify-content: center;
			width: 380px;
			margin: 0 auto 30px auto;
			border: 2px solid black;
			background-color: white;
			border-radius:5px;
		}

        .input{
			width: 90%;
			height: 50px;
			margin: 10px auto;
			padding: 0 10px;
			font-size: 1.1em;
			border-radius: 5px;
			border: 2px solid black;
	    }

		.input::placeholder { 
			padding-left: 2px;
		}

	    .txt-area{
		   height: 100px;
		   width: 90%;
		   background-color: white;
		   color: black;
		   padding: 0 10px;
		   margin: auto;
		   border-radius: 5px;
		   resize: none;
		   border: 2px solid black;
		   font-size: 1.1em;
		   padding-top:5px;
	    }

		.txt-area::placeholder{
			font-family: "Salesforce Sans", serif;
		}

		.cont-btn{
			display:flex;
			justify-content: center;
			margin: 0;
		}
		
	    .btn-enviar{
		   height: 40px;
		   width:95%;
		   margin:10px auto;
		   border: 2px solid black;
		   font-size:1.2em;
		   background-color: white;
		   border-radius: .1875rem;
	    }

		.btn-enviar:hover {
			background-color: rgba(147, 81, 22,0.5);
            transition: all 0.3s linear;
            cursor:pointer
        }

		#e_error{
			color: red;
			font-size: 0.8em;
			padding-left:10px;
		}

		.txt-area::-webkit-scrollbar {
    		-webkit-appearance: none;
		}

		.txt-area::-webkit-scrollbar:vertical {
			width:10px;
		}

		.txt-area::-webkit-scrollbar-button:increment,.txt-area::-webkit-scrollbar-button {
			display: none;
		} 

		.txt-area::-webkit-scrollbar:horizontal {
			height: 10px;
		}

		.txt-area::-webkit-scrollbar-thumb {
			background-color: #797979;
			border-radius: 20px;
			border: 2px solid #f1f2f3;
		}

		.txt-area::-webkit-scrollbar-track {
			border-radius: 10px;  
		}

		.parrafo-exito{
            background-color: #099;
			padding: 5px 0;
			color: white;
			margin: 10px;
			border-radius: 5px;
			text-align:center;
		}

		p{
			width:100%;
			text-align:center;
			margin:10px;
		}
    </style>
	<script>
		function validar(){
            document.getElementById("e_error").innerHTML="";

			let  exito = document.getElementsByClassName('parrafo-exito');
			exito[0].style.display = 'none';

			nombre = document.getElementById("nombre").value;
			apellido = document.getElementById("apellido").value;
			email = document.getElementById("email").value;
			txtIngresado = document.getElementById("txtIngresado").value;

			txtErrores = "";

			if( nombre == null || nombre.trim() == ""){
				txtErrores += "Debe ingresar su nombre";
			}
			else if( apellido == null || apellido.trim() == ""){
				txtErrores += "Debe ingresar su apellido";
			}
			else if( email == null || email.trim() == ""){
				txtErrores += "Debe ingresar su email";
			}
			else if( txtIngresado == null || txtIngresado.trim() == ""){
				txtErrores += "Debe ingresar una consulta";
			}

			let devolucion = false;
            
            if(txtErrores == ""){
				devolucion = true;
			}
  
            if (!devolucion){
                let error = document.getElementById("e_error");
                let hijo = document.createTextNode(txtErrores);
				error.appendChild(hijo);
            }

            return devolucion;
		}    
	</script>
</head>
<body>
	<header>
		<?php echo $encab;?>
	</header>

    <main id='main'>
		<?php
			echo "<ol class='ruta'>
							<li style='margin-left:5px;'><a href='index.php'>Inicio</a></li>
							<li style='border:none;text-decoration: none;'>Contacto</li>
						</ol>
			";
		?>
		<div style='width:100%; margin: 0 0 10px 0;'>
			<h1>Contacto</h1>
		</div>

		<div style='margin-bottom:10px; width:100%;'>
			<p> A continuación ingresá tus datos para realizar una consulta o solicitar información. </p>

			<p>	Te responderemos a la mayor brevedad posible. </p>

			<p>No dudes en comunicarte también por nuestra vía telefónica al 0800 - 0303 - 456 de lunes a viernes de 9 a 18 hs.</p>
		</div>

		<form action="nuevoContacto.php" method="post" class="cont-con"> 
				<input type="text" class="input" name="nombre" id="nombre" title="Nombre" value="" placeholder="Nombre" Maxlength="35" >
				<input type="text" class="input" name="apellido" id="apellido" title="Apellido" value="" placeholder="Apellido" >
				<input type="text" class="input" name="email" id="email" title="Email" value="" placeholder="Email" >
				<textarea id="txtIngresado" class="txt-area" title='Consulta del usuario' placeholder='Consulta' name="txtIngresado" ></textarea>
				<p id="e_error">

                </p>
				<div class="cont-btn">
					<input type="submit" class="btn-enviar" name="enviar" id="enviar" title="Enviar" value="Enviar" onclick="javascript:return validar()"> <br>
				</div>
				<?php
				if (isset($_GET['consulta'])){
					echo "<div class='parrafo-exito'>La consulta ha sido realizada con éxito, en breve procederemos a responderla vía mail</div>";
				}

				?>
		</form>		 	 
	</main>
	
	<?php echo $pie;?>
	
</body>
</html>