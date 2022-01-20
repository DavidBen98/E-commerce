<?php
	include('config.php');
    include ("encabezado.php");
	require 'inc/conn.php';
    include("pie.php");
 
	if (perfil_valido(1)) {
        header("location:ve.php");
    }  	
	//HAY QUE ACTUALIZAR LA BASE DE DATOS CON LAS CARACTERISTICAS DE LOS PRODUCTOS
?>
<!DOCTYPE html>
<html lang="es">
<head>   
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Catato Hogar</title>
	<link rel="stylesheet" type="text/css" href="css/estilos.css" media="screen">
	<script src="https://sdk.mercadopago.com/js/v2"></script>
	<style>
		#carac {
			padding:0; 
			display:flex; 
			flex-wrap:wrap;
			justify-content:start;
		}

		form {
			display:flex;
			justify-content: center;
			flex-wrap: wrap;
			margin-bottom: 30px;
			padding: 10px;
			background-color: white;
			width: 90%;
		}

		main{
			display:flex;
			justify-content: center;
		}

		form h1{
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
			margin:15px;
		}

		#precio{
			font-weight: 300;
			font-size: 36px;
			font-family: "Proxima Nova";
		}

		.cont-fund{
			margin-bottom:15px;
		}
	</style>
</head>
<body>
	<header>
    	<?php echo $encab; ?>
	</header>
    <main id='main'>
		<?php
    	global $db;
		$variable = $_GET['art'] ;
    	$where_sql = "WHERE codigo = '$variable'";
		
    	$sql = "SELECT codigo, descripcion, material, color, caracteristicas, marca, stock, precio
   			 FROM `producto`
   			 $where_sql; ";
   	 	$rs = $db->query($sql);
   		 
   	 	foreach ($rs as $row) { 
				
				$caract = $row['caracteristicas'];
				$aCarac = explode (',', $caract);
				
				echo "<form action='nueva_compra.php' method='post'> 
							<div id='cont-images'>
								<img src='images/$variable.png' class='img-cat' title='{$row['descripcion']}' >                                   
							</div>
							<div id='cont-descripcion'>
								<div class='cont-fund'>
									<input type='hidden' name='codImg' value='$variable' />
									
									<h1 style='font-size: 30px; font-weight:600; font-family: proxima-nova;'>{$row['descripcion']}</h1>
									
									<span id='precio' name='precio' value='{$row['precio']}'  title='El precio es:{$row['precio']}'>$ {$row['precio']}</span>
								</div>
								<div class='carac-prod'>
									
									<div id='carac' name='carac' title='Caracteristicas'> ";
									echo "
										<p><b>Material: </b>" .  $row['material'] . "</p><br>
										<p><b>Color:</b> " . $row['color'] . " </p><br>
										<p><b>Marca:</b> " . $row['marca'].  "</p><br>
									";
									
									for ($i=0;$i<count($aCarac);$i++){
										$posicion = stripos ($aCarac[$i],':');
										$caracteristica = substr($aCarac[$i], 0, $posicion+1);
										$caracteristica = ucfirst($caracteristica); 
										$detalle = substr($aCarac[$i], $posicion+2, strlen($aCarac[$i]));
										$caracteristica = "<b>". $caracteristica  ."</b>";
										echo "<p>$caracteristica $detalle</p><br>";
									} 
									echo "</div>
								</div>";
								
								if($row['stock'] == 0){
									echo "<p>Lo sentimos, no tenemos stock de este artículo.
									Si desea saber cuando volverá a tener stock suscríbase a las novedades.
									Gracias.
									</p>
									";
								}
								else{
									if (!isset($_SESSION['user_first_name']) && $perfil != "U"){
										echo"<p>Si desea comprar este artículo por favor <a href='login.php?reg=true' class='enlaces'>Registrarse</a> o <a href='login.php' class='enlaces'>Iniciar sesión</a> </p>";
									}
									else{
										echo"  <input type='number' id='cantidad' name='cantidad' value='1' min='1' max='{$row['stock']}' title='Seleccione el numero de articulos que quiere'/> <br>
										<input type='submit' id='btn-enviar' class='btn' value='Agregar al carrito'>
										";
									}	 						
								}
								echo "</div>";
				echo "</form>";                    
			}
			?>
	</main>
		
	<?php 
		echo $pie; 
	?> 	 
</body>
</html>