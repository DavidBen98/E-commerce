<?php
    include ("encabezado.php");
	require 'inc/conn.php';
    include("pie.php");
 
	if (perfil_valido(1)) {
        header("location:ve.php");
    }  	
?>
<!DOCTYPE html>
<html lang="es">
<head>   
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Catato Hogar</title>
	<link rel="stylesheet" type="text/css" href="css/estilos.css" media="screen">
	<style>
		#carac {
			padding:0; 
			display:flex; 
			text-align:center; 
			width: 200px; 
			background-color: transparent;
			border: 1px solid white; 
		}

		form {
			display:flex;
			justify-content: center;
			flex-wrap: wrap;
			margin-bottom: 30px;
		}

		main{
			display:flex;
			justify-content: center;
		}

		form h1{
			font-size: 0.9em;
		}

		#cont-images{
			width:600px;
			height:600px;
			display:flex;
			justify-content:center;
			background-color:white;
			border-right: 1px solid #D3D3D3;
		}

		#cont-descripcion{
			background-color:white;
			padding: 0 10px;
		}

		.img-cat{
			object-fit: contain;
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
								<input type='hidden' name='codImg' value='$variable' />
								
								<h1>{$row['descripcion']}</h1>
								
								Precio:<input type='text' id='precio' name='precio' value='{$row['precio']}'  title='El precio es:{$row['precio']}' readonly/>
								
								<h2>Características:</h2> 
								
								<textarea id='carac' name='carac' cols='1' rows='15' title='Caracteristicas' readonly> 
								Material:  {$row['material']}
								Color:  {$row['color']} 
								Marca:  {$row['marca']} 
								";
								
								for ($i=0;$i<count($aCarac);$i++){
									echo " $aCarac[$i] 
									\n  \n
									";
								}
								
								echo"</textarea>"; 
								
								if($row['stock'] == 0){
									echo "<p>Lo sentimos, no tenemos stock de este artículo.
									Si desea saber cuando volverá a tener stock suscríbase a las novedades.
									Gracias.
									</p>
									";
								}
								else{
									echo"";
									if ($perfil != "U"){
										echo"<p>Si desea comprar este artículo por favor regístrese </p>";
									} 
									else{
										echo"  <input type='number' id='cantidad' name='cantidad' value='1' min='1' max='{$row['stock']}' title='Seleccione el numero de articulos que quiere'/>
										<input type='submit' id='btn-enviar' value='Agregar al carrito'>
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