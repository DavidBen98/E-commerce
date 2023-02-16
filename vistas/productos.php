<?php
	//Link redundante, se deja por funcionamiento del sitio
    require_once "../controlador/config.php";
	require "../inc/conn.php";
	include "encabezado.php";
    include "modalNovedades.php";
    include "pie.php";

	if ($perfil == "E"){ 
		header("location:veABMProducto.php");
		exit;
	} 

	$categoria = "";
	$subcategoria = "";
	 
    $filtros = [isset($_POST["color"])? $_POST["color"]:null,
				isset($_POST["marca"])? $_POST["marca"]:null,
				isset($_POST["valorMin"])? $_POST["valorMin"]:null,
				isset($_POST["valorMax"])? $_POST["valorMax"]:null,
				isset($_POST["orden"])? $_POST["orden"]:null
	];

	$filtrado = "";

	if ($filtros[2] != null && $filtros[3] != null && $filtros[2]>$filtros[3]){
		$maximo = $filtros[2];
		$filtros[2] = $filtros[3];
		$filtros[3] = $maximo;
	}
	
    if(isset($_GET["productos"])){ 
		//Si entro desde productos entonces la categoria y la subcategoria la recupero con el formulario
        $categoria = (isset($_POST["categoria"]))? intval($_POST["categoria"]) : "";
        $subcategoria = (isset($_POST["subcategoria"]))? intval($_POST["subcategoria"]) : "";
		
		$sql = generar_consulta("productos","",$filtros[4]);

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

        $rs = filtrar_productos($sql,$where,$filtros);
    }
	else if (isset($_GET["buscador"])){
		$busqueda = $_GET["buscador"];
		$rs = generar_consulta("buscador", $busqueda);
	}	 
    else if(isset($_GET["cate"])  && isset($_GET["sub"])){
        //Si entro desde subcategorias entonces la categoria y la subcategoria esta en la url
        $categoria = $_GET["cate"];
		$subcategoria = $_GET["sub"];
		$sql = generar_consulta("subcategoria", "", $filtros[4]);
		$where = " WHERE nombre_subcategoria='$subcategoria' AND s.id_categoria='$categoria' ";

        $rs = filtrar_productos($sql, $where, $filtros);
    } else {
		$sql = generar_consulta("");
		$where = "WHERE id_subcategoria LIKE '%' AND id_categoria LIKE '%' ";
		$rs = filtrar_productos($sql, $where, $filtros);
	}

	//FILTROS DE LA BARRA LATERAL
	$url = $_SERVER["REQUEST_URI"];

	if ($categoria != "" || $subcategoria != "" || isset($filtros[0]) || (isset($filtros[1])) || (($filtros[2] != null))){
		$categoria = intval($categoria);
		$filtro = mostrar_filtros($filtros,$categoria,$subcategoria);
		
		$filtrado = "
			<div id='filtros-usados'>		
				<div id='filtro'> $filtro </div>
				<div class='btn-filtrado'>					
					<a href='$url' class='btn filtrado-bl' title='Borrado de filtrado'>Borrar filtros</a>
					<button id='cambiar-filtro' class='btn filtrado-bl' name='cambiar-filtros' title='Cambiar filtros'>Modificar filtros</button>
				</div>
			</div>
		";
	}

	//RUTA DE NAVEGACIÓN
	if (isset($_GET["cate"])){
		$ruta = "
			<ol class='ruta'>
				<li><a href='index.php'>Inicio</a></li>
				<li><a href='subcategoria.php?categoria=$categoria'>Subcategorías</a></li>
				<li>Productos</li>
			</ol>
		";
	}
	else{
		$ruta = "
			<ol class='ruta'>
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
    <link type="text/css"  href="../assets/css/estilos.css" rel="stylesheet">
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

		.contenedor-marcas, .contenedor-colores{
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

		.titulo-catalogo{
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
		<?= imprimir_encabezado($encabezado, $encabezado_mobile); ?>
	</header>
	
	<main id="main">
		<?= $ruta; ?>

        <aside class="barra-lateral"> 
			<?= $filtrado; ?>

			<?= crear_barra_lateral(); ?>
		</aside>

		<section class="contenedor-productos">
			<?= crear_imagenes ($rs); ?>
			
			<div class="btn-doc">
				<input type="image" src="../images/iconos/logo_excel.png" class="excel" id="catalogo" title="Exportar a Excel" alt="Exportar a Excel">
			</div>
		</section>

		<?= $modal_novedades; ?> 
		<?= $modal_novedades_error; ?>
    </main>   
   
	<footer id="pie">
		<?= $pie; ?> 
	</footer>

</body> 
</html>