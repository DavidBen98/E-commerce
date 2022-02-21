<?php
	include_once('config.php');
    include_once ("encabezado.php");
	require_once 'inc/conn.php';
    include_once("pie.php");
	 
	if (perfil_valido(1)) {
        header("location:ve.php");
    }  	
	
	global $db;

	$ruta = "<ol class='ruta'>
				<li style='margin-left:5px;'><a href='index.php'>Inicio</a></li>";

	$cat = $_GET['categoria'];
	$sub = $_GET['subcategoria'];
	$art = $_GET['articulos'];
	if ($cat != "false"){
		$ruta .= "<li style='margin-left:5px;'><a href='subcategoria.php?categoria=$cat'>Subcategorías</a></li>
			  	  <li style='margin-left:5px;'><a href='productos.php?articulos=$art&cate=$cat&sub=$sub'>Productos</a></li>
		";
	}
	else{
		$ruta .= "<li style='margin-left:5px;'><a href='productos.php?productos=todos'>Productos</a></li>";
	}

	$variable = $_GET['art'] ;
	$where_sql = "WHERE codigo = '$variable'";

	$sql = "SELECT *
			FROM `producto`
			$where_sql 
	";

	$rs = $db->query($sql);

	foreach ($rs as $row) { 	
		$ruta .= "<li style='border:none;text-decoration: none;'>{$row['descripcion']}</li>
			</ol>
		";

		$caract = $row['caracteristicas'];
		$aCarac = explode (',', $caract);
		$id = $row['id'];

		//Separar la descripción que viene en la columna "caracteristicas" en la BD
		$parrafoCarasteristica = "";
		for ($i=0;$i<count($aCarac);$i++){
			$posicion = stripos ($aCarac[$i],':');
			$caracteristica = substr($aCarac[$i], 0, $posicion+1);
			$caracteristica = ucfirst($caracteristica); 
			$detalle = substr($aCarac[$i], $posicion+2, strlen($aCarac[$i]));
			$caracteristica = "<b> $caracteristica </b>";

			$parrafoCarasteristica .= "<p> $caracteristica $detalle </p><br>";
		} 

		if($row['stock'] == 0){
			$stock .= "<p>Lo sentimos, no poseemos stock de este artículo.
							Si desea saber cuando volverá a tener stock suscríbase a las novedades.
							Gracias.
					  </p>
			";
		}
		else{
			$botones = "<input type='button' id='btn-enviar' onclick='agregarProducto($id)' class='btn' value='Agregar al carrito'>
						<input type='button' id='btn-fav' onclick='agregarFavorito($id)' class='btn' value='Agregar a favoritos' style='width:100%; margin-top:15px;'>";						
		}

		if (isset($_GET['fav'])){
			$fav = $_GET['fav'];
			if ($fav == 'ok'){
				$mensaje = "<div class='mensaje' id='mensaje' style='background-color: #099;'>
								¡El producto se ha agregado a <a href='favoritos.php'>favoritos</a> correctamente!
						   </div>
				";
			}
			else{
				$mensaje = "<div class='mensaje' id='mensaje' style='background: rgb(241, 196, 15); color:#000;'>
								¡El producto ya pertenece a <a href='favoritos.php' style='color:#000;'>favoritos</a>!
						   </div>
				";
			}
		}

		$contenedor = "<div class='contenedor'> 
							<div id='cont-images'>
								<img src='images/$variable.png' class='img-cat' title='{$row['descripcion']}' >                                   
							</div>

							<div id='cont-descripcion'>
								<div class='cont-fund'>
									<input type='hidden' name='codImg' value='$variable' />
									
									<h1 style='font-size: 30px; font-weight:600; font-family: proxima-nova;'>{$row['descripcion']}</h1>
									
									<span id='precio' value='{$row['precio']}'  title='El precio es: $".$row['precio']."'>$ {$row['precio']}</span>
									<input type='hidden' name='precio' value='{$row['precio']}' />
								</div>

								<div class='carac-prod'>
									<div id='carac' name='carac' title='Caracteristicas'>
										<p><b>Material: </b>" .  $row['material'] . "</p><br>
										<p><b>Color:</b> " . $row['color'] . " </p><br>
										<p><b>Marca:</b> " . $row['marca'].  "</p><br>
										$parrafoCarasteristica
									</div>
								</div>
		";
								
								if($row['stock'] == 0){
									$contenedor .= $sinStock; 
								}
								else{
									$contenedor .= $botones;						
								}

								if (isset($fav)){
									$contenedor .= $mensaje;
								}

		$contenedor .=	"</div>
			</div>
			
			<a href='javascript:window.print()' id='btn-imp' title='Imprimir listado'>
					<img src='images/logo_imprimir.png' id='imprimir' title='Imprimir listado' alt='icono imprimir.' style='border:0;width:32px;height:32px;'>
			</a>";                    
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>   
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Muebles Giannis</title>
	<link rel="stylesheet" type="text/css" href="assets/css/estilos.css" media="screen">
    <link rel="icon" type="image/png" href="images/logo_sitio.png">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="js/funciones.js"></script>
	<style>
		main{
			display:flex;
			justify-content: center;
			flex-wrap:wrap;
		}

		#carac {
			padding:0; 
			display:flex; 
			flex-wrap:wrap;
			justify-content:start;
		}

		.contenedor {
			display:flex;
			justify-content: center;
			flex-wrap: wrap;
			margin-bottom: 30px;
			padding: 10px;
			background-color: white;
			width: 90%;
			border-radius:5px;
		}

		.contenedor h1{
			font-size: 0.9em;
		}

		#cont-images{
			height:600px;
			display:flex;
			justify-content:center;
			background-color:white;
			border-right: 1px solid #D3D3D3;
		}

		#cont-descripcion{
			background-color:white;
			padding-left:15px;
			width: 40%;
		}

		.img-cat{
			object-fit: contain;
			height:600px;
			width: 600px;
			border-bottom: none;
		}

		.enlaces{
			font-size:1.1em;
			color: #B2BABB ;
			text-decoration: underline;
		}

		#carac p{
			width:100%;
			margin: 2px 0;
		}

		#btn-enviar{
			margin-top:20px;
			width:100%;
			background: rgba(147, 81, 22,0.7); 
			color: white;
		}

		#btn-enviar:hover{
			background-color: rgba(147, 81, 22,1);
			color: white;
		}

		#precio{
			font-weight: 300;
			font-size: 36px;
			font-family: "Proxima Nova";
		}

		.cont-fund{
			margin-bottom:15px;
		}

		.parrafo-exito{
            background-color: #099;
			width:100%;
			padding: 10px 0;
			color: white;
			margin-top: 15px;
			border-radius: 5px;
			text-align:center;
		}

		#btn-fav:hover{
			background-color: #000;
		}

		.mensaje{
            text-align: center;
            background-color: #000;
            color: white;
            border-radius:5px;
			padding:10px 0;
			margin-top:15px;
			width:100%;
            font-size: 1.1rem;
        }

        .mensaje a, .carrito-compras{
            text-decoration: underline;
            color: white;
            transition: all 0.5s linear;
        }

        .mensaje a:hover, .carrito-compras:hover{
            font-size:1.2rem;
            transition: all 0.5s linear;
        }

		@media print {				
			header, #imprimir, #pie, #btn-enviar, .parrafo-exito, .mensaje, #btn-fav, .ruta{
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

			.h1{
				display:block;
			}
		}
	</style>
</head>
<body>
	<header>
    	<?= $encab; ?>
	</header>
	
    <main id='main'>
		<p class='h1' style='display:none;'>Muebles Giannis</p>

		<?= $ruta ?>

		<?= $contenedor ?>
	</main>
	
	<footer id='pie'>
		<?= $pie; ?> 
	</footer>	 
</body>
</html>