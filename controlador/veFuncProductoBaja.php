<?php 
    require '../inc/conn.php';
    require 'funciones.php';

    global $db;
    
    if (isset($_GET['eliminar'])){
        $id = $_GET['eliminar'];

        $sql = "SELECT destination 
                FROM imagen_productos
                WHERE id_producto = '$id' AND portada = 1
        ";

        $rs = $db->query($sql);

        $path = '';

        foreach ($rs as $row){
            $path = $row['destination'];
        }

        $path = substr($path,0, strrpos($path,'/'));

        eliminar_direccion($path);
        //Elimina todas las imagenes de ese producto, ya sean portadas o no
        $sql = "DELETE FROM imagen_productos
                WHERE id_producto = '$id'
        ";

        $rs = $db -> query ($sql);

        $sql = "DELETE FROM producto
                WHERE id = '$id'
        ";

        $rs = $db -> query ($sql);
        header ("location: ../vistas/veProductoBaja.php?elim=exito");
        exit;
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

            $sql = "SELECT * FROM imagen_productos
                WHERE id_producto = $id AND portada=1
            ";

            $result = $db -> query($sql);
            $path = '';

            foreach ($result as $r){
                $path = $r['destination'];
            }

            $imagenes .= "
                <div class='producto'>
                    <img src='../$path' class='imagen' alt='$id' title='{$row['descripcion']}'>
                    <p>{$row['descripcion']}</p>
                    <p><b>Código:</b> {$row['codigo']}</p>
                </div>
            ";
        }

        echo $imagenes;
        exit;
    }
?>