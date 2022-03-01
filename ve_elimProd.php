<?php 
    require 'inc/conn.php';

    global $db;
    
    if (isset($_GET['eliminar'])){
        $codigo = $_GET['eliminar'];
        $sql = "DELETE FROM producto
                WHERE codigo = '$codigo'
        ";

        $rs = $db -> query ($sql);
        header ("location: ve_prod_baja.php?elim=exito");
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
            $imagenes .= "<div class='producto'>
                            <img src='images/{$row['codigo']}.png' class='imagen' alt='{$row['codigo']}' title='{$row['descripcion']}'>
                            <p>{$row['descripcion']}</p>
                            <p><b>Código:</b> {$row['codigo']}</p>
                        </div>";
        }

        echo $imagenes;
    }
?>