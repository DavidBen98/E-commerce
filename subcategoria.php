<?php  
	require_once 'controlador/config.php';
	include ("encabezado.php");
	include ("pie.php");
    include("modalNovedades.php");
	include ("inc/conn.php"); 
	
	if ($perfil == "E"){ 
		header("location:veABMProducto.php");
	}	 

	$ruta = "<ol class='ruta'>
				<li><a href='index.php'>Inicio</a></li>
				<li>Subcategorías</li>
			</ol>
	";

	$imagenes = $_GET['categoria'];

	$rs = obtenerImagenesSubcategorias($imagenes);
?>
<!DOCTYPE html>
<html lang="es"> 
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muebles Giannis</title>
    <link type="text/css"  href="assets/css/estilos.css" rel="stylesheet"/>
    <link rel="icon" type="image/png" href="images/logo_sitio.png">
	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
	<script src="js/funciones.js"></script>
	<style>
		#main{
			display:flex;
			padding-bottom:2%;
			justify-content:center;
			flex-wrap:wrap;
		}
		
		.img-cat{
			object-fit: contain;
		}

		.ruta li:first-child{
			margin-left:5px;
		}

        .ruta li:last-child{
			border:none;
			text-decoration: none;
		}

		#form-filtrado{
			width: 100%;
			justify-content: center;
			padding: 0;
		}

		.producto{
			height:300px;
			min-height: auto;
			margin: 0 1% 1% 1%;
			width: 20%;
		}

		.tituloSubcat{
			min-height: auto;
			height: auto;
		}
        
		@media screen and (max-width:1024px){
		    .producto{
		        width:40%;
		        margin: 1%;
		    }
		}
	</style>
</head>
<body id="body"> 
	<header>
		<?= $encabezado; ?> 
        <?= $encabezado_mobile; ?>
	</header>

	<main id="main">
		<?= $ruta; ?>

		<?= crearImagenes($rs); ?>

        <?= $modalNovedades; ?>

	</main>
		
	<footer id='pie'>
		<?= $pie; ?> 
	</footer>
</body>
</html>