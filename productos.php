<!DOCTYPE html>
<?php
    include("pie.php");
	require 'inc/conn.php';
    include('config.php');
	include ("encabezado.php");
	include ("barra_lateral.php"); 
    //AGREGAR MAS DE UNA IMAGEN POR PRODUCTO (VER SI HAY QUE HACER UNA CARPETA PARA CADA PRODUCTO)

	if ($perfil == "E"){ 
		header("location:ve.php");
	} 

    global $db;  
	$rs = "";
    $categoria = "";
    $subcategoria = "";
    $filtros = [isset($_POST['color'])? $_POST['color']:null,
				isset($_POST['marca'])? $_POST['marca']:null,
				isset($_POST['valorMin'])? $_POST['valorMin']:null,
				isset($_POST['valorMax'])? $_POST['valorMax']:null,
				isset($_POST['orden'])? $_POST['orden']:null];

	if ($filtros[2] != null && $filtros[3] != null && $filtros[2]>$filtros[3]){
		$maximo = $filtros[2];
		$filtros[2] = $filtros[3];
		$filtros[3] = $maximo;
	}
	
    if(isset($_GET['productos'])){   
        $sql  = "SELECT c.nombre_categoria,descripcion, s.nombre_subcategoria, codigo, precio
                FROM `producto` as p
                INNER JOIN categoria as c ON p.id_categoria = c.id_categoria
                INNER JOIN subcategoria as s ON p.id_subcategoria = s.id_subcategoria";

        //Si entro desde productos entonces la categoria y la subcategoria la recupero con el formulario
        $categoria = (isset($_POST['categoria']))? intval($_POST['categoria']) : "";
        $subcategoria = (isset($_POST['subcategoria']))? intval($_POST['subcategoria']) : "";

        if ($categoria != ""){
            $sql .= " WHERE p.id_categoria like '$categoria' ";
        }
        else{
            $sql .= " WHERE p.id_categoria like '%' ";
        }

        if ($subcategoria != ""){
            $sql .= " AND p.id_subcategoria like '$subcategoria' ";
        }
        else{
            $sql .= " AND p.id_subcategoria like '%' ";
        }

        $sql = completarWhere($sql, $filtros);
        $rs = $db->query($sql);
    }
	else if (isset($_GET['buscador'])){
		$busqueda = $_GET['buscador'];

		if (trim($busqueda) != ''){
			$busqueda = str_replace('%20', ' ', $busqueda);
			$busqueda = ucfirst($busqueda);
			$palabras = explode (' ',$busqueda);			

			$sql  = "SELECT c.nombre_categoria,descripcion, s.nombre_subcategoria, codigo, precio
					 FROM `producto` as p
					 INNER JOIN categoria as c ON p.id_categoria = c.id_categoria
					 INNER JOIN subcategoria as s ON p.id_subcategoria = s.id_subcategoria
					 WHERE nombre_categoria LIKE '%".$busqueda."%' 
					 OR nombre_subcategoria LIKE '%".$busqueda."%'
					 OR descripcion LIKE '%".$busqueda."%'";

			foreach ($palabras as $palabra){
				if (strlen($palabra) > 3){ //Si es una palabra mayor a 3 letras
					$sql .= " OR nombre_categoria LIKE '%".$palabra."%'
							  OR nombre_subcategoria LIKE '%".$palabra."%'
							  OR descripcion LIKE '%".$palabra."%'";
				}
			}
			
			$rs = $db->query($sql);
		}
	}	 
    else{
        $sql = "SELECT `codigo`, `descripcion`, `precio`,`id_categoria`
				FROM producto";

        //Si entro desde subcategorias entonces la categoria y la subcategoria esta en la url
        $catSubcat = $_GET['articulos'];
        $sql = "SELECT `codigo`, `descripcion`, `precio`,`id_categoria`, `id_subcategoria`
                FROM producto
                WHERE codigo like '$catSubcat%'";

		$categoria = $_GET['cate'];
		$subcategoria = $_GET['sub'];

        $sql = completarWhere($sql, $filtros);
        $rs = $db->query($sql);
    }
