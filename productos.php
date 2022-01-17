<?php 
	include('config.php');
	include ("encabezado.php");
    include("pie.php");
	require 'inc/conn.php';
	include ("barra_lateral.php"); 

	if ($perfil == "E"){ 
		header("location:ve.php");
	} 

	global $db;  
	$rs = "";
	 
	$sql  = "SELECT c.nombre_categoria,descripcion, s.nombre_subcategoria, codigo, precio
			FROM `producto` as p
			INNER JOIN categoria as c ON p.id_categoria = c.id_categoria
			INNER JOIN subcategoria as s ON p.id_subcategoria = s.id_subcategoria";

	$where_sql = "";
	$categoria = (isset($_POST['categoria']))? $_POST['categoria'] : -1;
	$subcategoria = (isset($_POST['subcategoria']))? $_POST['subcategoria'] : -1;
	$filtros = [isset($_POST['color'])? $_POST['color']:null,
				isset($_POST['marca'])? $_POST['marca']:null,
				isset($_POST['valorMin'])? $_POST['valorMin']:null,
				isset($_POST['valorMax'])? $_POST['valorMax']:null,
				isset($_POST['orden'])? $_POST['orden']:null];

	if ($categoria != -1){
		$where_sql = " WHERE p.id_categoria like '$categoria' ";
	}
	else{
		$where_sql = " WHERE p.id_categoria like '%' ";
	}

	if ($subcategoria != -1){
		$where_sql .= " AND p.id_subcategoria like '$subcategoria' ";
	}
	else{
		$where_sql .= " AND p.id_subcategoria like '%' ";
	}

	$sql .= $where_sql;

	$sql = completarWhere($sql, $filtros);
	$rs = $db->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="JS/jquery-3.3.1.min.js"></script>
    <script src="JS/funciones.js"></script>
    <title>Catato Hogar</title>
    <link type="text/css"  href="css/estilos.css" rel="stylesheet"/>
    <script>
		window.onload = function() { 
            let imagenes = document.getElementsByClassName('img-cat');
            for (j=0;j<imagenes.length;j++){
                let articulo = imagenes[j].getAttribute('alt');
                imagenes[j].addEventListener("click", () => {window.location = 'detalle_articulo.php?art='+articulo;});
           	};

			let catalogo = document.getElementById('catalogo'); //Boton excel
            let btn = document.getElementById('btn-imp'); //Boton imprimir

			catalogo.addEventListener("click", () => { //Imprimir catalogo
				let variable = "";
				for (j=0;j<imagenes.length-1;j++){
					variable += imagenes[j].getAttribute('alt') + ","; //todos los codigos separados por ,
				}
				variable+= imagenes[imagenes.length-1].getAttribute('alt');
				window.location = 'listado_xls.php?imagen='+variable; //se manda por url, se recibe por get en listado_xls
			});	

			let cambiar = document.getElementById('cambiar-filtro');
			let form = document.getElementById('datos');

			cambiar.addEventListener("click", () => {
				if (form.style.display == 'block'){
					form.style.display = 'none';
				}
				else{
					form.style.display = 'block';
				}
            });
			
			if (cambiar != null){
				form.style.display = 'none';
			}
    	};
	</script>
    <style>
        #body{
            font-family: "Salesforce Sans", serif;
            font-size: 1.2rem;
            line-height: 1.5em;
            margin: 0px;
        }

		#main{
			display:flex;
			padding: 20px 0 10px 0;
			justify-content:start;
		}

		/*ASIDE*/
		aside{
			margin-bottom:10px;
		}

		.barra-lateral {
			width:30%;
			align-content: flex-start;
			padding-left:4px;
			padding-right:4px;
			order: 0;
		}

		#min-max{
			width:100%;
			display:flex;
			flex-wrap:wrap;
			justify-content:center;
			padding-left:4px;
		}

		.btn-select{
			margin: 4px;
		}

		#lmaxmin{
			display:block;
		}

		@media print {				
			main { 
				font-size:18pt; 
				font-family:"times new roman",times;
				color:#000;
				background-color:#FFFFFF; 	
				width:100%;
				border:none;
			}

			#tit-catalogo {display:block;}
			header { display:none;}
			#datos { display:none;}
			#catalogo {display:none;}
			#imprimir {display: none;}
			#pie {display: none;}
		}

		.marcas, .colores{
			height: 150px;
			overflow-x: hidden;
			overflow-y: auto;
			margin-top: 20px;
		}

		.color, .marca{
			display:flex;
			justify-content:start;
			align-items: center;
			width:50%;
		}

		.form-select{
			width:80%;
		}

		#colores, #marcas{
			width:100%;
			display:flex;
			flex-wrap:wrap;
		}

		#datos{
			width:100%;
		}

		.caracteristicas{
			flex-wrap:wrap;
			width:230px;
		}

		.img-cat{
			object-fit: contain;
		}
    </style>
