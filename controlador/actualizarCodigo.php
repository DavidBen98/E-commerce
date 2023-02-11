<?php 
    require "../inc/conn.php";
    require "funciones.php";

    global $db;
    
    if(isset($_POST['categoria']) && isset($_POST['subcategoria'])){
        $categoria = obtener_nombre_categoria($_POST['categoria']);
        $categoria = strtolower(substr($categoria,0,2));
        $subcategoria = obtener_nombre_subcategoria($_POST['subcategoria']);
        $subcategoria = strtolower(substr($subcategoria,0,2));
    
        $sql = "SELECT codigo
                FROM producto
                WHERE codigo LIKE :categoriaSubcategoria
        ";
    
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':categoriaSubcategoria', "$categoria$subcategoria%", PDO::PARAM_STR);
        $stmt->execute();
        $rs = $stmt->fetchAll();
    
        $ultimo_producto = 0;

        foreach ($rs as $row){
            $ultimo_producto = $row['codigo'];
        }
    
        $ultimo_producto = intval(substr($ultimo_producto,4)) + 1; //posicion del nuevo producto
    
        echo $ultimo_producto;
        exit;
    }
    else{
        header("location:../vistas/index.php");
        exit;
    }
?>