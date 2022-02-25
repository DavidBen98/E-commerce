<?php 
    require 'inc/conn.php';

    global $db;
    
    $categoria = (isset($_POST['categoria']) && $_POST['categoria'] != -1)? $_POST['categoria']: null;
  
    $subcategoria = (isset($_POST['subcategoria']) && $_POST['subcategoria'] != -1)? $_POST['subcategoria']: null;
    
    $codigo = (isset($_POST['codigo']) && $_POST['codigo'] != "")? $_POST['codigo']: null;
    
    $descripcion = (isset($_POST['descripcion']) && $_POST['descripcion'] != "")? $_POST['descripcion']: null;
    
    $material = (isset($_POST['material']) && $_POST['material'] != "")? $_POST['material']: null;
    
    $color = (isset($_POST['color']) && $_POST['color'] != "")? $_POST['color']: null;
    
    $caracteristicas = (isset($_POST['caracteristicas']) && $_POST['caracteristicas'] != "")? $_POST['caracteristicas']: null;
    
    $marca = (isset($_POST['marca']) && $_POST['marca'] != "")? $_POST['marca']: null;
    
    $cant = (isset($_POST['cant']) && $_POST['cant'] != "" && $_POST['cant'] >= 0)? $_POST['cant']: null;
    
    $precio = (isset($_POST['precio']) && $_POST['precio'] != "" && $_POST['precio'] > 0)? $_POST['precio']: null;
    
    $descuento = (isset($_POST['descuento']) && $_POST['descuento'] != "" && $_POST['descuento'] >= 0)? 
                    $_POST['descuento']: null;
    
    $imagen = null;
    $portada = $_POST['portada'];

    $check = getimagesize($_FILES["imagen"]["tmp_name"]);
    if($check !== false){
        $imagen = addslashes(file_get_contents($_FILES["imagen"]["tmp_name"]));
    }

    if ($categoria != null && $subcategoria != null && $codigo != null && $descripcion != null && $material != null &&
    $color != null && $caracteristicas != null && $marca != null && $cant != null && $precio != null && $descuento != null &&
    $imagen != null){

        $sql = "INSERT INTO producto (`codigo`, `descripcion`, `material`, `color`,`caracteristicas`,
                            `marca`, `stock`, `precio`, `id_categoria`, `id_subcategoria`, `descuento`) 
                VALUES ('$codigo', '$descripcion', '$material', '$color','$caracteristicas','$marca','$cant',
                        '$precio', '$categoria', '$subcategoria', '$descuento')
        ";

        $rs = $db -> execute ($sql);

        $idProducto = lastInsertId();

        $sql = "INSERT INTO imagen (id_producto, imagen, portada) VALUES
                '$idProducto', '$imagen', '$portada'
        ";

        $rs = $db -> execute ($sql);
    }
    else{
        header ("location: ve_prod_alta.php?error=data");
    }





    $sql = "SELECT id
            FROM producto
            WHERE id_categoria = '$categoria' AND id_subcategoria= '$subcategoria'
    ";

    $rs = $db -> query($sql);

    $i = 0;
    foreach ($rs as $row){
        $i++;
    }

    $i = $i + 1; //posicion del nuevo producto

    echo $i;
?>