</head>
<body>   
    <header>
		<?php echo $encab;?>
	</header>

    <main id="main">
		<aside class="barra-lateral"> 
			<?php 
				$filtro = "";
				$url = $_SERVER["REQUEST_URI"];

				echo "<div id='filtros-usados'>";
					if ($categoria != -1){
						$sql  = "SELECT c.nombre_categoria
								FROM `categoria` as c
								WHERE c.id_categoria = '$categoria'";

						$r = $db->query($sql);
						
						foreach($r as $row){
							$cat = $row['nombre_categoria'];
						}
						$filtro = "<b>Categoría:</b> ". $cat . ".<br>";
					}

					if ($subcategoria != -1){
						$sql  = "SELECT s.nombre_subcategoria
								FROM `subcategoria` as s
								WHERE s.id_subcategoria = '$subcategoria'";
						
						$r = $db->query($sql);

						foreach($r as $row){
							$subcat = $row['nombre_subcategoria'];
						}

						$filtro .= "<b>Subcategoría:</b> ". $subcat . ".<br>";
					}

					if (isset($filtros[0])){
						if (count($filtros[0]) == 1){
							$filtro .= "<b>Color: </b>";
						}
						else{
							$filtro .= "<b>Colores: </b>";
						}
						for ($i=0;$i<count($filtros[0]);$i++){ 
							if ($i == count($filtros[0])-1){
								$filtro .= $filtros[0][$i] . ". <br>"; 
							}
							else{
								$filtro .= $filtros[0][$i] . ", "; 
							}
						}
					}

					if (isset($filtros[1])){
						if (count($filtros[1]) == 1){
							$filtro .= "<b>Marca: </b>";
						}
						else{
							$filtro .= "<b>Marcas: </b>";
						}
						for ($i=0;$i<count($filtros[1]);$i++){ 
							if ($i == count($filtros[1])-1){
								$filtro .= $filtros[1][$i] . ". <br>"; 
							}
							else{
								$filtro .= $filtros[1][$i] . ", "; 
							}
						}
					}

					if (isset($filtros[2])){
						$filtro .= '<b>Mínimo:</b> ' . $filtros[2] . '. <br> <b>Máximo:</b> ' . $filtros[3] . ".";
					}

					if (isset($filtros[0]) || (isset($filtros[1])) || (isset($filtros[2]))){
						echo "<a href='$url' id='filtro'> $filtro </a>";
						echo "<div class='filtrado'>					
								<a href='$url' class='btn filtrado-bl' name='BorrarFiltros' title='Borrar filtros' value='Borrar filtros'>Borrar filtros</a>
								<button id='cambiar-filtro' class='btn filtrado-bl' name='CambiarFiltros' title='Cambiar filtros'>Modificar filtros</button>
							  </div>";
					}
				echo "</div>";

				crearBarraLateral();
			?>
		</aside>
		
        <?php
			crearImagenes ($rs);

			echo "  <div class='btn-doc'>
						<input type='image' src='images/logo_excel.jpeg' class='excel' id='catalogo' alt='Exportar a excel'>
						<a href='javascript:window.print();' id='btn-imp' title='Imprimir listado.'>
							<img src='images/logo_imprimir.jpeg' id='imprimir' title='Imprimir listado.' alt='icono imprimir.' style='border:0;width:32px;height:32px;'>
						</a>
					</div>";
        ?>
    </main>   
   
	<?php echo $pie;?>
</body> 
</html>