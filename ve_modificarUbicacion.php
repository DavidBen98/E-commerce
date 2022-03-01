<!DOCTYPE html>
<?php 
    include ('inc/conn.php');

    global $db;

    $categoria = $_POST['categoria'];
    $subcategoria = $_POST['subcategoria'];
    $codigo = $_POST['codigo'];

    $sql = "UPDATE producto SET id_categoria = '$categoria', id_subcategoria = '$subcategoria'
            WHERE codigo = '$codigo'";

    $rs = $db->query($sql);

    header("location: veProductoModif.php?modUbi=exito&codigo=$codigo")
?>