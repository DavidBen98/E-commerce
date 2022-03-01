<?php 
    require 'inc/conn.php';

    global $db;
    
    $id_categoria = isset($_POST['categoria'])? $_POST['categoria']: null;
    $nombre = isset($_POST['nombre']) && $_POST['nombre'] !== ""? $_POST['nombre']: null;
  
    $imagen = $_FILES["imagen"]["tmp_name"];

    $check = ($_FILES["imagen"]["tmp_name"] != '')? getimagesize($_FILES["imagen"]["tmp_name"]) : false;
    if($check !== false){
        $imagen = addslashes(file_get_contents($imagen));
    }

    if ($nombre !== null && $categoria !== null){
        $sql = "UPDATE categoria SET nombre_categoria = '$nombre'
                WHERE id_categoria = '$id_categoria'
        ";

        $rs = $db->query($sql);
    }
    else{
        header ("location: veSubcategoriaModif.php?error=data");
    }
?>