?>
<html lang="es"> 
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css"  href="css/estilos.css" rel="stylesheet"/>
    <link rel="icon" type="image/png" href="images/logo_sitio.png">
	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
	<script src="js/funciones.js"></script>
    <title>Muebles Giannis</title>
	<style>
		#main{
			display:flex;
			padding: 20px 0 10px 0;
			justify-content: center;
		}

		aside{
			margin-bottom:10px;
		}

		.barra-lateral {
			width:25%;
			align-content: flex-start;
			padding: 10px 5px;
			order: 0;
			border-radius: 5px;
		}

		#min-max{
			width:100%;
			display:flex;
			flex-wrap:wrap;
			justify-content:center;
			padding-left:4px;
			margin-top: 20px;
		}

		.btn-select{
			margin: 4px;
		}

		#lmaxmin{
			display:block;
			width:100%;
			text-align:center;
		}

		.marcas, .colores{
			max-height: 150px;
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
			height:130px;
		}

		.img-cat{
			object-fit: contain;
		}
    </style>
    <script> 

		if (window.addEventListener){
			window.addEventListener ('load', () => {
				let imagenes = document.getElementsByClassName('img-cat'); //Imagenes de los productos

				for (j=0;j<imagenes.length;j++){
					let articulo = imagenes[j].getAttribute('alt');
					imagenes[j].addEventListener("click", () => {
						window.location = 'detalle_articulo.php?art='+articulo;});
				}

				let catalogo = document.getElementById('catalogo'); //Boton excel

				if (catalogo != null){
					catalogo.addEventListener("click", () => { //Catalogo Excel
						let variable = "";
						for (j=0;j<imagenes.length-1;j++){
							variable += imagenes[j].getAttribute('alt') + ","; //todos los codigos separados por ,
						}
						variable+= imagenes[imagenes.length-1].getAttribute('alt');
						window.location = 'listado_xls.php?imagen='+variable; //se manda por url, se recibe por get en listado_xls
					});
				}

				let cambiar = document.getElementById('cambiar-filtro');
				let form = document.getElementById('datos');

				if (cambiar != null){
					cambiar.addEventListener("click", () => {
						if (form.style.display == 'block'){
							form.style.display = 'none';
						}
						else{
							form.style.display = 'block';
						}
					});
				}
				
				if (cambiar != null){
					form.style.display = 'none';
				}	
			})
		}
		//window.onload= cargarFunciones();
        // window.onload = function() {
        //     let imagenes = document.getElementsByClassName('img-cat'); //Imagenes de los productos
        //     let catalogo = document.getElementById('catalogo'); //Boton excel

        //     for (j=0;j<imagenes.length;j++){
        //         let articulo = imagenes[j].getAttribute('alt');
        //         imagenes[j].addEventListener("click", () => {
        //             window.location = 'detalle_articulo.php?art='+articulo;});
        //    	}

        //     catalogo.addEventListener("click", () => { //Catalogo Excel
        //         let variable = "";
        //         for (j=0;j<imagenes.length-1;j++){
        //             variable += imagenes[j].getAttribute('alt') + ","; //todos los codigos separados por ,
        //         }
        //         variable+= imagenes[imagenes.length-1].getAttribute('alt');
        //         window.location = 'listado_xls.php?imagen='+variable; //se manda por url, se recibe por get en listado_xls
        //     });

        //     let cambiar = document.getElementById('cambiar-filtro');
		// 	let form = document.getElementById('datos');

		// 	if (cambiar != null){
		// 		cambiar.addEventListener("click", () => {
		// 			if (form.style.display == 'block'){
		// 				form.style.display = 'none';
		// 			}
		// 			else{
		// 				form.style.display = 'block';
		// 			}
		// 		});
		// 	}
			
		// 	if (cambiar != null){
		// 		form.style.display = 'none';
		// 	}	
        // }
    </script>
</head>
<body id="body">   
    <header>
		<?php echo $encab;?>
	</header>
	
	<main id="main">
        <aside class="barra-lateral"> 
			<?php 
				$filtro = "";
				$url = $_SERVER["REQUEST_URI"];

					if ($categoria != "" || $subcategoria != "" || isset($filtros[0]) || (isset($filtros[1])) || (($filtros[2] != null))){
						
						$filtro = mostrarFiltros($filtros,$categoria,$subcategoria);
						
						echo "<div id='filtros-usados'>		
								<div id='filtro'> $filtro </div>
								<div class='btn-filtrado'>					
									<a href='$url' class='btn filtrado-bl' name='BorrarFiltros' title='Borrar filtros' value='Borrar filtros'>Borrar filtros</a>
									<button id='cambiar-filtro' class='btn filtrado-bl' name='CambiarFiltros' title='Cambiar filtros'>Modificar filtros</button>
							  	</div>
							  </div>";
					}

				crearBarraLateral();
			?>
		</aside>
        <?php
			crearImagenes ($rs);

			echo "  <div class='btn-doc'>
						<input type='image' src='images/logo_excel.png' class='excel' id='catalogo' title='Exportar a Excel' alt='Exportar a Excel'>
					</div>";
        ?>
    </main>   
   
	<?php echo $pie;?>

</body> 
</html>