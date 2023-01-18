<?php 
    require 'inc/conn.php';

    global $db;
    
    if (isset($_GET['eliminar'])){
        $id = $_GET['eliminar'];

        //Elimina todas las imagenes de ese producto, ya sean portadas o no
        $sql = "DELETE FROM imagen
                WHERE id_producto = '$id'
        ";

        $rs = $db -> query ($sql);

        $sql = "DELETE FROM producto
                WHERE id = '$id'
        ";

        $rs = $db -> query ($sql);
        header ("location: veProductoBaja.php?elim=exito");
    }
    else{
        $categoria = $_POST['categoria'];
        $subcategoria = $_POST['subcategoria'];

        $sql = "SELECT *
                FROM producto
                WHERE id_categoria = '$categoria' AND id_subcategoria= '$subcategoria'
        ";

        $rs = $db -> query($sql);

        $imagenes = "";

        foreach ($rs as $row){
            $id = $row['id'];

            $sql = "SELECT * FROM imagen 
                WHERE id_producto = $id AND portada=1
            ";

            $result = $db -> query($sql);
            $path = '';

            foreach ($result as $r){
                $path = $r['destination'];
            }

            $imagenes .= "<div class='producto'>
                            <img src='$path' class='imagen' alt='$id' title='{$row['descripcion']}'>
                            <p>{$row['descripcion']}</p>
                            <p><b>Código:</b> {$row['codigo']}</p>
                        </div>";
        }

        echo $imagenes;
    }
?>