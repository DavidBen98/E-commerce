<?php  
	include('config.php');
	include ("encabezado.php");
	include ("barra_lateral.php"); 
	include ("pie.php");
	include ("inc/conn.php"); 
	
	if ($perfil == "E"){ 
		header("location:ve.php");
	}	 

	global $db;  

	$imagenes = $_GET['cat'];
	$imagenes = substr($imagenes,0,2);

	$sql = "SELECT s.nombre_subcategoria, p.codigo, p.precio
	 		FROM subcategoria as s
	 		INNER JOIN producto as p on s.id_subcategoria = p.id_subcategoria
	 		Where `codigo` LIKE '$imagenes%%1'";
	
	$rs = $db->query($sql);
?>
<!DOCTYPE html>
<html lang="es"> 
<head> 
    <meta charset="UTF-8">
    <title>Catato Hogar</title>
    <link type="text/css"  href="css/estilos.css" rel="stylesheet"/>
	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
	<script src="js/funciones.js"></script>
	<style>
		#main{
			display:flex;
			padding: 20px 0 10px 0;
			justify-content:center;
		}

		#header-buscar {
			width: 500px;
			height: 35px;
		}

		.img-cat{
			object-fit: contain;
		}
	</style>
	<script>      
        window.onload = function() {
            let imagenes = document.getElementsByClassName('img-cat'); //Imagenes de los productos
			let formulario = document.getElementById('form-filtrado');
			let imgProducto = document.getElementsByClassName('producto');

			//Estilos
			formulario.style.width = '100%';
			formulario.style.justifyContent = 'center';
			formulario.style.padding = '0';

			for (let i=0; i<imgProducto.length; i++){
				imgProducto[i].style.height = '300px';
			}
 
			//Enviar a prod segun la subcategoria que se eligió
            for (j=0;j<imagenes.length;j++){
                let imagen = imagenes[j].getAttribute('alt');
                imagen = imagen.substring(0, imagen.length - 1);
                imagenes[j].addEventListener("click", () => {
                    window.location = 'productos.php?prod='+imagen;});
            };	
        }            
    </script>
</head>
<body id="body"> 
	<header>
		<?php echo $encab; ?> 
	</header>

	<main id="main">	
		<aside>
		</aside>
		<?php 						 
			crearImagenes($rs); 				
		?>
	</main>
		
	<?php 
		echo $pie;
	?>

</body>
</html>