<?php require 'inc/conn.php'; ?>

<script src="JS/jquery-3.3.1.min.js"></script>
<script>
	$(document).ready(function(){
		recargarLista();

		$('#categoria').change (function (){
			recargarLista();
		});
	});

	function recargarLista (){
		$.ajax ({
			type: "POST",
			url: "rellenar_select.php",
			data: "categoria= " + $('#categoria').val (),
			success: function (r){
				$('#subc').html (r);
			}
		});
	}
</script>

<?php  	
	function crearBarraLateral(){
		global $db;

		$producto = "";

		if (isset($_GET['articulos'])){ //Si se ingresa desde imagenes
			$producto = $_GET['articulos'];
			$categoria = $_GET['cate'];
			$subcategoria = $_GET['sub']; 
			$form = "<form action='productos.php?articulos=".$producto."&cate=".$categoria."&sub=".$subcategoria."' method='post' id='datos'> 
						<div class='btn-select'>
							<label for='orden' class='label'> Ordenar por </label>
							<select class='form-select' name='orden' title='Ordenar elementos'> 
								<option value='0'> Menor precio </option>
								<option value='1'> Mayor precio </option>	
								<option value='2'> Mas vendidos </option>
							</select>
						</div>";
		}
		else if (isset($_GET['productos']) || isset($_GET['buscador'])){ //Si se ingresa desde el nav ->productos o desde la barra de navegacion
			$arrCategorias = [];
			$arrSubcategorias = [];

			$sql  = "SELECT c.id_categoria,c.nombre_categoria,descripcion, material,color,caracteristicas,marca,stock, precio, s.nombre_subcategoria
			FROM `producto`
			INNER JOIN categoria as c ON producto.id_categoria = c.id_categoria
			INNER JOIN subcategoria as s ON producto.id_subcategoria = s.id_subcategoria";
			
			$rs = $db->query($sql);

			foreach ($rs as $row) {
				if(empty($arrCategorias[$row['nombre_categoria']])){
					$arrCategorias[$row['nombre_categoria']] = $row['id_categoria'];						
				}													
			}

			ksort($arrCategorias);
			$form = " 
				<form action='productos.php?productos=filtrado' method='post' id='datos'> 
					<div class='btn-select'>
						<label for='orden' class='label'> Ordenar por </label>
						<select class='form-select' name='orden' title='Ordenar elementos'> 
							<option value='0'> Menor precio </option>
							<option value='1'> Mayor precio </option>	
							<option value='2'> Mas vendidos </option>
						</select>
					</div>
					<div class='btn-select'>
						<label for='categoria' class='label'> Categorías </label>
						<select class='form-select' id='categoria' name='categoria' title='Categorias'>";

			foreach($arrCategorias as $indice => $valor){
				$form .=" <option value='$valor'> $indice </option>";
			}

			$form .= "</select>
					</div>
					<div id='subc' class='btn-select'>
				</div>";
		}

		echo $form;

		$arrColores = [];
		$arrMarcas = [];
		$variable = substr($producto,0,4);
		
		$where_sql = " WHERE codigo like '$variable%'";
		
		$sql  = "SELECT id_categoria,descripcion, material,color,caracteristicas,marca,stock, precio, id_subcategoria
					FROM `producto`
				$where_sql";

		$rs = $db->query($sql); 

		foreach ($rs as $row) {
			if(empty($arrColores[$row['color']])){
				$arrColores[$row['color']] = 0;						
			}										
			if(empty($arrMarcas[$row['marca']])){
				$arrMarcas[$row['marca']] = 0;
			}					
		}
		
		$sql1 = "SELECT min(precio) 
						FROM `producto`
						$where_sql
						; ";
		$rs1 = $db->query($sql1);
		
		foreach ($rs1 as $row) {
			$valorMin = implode($row);
		}

		$sql2 = "SELECT max(precio) 
						FROM `producto`
						$where_sql
						; ";
		$rs2 = $db->query($sql2);
		
		foreach ($rs2 as $row) {
			$valorMax = implode($row);
		}
		
		ksort($arrColores);
		
			echo" <div class='colores contenedor'>
						<label class='ltitulo'><b>Colores</b></label>
						<div id='colores' class='input'>
		";
		
		foreach($arrColores as $indice => $valor){
			$id = str_replace(" ","",$indice);
			echo" 
				<div class='color'>	
					<input type='checkbox' class='input' name='color[]' id='$id' title='Color $indice' value='$indice'>													  																															
					<label for='$id' > ".ucfirst($indice)."</label>			
				</div>			
			";
		}

		ksort($arrMarcas);

		echo"</div> </div> 
			<div class='marcas contenedor'>					
				<label class='ltitulo'><b>Marcas</b></label>
				<div id='marcas' class='input'>
		";	

		foreach($arrMarcas as $indice => $valor){
			$id = str_replace(" ","",$indice);
			echo "				
					<div class='marca'>		
						<input type='checkbox' class='input' name='marca[]' id='$id' title='Marca $indice' value='$indice'>													  																															
						<label for='$id'> ".ucfirst($indice)."</label>	
					</div>				
				";
		}
		echo "</div>	
				</div>
				<div id='min-max'>
					<label id='lmaxmin'><b>Mínimo - Máximo</b></label>	
					<div class='input-minmax'>	
						<input type='number' name='valorMin' id='valorMin' style='text-align:center; height: 20px;' title='Mínimo'  class='min-max' placeholder='$valorMin' min='$valorMin' max='$valorMax' value='' >
						- 
						<input type='number' name='valorMax' id='valorMax' style='text-align:center; height: 20px;' title='Máximo' class='min-max' placeholder='$valorMax' min='$valorMin' max='$valorMax' value='' > 							
					</div>
				</div>	
				<p id='e_error'>

				</p> 
				<div id='botones' class='botones'>
					<input type='submit'  id='filtros' class='btn' name='Aplicar filtros' title='Aplicar filtros' value='Aplicar filtros'>						
				</div>
			</form>";
	}								
?>