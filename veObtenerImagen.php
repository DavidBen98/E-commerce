<?php
    if (isset($_POST['subcategoria'])){
        $path = 'images/subcategorias/';
        $subcategoria = $_POST['subcategoria'];
        $files = scandir($path);

        foreach($files as $file){
            if ($file == $subcategoria.".png" || $file == $subcategoria.".jpg" || $file == $subcategoria.".jpeg"){
                $path .= $file;
            }
        }

        if ($path === 'images/subcategorias/'){
            $path.= 'notfound.jpg';
        }

        echo $path;
    } else if (isset($_POST['categoria'])){
        $path = 'images/categorias/';
        $categoria = $_POST['categoria'];
        $files = scandir($path);

        foreach($files as $file){
            if ($file == $categoria.".png" || $file == $categoria.".jpg" || $file == $categoria.".jpeg"){
                $path .= $file;
            }
        }

        if ($path === 'images/categorias/'){
            $path.= 'notfound.jpg';
        }

        echo $path;
    }
?>