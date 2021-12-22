<?php 
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
	$colores = (isset($_POST['color']))? $_POST['color']:-1;
	$marcas = (isset($_POST['marca']))? $_POST['marca']:-1;
	$precioMin = (isset($_POST['valorMin']))? $_POST['valorMin']:0;
	$precioMax = (isset($_POST['valorMax']))? $_POST['valorMax']:0;
	$orden = (isset($_POST['orden']))? $_POST['orden']:-1;

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
		$sql = "SELECT `codigo`, `descripcion`,`precio`, SUM(`cantidad`)
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

	function crearImagenes ($consulta){
		if (!$consulta){
			echo "<p>Lo sentimos, ha ocurrido un error inesperado </p>";
		}
		else{
			echo "<form action='listado_xls.php' method='post' id='form-filtrado' class='form-prod' name='form-filtrado'>	";
				$i=0;
				foreach ($consulta as $row) {
					$i++; 
					echo "<div class='producto'>
							<img src='images/{$row['codigo']}.png' class='img-cat' alt='{$row['codigo']}' title='". ucfirst($row['descripcion'])."'> 
							<div class='caracteristicas'>
								<p class='descripcion'>". ucfirst($row['descripcion'])." </p>
								<p class='precio' style='text-align:center;'>". ucfirst($row['precio'])." </p>
							</div>
						</div>";           
				};

			if ($i == 0){
				echo "<p>No existe ningun resultado que coincida con la busqueda ingresada </p>";
			}
						
			echo " </div>
				</form>
			";	
		}
	} 
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
			padding-top: 20px;
			justify-content:start;
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

		.producto{
			height:360px;
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
			height:10%;
			justify-content:center;
			text-align:center;
		} 

		/*ASIDE*/
		.barra-lateral {
			width:30%;
			align-content: flex-start;
			padding-left:4px;
			padding-right:4px;
			order: 0;
		}

		.btn-select{
			display:flex;
			flex-wrap: wrap;
			justify-content:center;
			margin: 4px;
		}

		#min-max{
			width:100%;
			display:flex;
			flex-wrap:wrap;
			justify-content:center;
			padding-left:4px;
		}

		.input-minmax{
			display:flex;
			width:100%;
			justify-content:center;
		}
		.min-max{
			width: 60px;
		}

		#lmaxmin{
			display:block;
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

		.ltitulo{
			display:block;
			text-align:center;
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
			order: 1;
			margin: 0;
    		justify-content: flex-start;
    		flex-flow: row wrap;
    		align-items: flex-start;
    		padding-left: 30px;
			width:60%;
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
    </style>
</head>
<body>   
    <header>
		<?php echo $encab;?>
	</header>

    <main id="main">
		<aside class="barra-lateral"> 
			<?php 
				crearBarraLateral();
			?>
		</aside>
		
        <?php
			crearImagenes ($rs);
        ?>
    </main>   
   
	<?php echo $pie;?>
</body> 
</html>