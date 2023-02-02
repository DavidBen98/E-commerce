<?php 
    //En los archivos en donde solo se trabaje PHP no cerrar la etiqueta por seguridad
    //Si cerramos permite añadir un script de js
    require '../inc/conn.php';

    global $db;
    
    if(isset($_POST['categoria']) && isset($_POST['subcategoria'])){
        $categoria = $_POST['categoria'];
        $subcategoria = $_POST['subcategoria'];
    
        $sql = "SELECT codigo
                FROM producto
                WHERE id_categoria = '$categoria' AND id_subcategoria= '$subcategoria'
        ";
    
        $rs = $db -> query($sql);
    
        $ultimoProducto = 0;

        foreach ($rs as $row){
            $ultimoProducto = $row['codigo'];
        }
    
        $ultimoProducto = intval(substr($ultimoProducto,4));

        $ultimoProducto = $ultimoProducto + 1; //posicion del nuevo producto
    
        echo $ultimoProducto;
    }
    else{
        header("location:../index.php");
    }
?>