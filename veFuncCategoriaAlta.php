<?php 
    require 'inc/conn.php';

    global $db;
    
    $nombre = isset($_POST['nombre'])? $_POST['nombre']: null;
  
    $imagen = $_FILES["imagen"]["tmp_name"];
    $portada = isset($_POST['portada'])? 1: 0;

    $check = ($_FILES["imagen"]["tmp_name"] != '')? getimagesize($_FILES["imagen"]["tmp_name"]) : false;
    if($check !== false){
        $imagen = addslashes(file_get_contents($imagen));
    }

    if ($nombre !== null && $check !== false){
        $sql = "INSERT INTO categoria (`nombre_categoria`) 
                VALUES ('$nombre')
        ";

        $rs = $db->query($sql);

        header ("location: veCategoriaAlta.php?alta=exito");

    }
    else{
        header ("location: veCategoriaAlta.php?error=data");
    }
?>