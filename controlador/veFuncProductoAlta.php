<?php 
    require "../inc/conn.php";
    include_once "funciones.php";

    global $db;
    
    $categoria = (isset($_POST["categoria"]) && $_POST["categoria"] !== -1)? $_POST["categoria"]: null;
  
    $subcategoria = (isset($_POST["subcategoria"]) && $_POST["subcategoria"] !== -1)? $_POST["subcategoria"]: null;
    
    $codigo = (isset($_POST["codigo"]) && trim($_POST["codigo"]) !== "")? trim($_POST["codigo"]): null;
    
    $descripcion = (isset($_POST["descripcion"]) && trim($_POST["descripcion"]) !== "")? ucfirst(trim($_POST["descripcion"])): null;
    
    $material = (isset($_POST["material"]) && trim($_POST["material"]) !== "")? ucfirst(trim($_POST["material"])): (trim($_POST["input-material"]) !== ""? ucfirst(trim($_POST["input-material"])) : null);
    
    $color = (isset($_POST["color"]))? ucfirst(trim($_POST["color"])): null;
    
    $caracteristicas = (isset($_POST["caracteristicas"]))? $_POST["caracteristicas"]: null;
    
    $marca = (isset($_POST["marca"]) && trim($_POST["marca"]) !== "")? trim($_POST["marca"]): (trim($_POST["input-marca"]) !== ""? ucfirst(trim($_POST["input-marca"])) : null);
    
    $cant = (isset($_POST["cant"]) && $_POST["cant"] !== "" && intval($_POST["cant"]) >= 0)? $_POST["cant"]: null;
    
    $precio = (isset($_POST["precio"]) && floatval($_POST["precio"]) > 0)? $_POST["precio"]: null;
    
    $descuento = (isset($_POST["descuento"]) && floatval($_POST["descuento"]) >= 0 && floatval($_POST["descuento"]) < 100)? 
                    $_POST["descuento"]: null;
    
    $existImg = ($_FILES["imagen"]["tmp_name"] != "")? getimagesize($_FILES["imagen"]["tmp_name"]) : null;

    if ($categoria !== null && $subcategoria !== null && $codigo !== null && $descripcion !== null && $material !== null &&
    $color !== null && $caracteristicas !== null && $marca !== null && $cant !== null && $precio !== null && $descuento !== null){
        // foreach ($caracteristicas as $caract){
        //     $caract = ltrim($caract, "0");
        // }

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

        if($existImg !== null){
            $sql = "INSERT INTO producto (`codigo`, `descripcion`, `material`, `color`,`caracteristicas`,
                                `marca`, `stock`, `precio`, `id_categoria`, `id_subcategoria`, `descuento`) 
                    VALUES ('$codigo', '$descripcion', '$material', '$color','$caract','$marca','$cant',
                            '$precio', '$categoria', '$subcategoria', '$descuento')
            ";

            $rs = $db->query($sql);
            $id_producto = $db->lastInsertId();

            $imagen = $_FILES["imagen"];
            $imagenDestino = "../images/". $categoria . "/". $subcategoria . "/" . $id_producto . "/";
            mkdir($imagenDestino, 0777, true);
            $result = subirImagen($imagen, "veFuncProductoAlta.php", $imagenDestino);

            if(!$result){
                $sql = "DELETE FROM producto WHERE id = '$id_producto'";
                $rs = $db->query($sql);
                
                //No se pudo subir la imagen
                header ("location: ../vistas/veProductoAlta.php?error=1");
            } else{
                $sql = "INSERT INTO imagen_productos (id_producto, destination, portada) VALUES
                        ('$id_producto', '$result', 1)
                ";

                $rs = $db -> query($sql);
                header ("location: ../vistas/veProductoAlta.php?alta=exito");
            }
        } else {
            //La extensión del archivo es incorrecta
            header ("location: ../vistas/veProductoAlta.php?error=2");
        }
    }
    else{
        //Los datos ingresados no son correctos
        header ("location: ../vistas/veProductoAlta.php?error=3");
    }
?>