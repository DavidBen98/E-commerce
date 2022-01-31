<?php
	include_once('config.php');
    include_once ("encabezado.php");
	require_once 'inc/conn.php';
    include_once("pie.php");
	 
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<script>
		// $(document).ready(function(){
		// 	actualizarCarrito();

		// $('#btn-enviar').click (function (){
		// 	actualizarCarrito();
		// });

		// });

		// function actualizarCarrito (){
		// 	$.ajax ({
		// 		type: "POST",
		// 		url: "agregarCarrito.php",
		// 		//data: "provincia=" + $('#provincia').val(),
		// 		success: function (r){
		// 			$('#num-car').html (r);
		// 		}
		// 	});
		// }	


		// function actualizarCarrito (){
		// 	const http = new XMLHttpRequest();
		// 	const url = 'http://localhost/E-commerceMuebleria/agregarCarrito.php';

		// 	http.onreadystatechange = function (){
		// 		if(this.readyState == 4 && this.status == 200){

		// 		}
		// 	}

		// 	http.open ("GET", url);
		// 	http.send ();
		// }

		// document.getElementById('btn-enviar').addEventListener ("click", function () => {
		// 	actualizarCarrito ();
		// });
		// function actualizarCarrito (){
		// 	<?php 
		// 		if (!isset($_SESSION['carrito'][$id])){
		// 			$_SESSION['carrito'][$id] = 1;
		// 		}
		// 		else{
		// 			$_SESSION['carrito'][$id] = 1;
		// 		}
		// 	?>
		// }


		function agregarProducto (id){
			var param = {
				id: id
			};

			$.ajax({
				data: param,
				url: "agregarCarrito.php",
				method: "post",
				success: function(data) {
					var datos = JSON.parse(data);

					if (datos['ok']){
						let cantCarrito = document.getElementById('num-car');
						cantCarrito.innerHTML = datos.numero;
					}
				}
			});			
		}

	</script>
	<style>
		main{
			display:flex;
			justify-content: center;
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
			margin-top:15px;
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
			
			$sql = "SELECT *
					FROM `producto`
					$where_sql; ";
			$rs = $db->query($sql);
				
			foreach ($rs as $row) { 	
				$caract = $row['caracteristicas'];
				$aCarac = explode (',', $caract);
				$id = $row['id'];

				echo "<div class='contenedor'> 
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
									
									<div id='carac' name='carac' title='Caracteristicas'> ";
									echo "
										<p><b>Material: </b>" .  $row['material'] . "</p><br>
										<p><b>Color:</b> " . $row['color'] . " </p><br>
										<p><b>Marca:</b> " . $row['marca'].  "</p><br>
									";
									
									//Separar la descripcion que viene en la columna "caracteristicas" en la BD
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
									echo "<p>Lo sentimos, no poseemos stock de este artículo.
									Si desea saber cuando volverá a tener stock suscríbase a las novedades.
									Gracias.
									</p>
									";
								}
								else{
									$boton = "<input type='button' id='btn-enviar' onclick='agregarProducto($id)' class='btn' value='Agregar al carrito'>";
									echo $boton;						
								}
					echo	"</div>
					</div>";                    
			}
		?>
	</main>

	<script>	
		window.onload = function() {
			var agregar = document.getElementById('btn-enviar');
			var carrito = document.getElementById('num-car');

			//agregar.onclick = actualizarCarrito;		
			// 	actualizarCarrito ();

			// 	window.location.href='productos.php?productos=todos';
			// });
		}
	</script>
		
	<?php 
		echo $pie; 
	?> 	 
</body>
</html>