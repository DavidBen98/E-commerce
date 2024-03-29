<?php
	include_once "../controlador/config.php";
	require_once "../inc/conn.php";
    include_once  "encabezado.php";
    include "modalNovedades.php";
    include_once "pie.php";
	 
	if (perfil_valido(1)) {
        header("location:veABMProducto.php");
		exit;
    }  	
	
	$ruta = "<ol class='ruta'>
				<li><a href='index.php'>Inicio</a></li>
	";

	$categoria = isset($_GET["categoria"])? $_GET["categoria"] : null;
	$subcategoria = isset($_GET["subcategoria"])? $_GET["subcategoria"]: null;

	if ($categoria != null){
		$ruta .= "<li><a href='subcategoria.php?categoria=$categoria'>Subcategorías</a></li>
			  	  <li><a href='productos.php?cate=$categoria&sub=$subcategoria'>Productos</a></li>
		";
	}
	else{
		$ruta .= "<li><a href='productos.php?productos=todos'>Productos</a></li>";
	}

	if (isset($_GET["art"])){
		$codigo = $_GET["art"] ;
		$rs = obtener_producto($codigo);

		foreach ($rs as $row) { 	
			$ruta .= "<li>{$row['descripcion']}</li>
				</ol>
			";

			$caracteristicas = $row["caracteristicas"];
			$arreglo_caracteristicas = explode (',', $caracteristicas);
			$id = $row["id"];

			//Separar la descripción que viene en la columna "caracteristicas" en la BD
			$parrafo_caracteristica = "";
			for ($i=0; $i<count($arreglo_caracteristicas); $i++){
				$posicion = stripos ($arreglo_caracteristicas[$i],':');
				$caracteristica = substr($arreglo_caracteristicas[$i], 0, $posicion+1);
				$caracteristica = ucfirst($caracteristica); 
				$detalle = substr($arreglo_caracteristicas[$i], $posicion+2, strlen($arreglo_caracteristicas[$i]));
				$caracteristica = "<b> $caracteristica </b>";

				$parrafo_caracteristica .= "<p> $caracteristica $detalle </p><br>";
			} 

			if($row["stock"] == 0){
				$stock .= "
					<p>Lo sentimos, no poseemos stock de este artículo.
						Si desea saber cuando volverá a tener stock suscríbase a las novedades.
						Gracias.
					</p>
				";
			}
			else{
				$botones = "
					<input type='button' id='btn-enviar' onclick='agregarProducto($id)' class='btn' value='Agregar al carrito'>
					<input type='button' id='btn-fav' onclick='agregarFavorito($id)' class='btn' value='Agregar a favoritos'>
				";						
			}

			if (isset($_GET["fav"])){
				$fav = $_GET["fav"];
				if ($fav == "ok"){
					$mensaje = "
						<div class='mensaje' id='mensaje-exito'>
							¡El producto se ha agregado a <a href='favoritos.php'>favoritos</a> correctamente!
						</div>
					";
				}
				else{
					$mensaje = "
						<div class='mensaje' id='mensaje-advertencia'>
							¡El producto ya pertenece a <a href='favoritos.php'>favoritos</a>!
						</div>
					";
				}
			}

			$path = obtener_imagen_producto($id);

			$contenedor_articulo = "
				<div class='contenedor'> 
					<div id='cont-images'>
						<img src='../$path' class='img-cat' title='Producto en detalle' alt='{$row["descripcion"]}'>                                   
					</div>

					<div id='cont-descripcion'>
						<div class='cont-fund'>
							<input type='hidden' name='codigoImagen' value='$codigo'>
							
							<h1>{$row["descripcion"]}</h1>
			";
							
			if ($row["descuento"] != 0){
				$precio_descuento = $row["precio"] - ($row["precio"]*$row["descuento"]/100);
				$contenedor_articulo .= "
					<h2 class='precio-descuento'>
						$ ". $precio_descuento ." 
					</h2>
					<h3 id='precio-corriente'  title='El precio es: $".$row["precio"]."'>$ {$row["precio"]}</h3>
				";
			}
			else{
				$contenedor_articulo .= "
					<h2 id='precio' title='El precio es: $".$row["precio"]."'>$ {$row["precio"]}</h2>
					<input type='hidden' name='precio' value='{$row["precio"]}' />
				";
			}

			$contenedor_articulo .="
				</div>

				<div class='carac-prod'>
					<div id='carac' title='Caracteristicas'>
						<p><b>Material: </b>" .  $row["material"] . "</p><br>
						<p><b>Color:</b> " . $row["color"] . " </p><br>
						<p><b>Marca:</b> " . $row["marca"].  "</p><br>
						$parrafo_caracteristica
					</div>
				</div>
			";
									
			if($row["stock"] == 0){
				// $contenedor_articulo .= $sinStock; 
				$contenedor_articulo .= ""; 
			}
			else{
				$contenedor_articulo .= $botones;						
			}

			if (isset($fav)){
				$contenedor_articulo .= $mensaje;
			}

			$contenedor_articulo .=	"
					</div>
				</div>
				
				<a href='javascript:window.print()' id='btn-imp' title='Imprimir listado'>
					<img src='../images/iconos/logo_imprimir.png' id='imprimir' title='Imprimir listado' alt='icono imprimir.'>
				</a>
			";                    
		}
	} else {
		$ruta .= "
				<li>Detalle artículo</li>
			</ol>
		";

		$contenedor_articulo = "
				<div class='contenedor-vacio'> 
					<p> 
						Lo sentimos, ha ocurrido un error.
					</p>
						<a href='productos.php?productos=todos'> Volver a ver el catálogo completo </a>
				</div>
		";
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>   
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Muebles Giannis</title>
	<link rel="stylesheet" type="text/css" href="../assets/css/estilos.css" media="screen">
    <link rel="icon" type="image/png" href="../images/iconos/logo_sitio.png">
	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="../js/funciones.js"></script>
	<style>
		main{
			display: flex;
			justify-content: center;
			flex-wrap: wrap;
		}

		#carac {
			padding: 0; 
			display: flex; 
			flex-wrap: wrap;
			justify-content: start;
		}

		.titulo-catalogo{
			display: none;
		}
		
		.ruta li{
			margin-left: 5px;
		}

		.ruta li:last-child{
			margin-left: 0;
			border: none;
			text-decoration: none;
		}

		.contenedor, .contenedor-vacio {
			display: flex;
			justify-content: center;
			flex-wrap: wrap;
			margin-bottom: 6%;
			padding: 2%;
			background-color: white;
			width: 80%;
			border-radius: 5px;
			align-items: start;
		}

		.contenedor-vacio p{
			width: 100%;
			text-align: center;
		}

		.contenedor-vacio a{
			text-decoration: underline;
		}

		.contenedor h1{
			font-size: 0.9em;
		}

		.cont-fund h1{
			font-size: 30px; 
			font-weight: 600; 
			font-family: proxima-nova;
		}

		#precio-corriente{
			text-decoration: line-through; 
			margin: 0;
			font-weight: 100;
			padding-top: 2%;
		}

		.precio-descuento{
			font-size: 2em;
			font-weight: 500;
		}

		#cont-images{
			width: 56%;
			display: flex;
			justify-content: center;
			background-color: white;
			border-right: 1px solid #D3D3D3;
		}

		#cont-descripcion{
			background-color: white;
			width: 40%;
			margin: 0 auto;
		}

		.img-cat{
			object-fit: contain;
			height: 100%;
    		width: 100%;
			border-bottom: none;
		}

		.enlaces{
			font-size: 1.1em;
			color: #B2BABB;
			text-decoration: underline;
		}

		#carac p{
			width: 100%;
			margin: 2px 0;
		}

		#btn-enviar{
			margin-top: 8%;
			width: 100%;
			background: rgba(147, 81, 22,0.5); 
			color: white;
		}

		#btn-enviar:hover{
			background-color: rgba(147, 81, 22,0.7);
			color: white;
		}

		#precio{
			font-weight: 300;
			font-size: 36px;
			font-family: "Proxima Nova";
		}

		h2{
			margin: 0;
		}

		.cont-fund{
			margin-bottom: 4%;
		}

		.parrafo-exito{
            background-color: #099;
			width: 100%;
			padding: 4% 0;
			color: white;
			margin-top: 6%;
			border-radius: 5px;
			text-align: center;
		}

		#btn-fav{
			width: 100%; 
			margin-top: 3%;
			background-color: rgba(99,110,114, 0.1);
			color: black;
		}
		
		#btn-fav:hover{
			background-color: rgba(99,110,114, 0.5);
			color: white;
		}

		.mensaje{
            text-align: center;
            background-color: #000;
            color: white;
            border-radius: 5px;
			padding: 2% 0;
			margin-top: 3%;
			width: 100%;
            font-size: 1.1rem;
        }

        .mensaje a, .carrito-compras{
            text-decoration: underline;
            color: white;
            transition: all 0.5s linear;
        }

		#mensaje-exito{
			background-color: #099;
		}

		#mensaje-advertencia{
			background: rgb(241, 196, 15); 
			color:#000;
		}

		#mensaje-advertencia a{
			color:#000;
		}

        .mensaje a:hover, .carrito-compras:hover{
            transition: all 0.5s linear;
        }

		#btn-imp img{
			border:0;
			width:32px;
			height:32px;
		}

		@media print {				
			header, #imprimir, #pie, #btn-enviar, .parrafo-exito, .mensaje, #btn-fav, .ruta, #form-novedades{
				display:none;
			}

			.img-cat {
				height: 400px;
				width: 400px;
			}

			#cont-images{
				height:410px;
				width:410px;
				border:none;
			}

			.titulo-catalogo{
				display:block;
			}
		}

		@media screen and (max-width: 860px) {
			#cont-images, #cont-descripcion{
				width: 100%;
				border:none;
				text-align:center;
			}

			#btn-imp{
				display:none;
			}

			.ruta{
				min-height: 5%;
				margin: 0;
				height: auto;
			}

			.contenedor{
				margin: 5% 0;
			}

			.precio{
				justify-content:center;
			}
		}
	</style>
</head>
<body>
	<header>
    	<?= imprimir_encabezado($encabezado, $encabezado_mobile); ?>
	</header>
	
    <main id="main">
		<p class="titulo-catalogo">Muebles Giannis</p>

		<?= $ruta ?>

		<?= $contenedor_articulo ?>
		<?= $modal_novedades ?>
	</main>
	
	<footer id="pie">
		<?= $pie; ?> 
	</footer>	 
</body>
</html>