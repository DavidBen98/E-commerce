<?php  
	include('config.php');
	include ("encabezado.php");
	include ("barra_lateral.php"); 
	include ("pie.php");
	include ("inc/conn.php"); 
	
	if ($perfil == "E"){ 
		header("location:ve.php");
	}	 

	global $db;  
	$rs = "";
	 
	$sql = "SELECT `codigo`, `descripcion`, `precio`,`id_categoria`
			FROM producto";

	if (isset($_GET['cat'])){
		$imagenes = $_GET['cat'];
		$imagenes = substr($imagenes,0,2);

		$sql .= " where `codigo` LIKE '$imagenes%1'";
		
		$rs = $db->query($sql);
	}
	else if (isset($_GET['prod'])){
		$categoria = $_GET['prod'];
		$sql = "SELECT `codigo`, `descripcion`, `precio`,`id_categoria`
			    FROM producto
				WHERE codigo like '$categoria%'";

		$filtros = [isset($_POST['color'])? $_POST['color']:null,
                    isset($_POST['marca'])? $_POST['marca']:null,
                    isset($_POST['valorMin'])? $_POST['valorMin']:null,
                    isset($_POST['valorMax'])? $_POST['valorMax']:null,
                    isset($_POST['orden'])? $_POST['orden']:null];

		$sql = completarWhere($sql, $filtros);

		$rs = $db->query($sql);
	}	
?>
<!DOCTYPE html>
<html lang="es"> 
<head> 
    <meta charset="UTF-8">
    <title>Catato Hogar</title>
    <link type="text/css"  href="css/estilos.css" rel="stylesheet"/>
	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
	<script src="js/funciones.js"></script>
	<style>
		#main{
			display:flex;
			padding: 20px 0 10px 0;
			justify-content:center;
		}

		.barra-lateral {
			visibility:hidden;
			flex-flow: column wrap;
			align-content: flex-start;
			width:25%;
			color: #000;
			padding:0 4px;
			order: 0;
		}

		/*ASIDE*/
		aside{
			margin-bottom:10px;
		}

		.input label{
			width:130px;
			height:50%;
		}

		#min-max{
			width:300px;
			padding-left:4px;
		}

		#lmaxmin{
			padding-left:2px;
		}

		.ltitulo{
			padding-left:8px;
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

		.img-cat{
			object-fit: contain;
		}

	</style>
	<script>      
        window.onload = function() {
            let imagenes = document.getElementsByClassName('img-cat'); //Imagenes de los productos
            let barra = document.getElementsByClassName('barra-lateral'); //Barra lateral
            let catalogo = document.getElementById('catalogo'); //Boton excel
            let btn = document.getElementById('btn-imp'); //Boton imprimir
 
            for (j=0;j<imagenes.length;j++){
                let imagen = imagenes[j].getAttribute('alt');
                imagen = imagen.substring(0, imagen.length - 1);
                imagenes[j].addEventListener("click", () => {
                    window.location = 'subcategoria.php?prod='+imagen;});
            };
  
            if (window.location.search.indexOf('?prod=') != -1){
                barra[0].style.visibility = 'visible'; //Mostrar barra lateral
 
                for (j=0;j<imagenes.length;j++){ //Al hacer click en un producto, enviar a detalle
                    let articulo = imagenes[j].getAttribute('alt');
                    imagenes[j].addEventListener("click", () => {window.location = 'detalle_articulo.php?art='+articulo;});
                };
 
                catalogo.addEventListener("click", () => { //Imprimir catalogo
                    let variable = "";
                    for (j=0;j<imagenes.length-1;j++){
                        variable += imagenes[j].getAttribute('alt') + ","; //todos los codigos separados por ,
                    }
                    variable+= imagenes[imagenes.length-1].getAttribute('alt');
                    window.location = 'listado_xls.php?imagen='+variable; //se manda por url, se recibe por get en listado_xls
                });
 
            }
            else if(window.location.search.indexOf('?cat=') != -1){
                let formulario = document.getElementById('form-filtrado');
				let imgProducto = document.getElementsByClassName('producto');
 
                barra[0].style.display = 'none';
 
                formulario.style.width = '100%';
                formulario.style.justifyContent = 'center';
                formulario.style.padding = '0';

				for (let i=0; i<imgProducto.length; i++){
					imgProducto[i].style.height = '300px';
				}
            }  

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
			
        }            
    </script>
</head>
<body id="body"> 
	<header>
		<?php echo $encab; ?> 
	</header>

	<main id="main">
		<aside class="barra-lateral"> 
			<?php 
				$filtro = "";
				$url = $_SERVER["REQUEST_URI"];

				echo "<div id='filtros-usados'>";
					if (isset($filtros[0])){
						if (count($filtros[0]) == 1){
							$filtro = "<b>Color:</b> ";
						}
						else{
							$filtro = "<b>Colores: </b>";
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
						$filtro .= '<b>Mínimo: </b>' . $filtros[2] . '. <br> <b>Máximo: </b>' . $filtros[3] . ".";
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
			crearImagenes($rs); 

			if (isset($_GET['prod'])){
				echo "  <div class='btn-doc'>
							<input type='image' src='images/logo_excel.jpeg' class='excel' id='catalogo' alt='Exportar a excel'>
							<a href='javascript:window.print();' id='btn-imp' title='Imprimir listado.'>
								<img src='images/logo_imprimir.jpeg' id='imprimir' title='Imprimir listado.' alt='icono imprimir.' style='border:0;width:32px;height:32px;'>
							</a>
						</div>";	
			} 					
		?>
		
	</main>
		
	<?php 
		echo $pie;
	?>
	
</body>
</html>