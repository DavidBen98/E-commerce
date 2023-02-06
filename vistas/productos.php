<?php
    require_once "../controlador/config.php";
	require "../inc/conn.php";
	include ("encabezado.php");
    include("modalNovedades.php");
    include("pie.php");

	if ($perfil == "E"){ 
		header("location:veABMProducto.php");
	} 

    global $db; 
	$categoria = "";
	$subcategoria = "";
	 
    $filtros = [isset($_POST["color"])? $_POST["color"]:null,
				isset($_POST["marca"])? $_POST["marca"]:null,
				isset($_POST["valorMin"])? $_POST["valorMin"]:null,
				isset($_POST["valorMax"])? $_POST["valorMax"]:null,
				isset($_POST["orden"])? $_POST["orden"]:null]
	;

	$filtrado = "";

	if ($filtros[2] != null && $filtros[3] != null && $filtros[2]>$filtros[3]){
		$maximo = $filtros[2];
		$filtros[2] = $filtros[3];
		$filtros[3] = $maximo;
	}
	
    if(isset($_GET["productos"])){ 
		$select = "SELECT c.nombre_categoria,descripcion, s.nombre_subcategoria, codigo, p.precio, p.id,p.descuento";
		$from = "FROM `producto` as p";
		$innerJoin = "INNER JOIN categoria as c ON p.id_categoria = c.id_categoria
					  INNER JOIN subcategoria as s ON p.id_subcategoria = s.id_subcategoria
		";

        //Si entro desde productos entonces la categoria y la subcategoria la recupero con el formulario
        $categoria = (isset($_POST["categoria"]))? intval($_POST["categoria"]) : "";
        $subcategoria = (isset($_POST["subcategoria"]))? intval($_POST["subcategoria"]) : "";

        if ($categoria != ""){
            $where = " WHERE p.id_categoria like '$categoria' ";
        }
        else{
            $where = " WHERE p.id_categoria like '%' ";
        }

        if ($subcategoria != ""){
            $where .= " AND p.id_subcategoria like '$subcategoria' ";
        }
        else{
            $where .= " AND p.id_subcategoria like '%' ";
        }

        $sql = completarWhere($select,$from,$innerJoin,$where,$filtros);
        $rs = $db->query($sql);
    }
	else if (isset($_GET["buscador"])){
		$busqueda = $_GET["buscador"];

		if (trim($busqueda) != ""){
			$busqueda = str_replace("%20", " ", $busqueda);
			$busqueda = ucfirst($busqueda);
			$palabras = explode (" ",$busqueda);			

			$sql = "SELECT c.nombre_categoria,descripcion, s.nombre_subcategoria, codigo, precio, p.id, p.descuento
					FROM `producto` as p
					INNER JOIN categoria as c ON p.id_categoria = c.id_categoria
					INNER JOIN subcategoria as s ON p.id_subcategoria = s.id_subcategoria
					WHERE nombre_categoria LIKE '%".$busqueda."%' 
					OR nombre_subcategoria LIKE '%".$busqueda."%'
					OR descripcion LIKE '%".$busqueda."%'
			";

			foreach ($palabras as $palabra){
				if (strlen($palabra) > 3){ //Si es una palabra mayor a 3 letras
					$sql .= " OR nombre_categoria LIKE '%".$palabra."%'
							  OR nombre_subcategoria LIKE '%".$palabra."%'
							  OR descripcion LIKE '%".$palabra."%'
					";
				}
			}
			
			$rs = $db->query($sql);
		}
	}	 
    else{
        //Si entro desde subcategorias entonces la categoria y la subcategoria esta en la url
        $categoria = $_GET["cate"];
		$subcategoria = $_GET["sub"];

		$select = "SELECT p.`id`,p.`codigo`, p.`descripcion`, p.`descuento`, p.`precio`,p.`id_categoria`, p.`id_subcategoria`";
		$from = "FROM producto as p";
		$innerJoin = "INNER JOIN subcategoria as s on p.id_subcategoria = s.id_subcategoria
					  INNER JOIN categoria as c on c.id_categoria = p.id_categoria
		";
		$where = "WHERE nombre_subcategoria='$subcategoria' AND s.id_categoria='$categoria'";

        $sql = completarWhere($select, $from, $innerJoin, $where, $filtros);
        $rs = $db->query($sql);
    }

	//FILTROS DE LA BARRA LATERAL
	$url = $_SERVER["REQUEST_URI"];

	if ($categoria != "" || $subcategoria != "" || isset($filtros[0]) || (isset($filtros[1])) || (($filtros[2] != null))){
		$categoria = intval($categoria);
		$filtro = mostrarFiltros($filtros,$categoria,$subcategoria);
		
		$filtrado = "<div id='filtros-usados'>		
						<div id='filtro'> $filtro </div>
						<div class='btn-filtrado'>					
							<a href='$url' class='btn filtrado-bl' name='BorrarFiltros' title='Borrado de filtrado' value='Borrar filtros'>Borrar filtros</a>
							<button id='cambiar-filtro' class='btn filtrado-bl' name='CambiarFiltros' title='Cambiar filtros'>Modificar filtros</button>
						</div>
					</div>
		";
	}

	//RUTA DE NAVEGACIÓN
	if (isset($_GET["cate"])){
		$ruta = "<ol class='ruta'>
					<li><a href='index.php'>Inicio</a></li>
					<li><a href='subcategoria.php?categoria=$categoria'>Subcategorías</a></li>
					<li>Productos</li>
				</ol>
		";
	}
	else{
		$ruta = "<ol class='ruta'>
					<li><a href='index.php'>Inicio</a></li>
					<li>Productos</li>
				</ol>
		";
	}
