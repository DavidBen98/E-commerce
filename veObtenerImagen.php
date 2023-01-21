<?php

    if (isset($_POST['subcategoria'])){

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