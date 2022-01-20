<!DOCTYPE html>
<?php
    include("pie.php");
	require 'inc/conn.php';
    include('config.php');
	include ("encabezado.php");
	include ("barra_lateral.php"); 

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

    if(isset($_GET['cat'])){   
        $sql  = "SELECT c.nombre_categoria,descripcion, s.nombre_subcategoria, codigo, precio
                FROM `producto` as p
                INNER JOIN categoria as c ON p.id_categoria = c.id_categoria
                INNER JOIN subcategoria as s ON p.id_subcategoria = s.id_subcategoria";

        $where_sql = "";

        //Si entro desde productos entonces la categoria y la subcategoria la recupero con el formulario
        $categoria = (isset($_POST['categoria']))? $_POST['categoria'] : "";
        $subcategoria = (isset($_POST['subcategoria']))? $_POST['subcategoria'] : "";

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
    else{
        $sql = "SELECT `codigo`, `descripcion`, `precio`,`id_categoria`
			FROM producto";

        //Si entro desde subcategorias entonces la categoria y la subcategoria esta en la url
        $catSubcat = $_GET['prod'];
        $sql = "SELECT `codigo`, `descripcion`, `precio`,`id_categoria`, `id_subcategoria`
                FROM producto
                WHERE codigo like '$catSubcat%'";

        $sql = completarWhere($sql, $filtros);
        $rs = $db->query($sql);
    }
?>
<html lang="es"> 
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css"  href="css/estilos.css" rel="stylesheet"/>
	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
	<script src="js/funciones.js"></script>
    <title>Catato Hogar</title>
	<style>
		#main{
			display:flex;
			padding: 20px 0 10px 0;
			justify-content: center;
		}

		/*ASIDE*/
		aside{
			margin-bottom:10px;
		}


		.barra-lateral {
			width:25%;
			align-content: flex-start;
			padding-left:4px;
			padding-right:4px;
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
		}

		.img-cat{
			object-fit: contain;
		}
    </style>
    <script>      
        window.onload = function() {
            let imagenes = document.getElementsByClassName('img-cat'); //Imagenes de los productos
            let catalogo = document.getElementById('catalogo'); //Boton excel
            let btn = document.getElementById('btn-imp'); //Boton imprimir

            for (j=0;j<imagenes.length;j++){
                let articulo = imagenes[j].getAttribute('alt');
                imagenes[j].addEventListener("click", () => {
                    window.location = 'detalle_articulo.php?art='+articulo;});
           	}

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

				echo "<div id='filtros-usados'>";
					if ($categoria != ""){
						$sql  = "SELECT c.nombre_categoria
								FROM `categoria` as c
								WHERE c.id_categoria = '$categoria'";

						$resultado = $db->query($sql);
						
						foreach($resultado as $row){
							$cat = $row['nombre_categoria'];
						}
						$filtro = "<b>Categoría:</b> ". $cat . ".<br>";
					}

					if ($subcategoria != ""){
						$sql  = "SELECT s.nombre_subcategoria
								FROM `subcategoria` as s
								WHERE s.id_subcategoria = '$subcategoria'";
						
						$resultado = $db->query($sql);

						foreach($resultado as $row){
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