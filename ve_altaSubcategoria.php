<?php 
    require 'inc/conn.php';

    global $db;
    
    $nombre = isset($_POST['tNombre'])? $_POST['tNombre']: null;
    $id_categoria = isset($_POST['categoria'])? $_POST['categoria']: null;

  
    $imagen = $_FILES["imagen"]["tmp_name"];
    $portada = isset($_POST['portada'])? 1: 0;

    $check = ($_FILES["imagen"]["tmp_name"] != '')? getimagesize($_FILES["imagen"]["tmp_name"]) : false;
    if($check !== false){
        $imagen = addslashes(file_get_contents($imagen));
    }

    if ($nombre !== null && $id_categoria !== false){
        $sql = "INSERT INTO subcategoria (`nombre_subcategoria`,`id_categoria`) 
                VALUES ('$nombre','$id_categoria')
        ";

        $rs = $db->query($sql);
    }
    else{
        header ("location: ve_subc_alta.php?error=data");
    }
?>