<!DOCTYPE html>
<?php  
	include('config.php');
	include ("encabezado.php");
	include ("pie.php");
	include ("inc/conn.php"); 
	
	if ($perfil == "E"){ 
		header("location:veABMProducto.php");
	}	 

	$ruta = "<ol class='ruta'>
				<li style='margin-left:5px;'><a href='index.php'>Inicio</a></li>
				<li style='border:none;text-decoration: none;'>Subcategorías</li>
			</ol>
	";

	global $db;  

	$imagenes = $_GET['categoria'];

	$sql = "SELECT s.nombre_subcategoria, p.codigo, p.precio, p.id
	 		FROM subcategoria as s
	 		INNER JOIN producto as p on s.id_subcategoria = p.id_subcategoria
			INNER JOIN categoria as c on c.id_categoria = s.id_categoria
	 		WHERE c.nombre_categoria = '$imagenes' AND `codigo` LIKE '%1'
	";
	
	$rs = $db->query($sql);
?>
<html lang="es"> 
<head> 
    <meta charset="UTF-8">
    <title>Muebles Giannis</title>
    <link type="text/css"  href="assets/css/estilos.css" rel="stylesheet"/>
    <link rel="icon" type="image/png" href="images/logo_sitio.png">
	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
	<script src="js/funciones.js"></script>
	<style>
		#main{
			display:flex;
			padding-bottom:10px;
			justify-content:center;
			flex-wrap:wrap;
		}
		
		.img-cat{
			object-fit: contain;
		}

		#form-filtrado{
			width: 100%;
			justify-content: center;
			padding: 0;
		}

		.producto{
			height:300px;
			min-height: auto;
		}

		.tituloSubcat{
			min-height: auto;
			height: auto;
		}
	</style>
</head>
<body id="body"> 
	<header>
		<?= $encabezado; ?> 
	</header>

	<main id="main">
		<?= $ruta; ?>

		<?= crearImagenes($rs); ?>
	</main>
		
	<footer id='pie'>
		<?= $pie; ?> 
	</footer>
</body>
</html>