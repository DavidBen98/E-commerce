<?php 
    require 'inc/conn.php';

    global $db;
    
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
?>