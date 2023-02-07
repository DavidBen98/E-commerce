<?php 
    require "../inc/conn.php";
    require "funciones.php";

    global $db;
    
    if(isset($_POST['categoria']) && isset($_POST['subcategoria'])){
        $categoria = obtenerNombreCategoria($_POST['categoria']);
        $categoria = strtolower(substr($categoria,0,2));
        $subcategoria = obtenerNombreSubcategoria($_POST['subcategoria']);
        $subcategoria = strtolower(substr($subcategoria,0,2));
    
        $sql = "SELECT codigo
                FROM producto
                WHERE codigo LIKE '$categoria$subcategoria%'
        ";
    
        $rs = $db -> query($sql);
    
        $ultimoProducto = 0;

        foreach ($rs as $row){
            $ultimoProducto = $row['codigo'];
        }
    
        $ultimoProducto = intval(substr($ultimoProducto,4)) + 1; //posicion del nuevo producto
    
        echo $ultimoProducto;
    }
    else{
        header("location:../vistas/index.php");
    }
?>