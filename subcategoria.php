<!DOCTYPE html>
<?php  
	include('config.php');
	include ("encabezado.php");
	include ("pie.php");
	include ("inc/conn.php"); 
	
	if ($perfil == "E"){ 
		header("location:ve.php");
	}	 

	global $db;  

	$imagenes = $_GET['categoria'];
	$imagenes = substr($imagenes,0,2);

	$sql = "SELECT s.nombre_subcategoria, p.codigo, p.precio
	 		FROM subcategoria as s
	 		INNER JOIN producto as p on s.id_subcategoria = p.id_subcategoria
	 		WHERE `codigo` LIKE '$imagenes%%1'";
	
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
		}
	</style>
	<script>      
		document.addEventListener ('DOMContentLoaded', () => {
			let imagenes = document.getElementsByClassName('img-cat'); //Imagenes de los productos
			let categoria = getQueryVariable ('categoria');
	
			//Enviar a prod segun la subcategoria que se eligió
			for (j=0;j<imagenes.length;j++){
				let imagen = imagenes[j].getAttribute('alt');
				imagen = imagen.substring(0, imagen.length - 1);
				let title = imagenes[j].getAttribute('title');
				imagenes[j].addEventListener("click", () => {
					let redirigir = 'productos.php?articulos='+imagen+'&cate='+categoria+'&sub='+title;
					window.location = redirigir;
				});
			}
		});          
    </script>
</head>
<body id="body"> 
	<header>
		<?php echo $encab; ?> 
	</header>

	<main id="main">	
		<?php 	
			echo "<ol class='ruta'>
					<li style='margin-left:5px;'><a href='index.php'>Inicio</a></li>
					<li style='border:none;text-decoration: none;'>Subcategorías</li>
				</ol>
			";
		
			crearImagenes($rs); 				
		?>
	</main>
		
	<?php 
		echo $pie;
	?>
</body>
</html>