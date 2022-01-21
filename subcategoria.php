<!DOCTYPE html>
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

	$imagenes = $_GET['categoria'];
	$imagenes = substr($imagenes,0,2);

	$sql = "SELECT s.nombre_subcategoria, p.codigo, p.precio
	 		FROM subcategoria as s
	 		INNER JOIN producto as p on s.id_subcategoria = p.id_subcategoria
	 		Where `codigo` LIKE '$imagenes%%1'";
	
	$rs = $db->query($sql);
?>
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
		function getQueryVariable(variable) {
			var query = window.location.search.substring(1);
			var vars = query.split("&");
			for (var i=0; i < vars.length; i++) {
				var pair = vars[i].split("=");
				if(pair[0] == variable) {
					return pair[1];
				}
			}
			return false;
		}
        window.onload = function() {
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
        }            
    </script>
</head>
<body id="body"> 
	<header>
		<?php echo $encab; ?> 
	</header>

	<main id="main">	
		<?php 						 
			crearImagenes($rs); 				
		?>
	</main>
		
	<?php 
		echo $pie;
	?>

</body>
</html>