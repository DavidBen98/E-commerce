<?php 
    require '../inc/conn.php';

    global $db;
    
    $id = isset($_POST['subcategoria'])? $_POST['subcategoria']: null;

    if ($nombre !== null){
        $sql = "UPDATE subcategoria SET `activo`='0' WHERE id_subcategoria = '$id'";

        $rs = $db->query($sql);

        header ("location: ../veSubcategoriaBaja.php?elim=exito");
    }
    else{
        header ("location: ../veSubcategoriaBaja.php?error=data");
    }
?>