<?php 
    require 'inc/conn.php';

    global $db;
    
    $categoria = (isset($_POST['categoria']) && $_POST['categoria'] !== -1)? $_POST['categoria']: null;
  
    $subcategoria = (isset($_POST['subcategoria']) && $_POST['subcategoria'] !== -1)? $_POST['subcategoria']: null;
    
    $codigo = (isset($_POST['codigo']) && $_POST['codigo'] !== "")? $_POST['codigo']: null;
    
    $descripcion = (isset($_POST['descripcion']) && $_POST['descripcion'] !== "")? ucfirst($_POST['descripcion']): null;
    
    $material = (isset($_POST['material']) && $_POST['material'] !== "")? ucfirst($_POST['material']): null;
    
    $color = (isset($_POST['color']))? ucfirst($_POST['color']): null;
    
    $caracteristicas = (isset($_POST['caracteristicas']))? $_POST['caracteristicas']: null;
    
    $marca = (isset($_POST['marca']) && $_POST['marca'] !== "")? $_POST['marca']: null;
    
    $cant = (isset($_POST['cant']) && $_POST['cant'] !== "" && $_POST['cant'] >= 0)? $_POST['cant']: null;
    
    $precio = (isset($_POST['precio']) && $_POST['precio'] > 0)? $_POST['precio']: null;
    
    $descuento = (isset($_POST['descuento']) && $_POST['descuento'] != "" && $_POST['descuento'] >= 0)? 
                    $_POST['descuento']: null;
    
    $imagen = $_FILES["imagen"]["tmp_name"];
    $portada = isset($_POST['portada'])? 1: 0;

    $check = ($_FILES["imagen"]["tmp_name"] != '')? getimagesize($_FILES["imagen"]["tmp_name"]) : false;
    if($check !== false){
        $imagen = addslashes(file_get_contents($imagen));
    }

    if ($categoria !== null && $subcategoria !== null && $codigo !== null && $descripcion !== null && $material !== null &&
    $color !== null && $caracteristicas !== null && $marca !== null && $cant !== null && $precio !== null && $descuento !== null &&
    $check !== false){
        if (strpos($codigo,"ofsi") !== false){
            $caract = "Altura del respaldo: ".$caracteristicas[0]."cm,altura del piso al asiento: ". $caracteristicas[1]."cm";
        }
        else if (strpos($codigo,"doco") !== false){
            $caract = "Largo: ".$caracteristicas[0]. "cm,ancho: ". $caracteristicas[1] ."cm,alto: ". $caracteristicas[2] ."cm";
        }
        else if (strpos($codigo,"doca")!== false){
            $caract = "Plazas: ".$caracteristicas[0]. "cm,largo: ". $caracteristicas[1] ."cm,ancho: ". $caracteristicas[2] ."cm";
        }
        else if (strpos($codigo,"come")=== false && strpos($codigo,"cosi")=== false && strpos($codigo,"ofsi")=== false){
            $caract = "Alto: ".$caracteristicas[0]. "cm,ancho: ".$caracteristicas[1] ."cm,profundidad: ". $caracteristicas[2] ."cm";
        }
        else{
            $caract = "Alto: ".strval($caracteristicas[0]). "cm,ancho: ".strval($caracteristicas[1]) ."cm";
        }

        $sql = "INSERT INTO producto (`codigo`, `descripcion`, `material`, `color`,`caracteristicas`,
                            `marca`, `stock`, `precio`, `id_categoria`, `id_subcategoria`, `descuento`) 
                VALUES ('$codigo', '$descripcion', '$material', '$color','$caract','$marca','$cant',
                        '$precio', '$categoria', '$subcategoria', '$descuento')
        ";

        echo $sql;

        $rs = $db->query($sql);

        $idProducto = $db->lastInsertId();

        $sql = "INSERT INTO imagen (id_producto, imagen, portada) VALUES
       ('$idProducto', '$imagen', '$portada')
        ";
        
        $rs = $db -> query($sql);

        header ("location: ve_prod_alta.php?insert=true");
    }
    else{
        header ("location: ve_prod_alta.php?error=data");
    }
?>