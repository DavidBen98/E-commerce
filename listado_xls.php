<!DOCTYPE html> 
<html lang="es">
<?php 

header("Pragma: no-cache");
header("Expires: 0");

header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=catalogo.xls");
header("Content-type: application/vnd.ms-excel");  

require 'inc/conn.php';  

$img = (isset($_GET['imagen']))? $_GET['imagen']:0;
$imagenes = explode(',',$img);

global $db;
$tabla = "";

if ($imagenes != 0){
	$tabla = "<table>
				<caption>Catalogo de productos</caption>
				<tr>
					<th>Código</th>
					<th>Descripción</th>
					<th>Material</th>
					<th>Color</th>
					<th>Marca</th>				
					<th>Caracteristicas</th>
					<th>Precio</th>
				</tr>";

	$where_sql = " WHERE ";

	//trae el codigo de las imagenes que muestra actualmente
	if (count($imagenes) == 1){ 
		$where_sql .= " codigo = '$imagenes[0]' ";
	}
	else{
		for ($i=0;$i<count($imagenes)-1;$i++){
			$where_sql .= " codigo = '$imagenes[$i]' OR  ";
		}
		$i = count($imagenes)-1;
        $where_sql .= " codigo = '$imagenes[$i]' ";
	}


	$sql = "SELECT codigo, descripcion, material, color, marca, caracteristicas, precio
			FROM producto
			$where_sql";
	
	$rs = $db->query($sql);
	if (!$rs){
		echo "<p>Lo sentimos, ha ocurrido un error inesperado</p>";
		exit;
	}
	else{
		foreach ($rs as $reg){
			$tabla.= "<tr>
						<td>{$reg['codigo']}</td>
						<td>{$reg['descripcion']}</td>
						<td>{$reg['material']}</td>
						<td>{$reg['color']}</td>
						<td>{$reg['marca']}</td>
						<td>{$reg['caracteristicas']}</td>
						<td>{$reg['precio']}</td>
					 </tr>";
		}
		$rs = null;
		$db = null;
	} 
}
?>
<head>
	<meta charset="utf-8">
	<title>Catato Hogar</title>
</head>
<body>
	<?php 
		echo $tabla;
	?>
</body>
</html>