?>
<!DOCTYPE html>
<html lang="es">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css"  href="../assets/css/estilos.css" rel="stylesheet"/>
    <link rel="icon" type="image/png" href="../images/iconos/logo_sitio.png">
	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
	<script src="../js/funciones.js"></script>
    <title>Muebles Giannis</title>
	<style>
		#main{
			display:flex;
			padding: 5px 0 10px 0;
			justify-content: center;
			flex-wrap:wrap;
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
			margin-left:2%;
		}

		#min-max{
			display:flex;
			flex-wrap:wrap;
			justify-content:center;
			margin-top: 2%;
			border: none;
		}

		.btn-select{
			margin: 4px;
		}

		#lmaxmin{
			display:block;
			width:100%;
			text-align:center;
			padding-top: 20px;
		}

		.marcas, .colores{
			max-height: 150px;
			overflow-x: hidden;
			overflow-y: auto;
			margin-top: 2%;
			border: none;
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

		.img-cat{
			object-fit: contain;
		}
		
		.ltitulo{
		    padding: 0;
		}
		
		.contenedor-productos{
		    display:flex; 
		    width:70%; 
		    margin-left:2%;
		}

		.ruta li:not(:last-child) {
			margin-left:5px;
		}

		.ruta li:last-child {
			border:none;
			text-decoration: none;
		}

		.mensaje{
			display:none;
		}
		
		@media screen and (max-width: 1150px) {
		    .producto{
		        width: 45%;
		    }
		    
		    .contenedor-productos{
		        width: 65%;
                margin-left: 2%;
		    }
		    

		    
		    .barra-lateral{
		        width: 30%;
		    }
		}
		
		@media screen and (max-width: 1024px) {
		    .barra-lateral{
		        width: 90%;
		        /*margin: 0 auto 4% auto;*/
		        position: relative;
		        margin: 0;
		    }
		    
		    .contenedor-productos{
		        width: 91%;
		        margin: 0;
		        margin-top: 2%;
		    }
		    
		    .btn-doc{
		        display:none;
		    }
		    
		    #form-filtrado{
		        width:100%;
		        padding: 0;
		        justify-content: space-between;
		    }
		    
		    .producto{
		        width:30%;
		        margin-right: 0;
		        margin-bottom: 5%;
		    }
		}

		@media screen and (max-width: 860px) {
			.contenedor-productos{
				margin-left:0;
				width: 100%;

			}

			#form-filtrado{
				margin: 0 4% 4%;
				padding-left:0;
				width: 100%;
    			justify-content: space-between;
			}

			.producto{
				width: 49%;
				margin: 0 0 2% 0;
			}

			.btn-doc{
				display:none;
			}
		}
    </style>
    <script> 
		document.addEventListener ("DOMContentLoaded", () => {
			let imagenes = document.getElementsByClassName("img-cat"); //Imagenes de los productos

			let catalogo = document.getElementById("catalogo"); //Boton excel

			if (catalogo != null){
				catalogo.addEventListener("click", () => { //Catalogo Excel
					let variable = "";
					for (j=0;j<imagenes.length-1;j++){
						variable += imagenes[j].getAttribute("alt") + ","; //todos los codigos separados por ,
					}
					variable+= imagenes[imagenes.length-1].getAttribute("alt");
					window.location = "listadoXLS.php?imagen="+variable; //se manda por url, se recibe por get en listadoXLS
				});
			}

			let cambiar = document.getElementById("cambiar-filtro");
			let form = document.getElementById("datos");

			if (cambiar != null){
				cambiar.addEventListener("click", () => {
					if (form.style.display == "block"){
						form.style.display = "none";
					}
					else{
						form.style.display = "block";
					}
				});

				form.style.display = "none";
			}
		});

		$(document).ready(function(){
			actualizarSubcategoria();

			$("#categoria").change (function (){
				actualizarSubcategoria();
			});
		});	
    </script>
</head>
<body id="body">   
    <header>
		<?= $encabezado;?>
        <?= $encabezado_mobile; ?>
	</header>
	
	<main id="main">
		<?= $ruta; ?>

        <aside class="barra-lateral"> 
			<?= $filtrado; ?>

			<?= crearBarraLateral(); ?>
		</aside>

		<section class="contenedor-productos">
			<?= crearImagenes ($rs); ?>
			
			<div class="btn-doc">
				<input type="image" src="../images/iconos/logo_excel.png" class="excel" id="catalogo" title="Exportar a Excel" alt="Exportar a Excel">
			</div>
		</section>

		<?= $modalNovedades; ?>
    </main>   
   
	<footer id="pie">
		<?= $pie; ?> 
	</footer>

</body> 
</html>