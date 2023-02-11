<?php  
	require_once "../controlador/config.php";
    include "encabezado.php";
    include "modalNovedades.php";
    include "pie.php";

	if (perfil_valido(1)) {
        header("location:veABMProducto.php");
		exit;
    }  	
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muebles Giannis</title>
    <link type="text/css"  href="../assets/css/estilos.css" rel="stylesheet"/>
    <link rel="icon" type="image/png" href="../images/iconos/logo_sitio.png">
    <script src="../js/funciones.js"></script>
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
			margin: 20px auto 0 auto;
			padding: 0 10px;
			font-size: 1.1em;
			border-radius: 5px;
			border: 2px solid black;
	    }

		.input::placeholder { 
			padding-left: 2px;
		}

	    .txt-area{
			width: 90%;
			height: 100px;
			background-color: white;
			color: black;
			margin: 20px auto 0 auto;
			padding: 5px 10px 0 10px;
			resize: none;
			border: 2px solid black;
			border-radius: 5px;
			font-size: 1.1em;
			font-family: "Arial", serif;
	    }

		.txt-area::placeholder{
			font-family: "Arial", serif;
			font-size: 1em;
			padding-top: 2px;
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
		   transition: all 0.3s linear;
	    }

		.btn-enviar:hover {
			background-color: rgba(147, 81, 22,0.5);
            transition: all 0.3s linear;
            cursor:pointer;
			color:white;
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
		
		.contacto-texto{
		    margin-bottom:10px; 
		    width:100%;
		}

		.ruta li{
			margin-left:5px;
		}

		.cont-h1{
			width:100%; 
			margin: 0 0 10px 0;
		}

		.cont-h1 h1{
			font-family: museosans500,arial,sans-serif;
		}

		.ruta li:last-child{
			margin-left:0;
			border:none;
			text-decoration: none;
		}

		#mensaje{
			width:auto; 
			border-radius: 5px; 
			display:none;
		}

		#error{
            background: #000;
            color: white;
            border-radius: 5px;
            padding: 10px;
			margin: 20px;
			
        }
		
		@media screen and (max-width:1000px) {
		    .contacto-texto{
		        width: 90%;
		    }
		    
		    div > p{
		        margin: 0;
		    }
		    
		    .cont-con{
		        width: 95%;
		    }
		    .ruta{
		        height: 40px;
		    }
		    #main{
		        min-height: 90vh;
		    }
		}
    </style>
</head>
<body>
	<header>
		<?= $encabezado; ?>
        <?= $encabezado_mobile; ?>
	</header>

    <main id="main">
		<ol class="ruta">
			<li><a href="index.php">Inicio</a></li>
			<li>Contacto</li>
		</ol>
			
		<div class="cont-h1">
			<h1>Contacto</h1>
		</div>

		<div class="contacto-texto">
			<p> A continuación ingresá tus datos para realizar una consulta o solicitar información. </p>

			<p>	Te responderemos a la mayor brevedad posible. </p>

			<p>No dudes en comunicarte también por nuestra vía telefónica al 0800 - 0303 - 456 de lunes a viernes de 9 a 18 hs.</p>
		</div>

		<form action="../controlador/nuevoContacto.php" onsubmit="return validarContacto()" method="post" class="cont-con"> 
				<input type="text" class="input" name="nombre" id="nombre" title="Nombre" value="" placeholder="Nombre: Jhon" Maxlength="35" >
				<input type="text" class="input" name="apellido" id="apellido" title="Apellido" value="" placeholder="Apellido: Doe" >
				
				<?php
					if (!(isset($_SESSION["servicio"]) || $perfil == "U")){
						echo "<input type='text' class='input' name='email' id='email' title='Email' value='' placeholder='Email: jhonDoe@gmail.com' >";
					}
				?>
				<textarea id="txt-ingresado" class="txt-area" title="Consulta del usuario" placeholder="Consulta: Qué tarjetas aceptan?" name="txt-ingresado" ></textarea>
				<p id="mensaje">

                </p>
				<input type="submit" class="btn-enviar" name="enviar" id="enviar" title="Enviar" value="Enviar">
				
				<?php
					if (isset($_GET["consulta"])){
						echo "<div class='parrafo-exito'>La consulta ha sido realizada con éxito, en breve procederemos a responderla vía mail</div>";
					} else if(isset($_GET["error"])){
						$error = $_GET["error"];

						if ($error == 1){
							echo "<div class='mensaje' id='error'>Debe ingresar su nombre</div>";
						} else if ($error == 2){
							echo "<div class='mensaje' id='error'>Debe ingresar apellido</div>";
						} else if ($error == 3){
							echo "<div class='mensaje' id='error'>Debe ingresar su email</div>";
						} else if ($error == 4){
							echo "<div class='mensaje' id='error'>Debe ingresar su consulta</div>";
						}
					}
				?>
		</form>	
		
		<?= $modal_novedades; ?>
	</main>
	
	<footer id="pie">
		<?= $pie; ?> 
	</footer>
	
</body>
</html>