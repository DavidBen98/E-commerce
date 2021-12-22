<?php  
	include ("encabezado.php");
	include ("barra_lateral.php"); 
	include ("pie.php");
	include ("inc/conn.php"); 
	
	if ($perfil == "E"){ 
		header("location:ve.php");
	}	 

	global $db;  
	$rs = "";
	 
	$sql = "SELECT `codigo`, `descripcion`
			from producto";

	if (isset($_GET['cat'])){
		$imagenes = $_GET['cat'];
		$imagenes = substr($imagenes,0,2);

		$sql .= " where `codigo` LIKE '$imagenes%%1'";

		$rs = $db->query($sql);
	}
	else if (isset($_GET['prod'])){
        $where_sql = "";

		$categoria = $_GET['prod'];
		$colores = (isset($_POST['color']))? $_POST['color']:-1;
        $marcas = (isset($_POST['marca']))? $_POST['marca']:-1;
        $precioMin = (isset($_POST['valorMin']))? $_POST['valorMin']:0;
        $precioMax = (isset($_POST['valorMax']))? $_POST['valorMax']:0;
        $orden = (isset($_POST['orden']))? $_POST['orden']:-1;
		$where_sql = " WHERE codigo like '$categoria%' ";
				
        $where_color = "";
        if ($colores != -1){
            if (count($colores) == 1){
                $where_color = " AND color = '$colores[0]' ";
            }
            else{
				$where_color .= " AND ( ";
                for ($i=0;$i<count($colores)-1;$i++){ 
                    $where_color .= " color = '$colores[$i]' OR " ;
                }
                $i = count($colores)-1;
                $where_color .= " color = '$colores[$i]') ";
            }
        }

        $where_marca = "";
        if ($marcas != -1){
            if (count($marcas) == 1){
                $where_marca .= " AND marca = '$marcas[0]' ";
            }
            else{
				$where_marca .= " AND ( ";
                for ($i=0;$i<count($marcas)-1;$i++){
                    $where_marca .= "  marca = '$marcas[$i]' OR ";
                }
                $i = count($marcas)-1;
                $where_marca .= " marca = '$marcas[$i]') ";
            }
        }

		$where_precio=""; 

		if ($precioMin!= 0 && $precioMax !=0){
			$where_precio = " precio >= $precioMin AND precio <= $precioMax ";
		}

        $orderBy = "";
		$orderMasVen = 0;
        if($orden != -1){
            if ($orden == 0){
                $orderBy = " ORDER BY precio asc ";
            }
            else if ($orden == 1) {
                $orderBy = " ORDER BY precio desc ";
            }
            else {              
				$orderMasVen++;
            }
        }
		
        if($where_color != "" && $where_marca != ""){
            $where_sql .=  $where_color . $where_marca ;
        }
        else if ($where_color != ""){
            $where_sql .=  $where_color ;
        }
        else{
            $where_sql .=  $where_marca ;
        } 
        
		
		if($orderMasVen != 0){
			$sql = "SELECT `codigo`, `descripcion`, SUM(`cantidad`)
					from `producto` 
					LEFT JOIN `pedido` ON `pedido`.producto_codigo = `producto`.codigo
					$where_sql
					GROUP  BY `codigo`
					ORDER  BY `cantidad` DESC;";
		}
		else{
			$sql .= " $where_sql
                 		$orderBy";  
		}
        
        $rs = $db->query($sql);
	}

	function crearImagenes ($consulta){
		if (!$consulta){
			echo "<p>Lo sentimos, ha ocurrido un error inesperado </p>";
		}
		else{
			echo "<form action='listado_xls.php' method='post' id='form-filtrado' class='form-prod' name='form-filtrado'>";

			$i=0;
			foreach ($consulta as $row) {
				$i++; 
				echo "<div class='producto'>
						<img src='images/{$row['codigo']}.png' class='img-cat' alt='{$row['codigo']}' title='". ucfirst($row['descripcion'])."'> 
						<p class='descripcion'>". ucfirst($row['descripcion'])." </p>
					</div>";           
			};

			if ($i == 0){
				echo "<p>No existe ningun resultado que coincida con la busqueda ingresada </p>";
			}
						
			echo "	</div>
				</form>
			";
			
		}
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
		#body{
            font-family: "Salesforce Sans", serif;
            font-size: 1.2rem;
            line-height: 1.5em;
            margin: 0px;
        }

		#main{
			display:flex;
			padding-top: 20px;
			justify-content:center;
		}

		.img-cat {
			width:230px;
			height:230px;
			object-fit: contain;
			border-bottom: 0.1px solid rgba(205,205,205,0.7);
		}

		.contenedor-imagenes{
			width:800px;
			margin:0;
			display:flex;
			justify-content: start;
			flex-flow: wrap;
		}

		.barra-lateral {
			visibility:hidden;
			flex-flow: column wrap;
			align-content: flex-start;
			width:25%;
			color: #000;
			padding-left:4px;
			padding-right:4px;
			order: 0;
		}

		.producto{
			height:320px;
			margin-right:10px;
			margin-bottom:10px;
			background-color:white;
			cursor: pointer;
			border-radius:5px;
			overflow:hidden;
		}

		.producto img{
			width:230px;
			height:230px;
		}

		.descripcion{
			display:flex;
			width:230px;
			justify-content:center;
			text-align:center;
		} 

		/*ASIDE*/
		.btn-select{
			display:flex;
			flex-wrap: wrap;
			justify-content:center;
		}

		.input label{
			width:130px;
			height:50%;
		}

		#min-max{
			width:300px;
			padding-left:4px;
		}

		.min-max{
			width: 60px;
		}

		aside select{
			width: 90%;
			height: 30px;
			background-color: #D3D3D3;
			border: 2px solid black;
			border-radius:5px;
			color: black;
			font-size: 1.2rem;
			text-align:center;
			margin:0 auto;
	    }

		#lmaxmin{
			padding-left:2px;
		}

		.ltitulo{
			padding-left:8px;
		}

		#botones{
			display:flex;
			flex-wrap: wrap;
			justify-content:center;
		}

		.btn{
		   background-color: #D3D3D3;
		   height: 40px;
		   width:200px;
		   cursor:pointer;
		   font-size:1.2rem;
		   border-radius: 5px;
		}

		.btn:hover{
			background-color: rgb(112, 112, 112);
            transition: all 0.3s linear;
            color: white;
            cursor:pointer;
		}

		#h1{
			margin:20px auto;
		}

		#parrafo-sr{
			width:700px;
			padding-left: 100px;
		}

		.btn-doc{
			order:2;
			width:80px;
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

		#form-filtrado{
			display:flex;
			flex-wrap:wrap;
			order: 1;
			margin: 0;
    		justify-content: flex-start;
    		flex-flow: row wrap;
    		align-items: flex-start;
    		padding-left: 30px;
			width: 60%;
		}

		#catalogo{
			height:30px;
		}

		#btn-imp{
			height:30px;
		} 

		.label{
			font-weight: bolder;
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
                let contenedor = document.getElementsByClassName('contenedor-imagenes');
 
                barra[0].style.display = 'none';
 
                formulario.style.width = '100%';
                formulario.style.justifyContent = 'center';
                formulario.style.padding = '0';
 
                contenedor[0].style.justifyContent = 'center';
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