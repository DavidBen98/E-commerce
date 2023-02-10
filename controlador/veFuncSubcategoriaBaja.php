<?php 
    require '../inc/conn.php';

    global $db;
    
    $id = isset($_POST['subcategoria'])? $_POST['subcategoria']: null;

    if ($id !== null){
        $sql = "UPDATE subcategoria SET `activo`='0' WHERE id_subcategoria = '$id'";

        $rs = $db->query($sql);

        header ("location: ../vistas/veSubcategoriaBaja.php?elim=exito");
        exit;
    }
    else{
        header ("location: ../vistas/veSubcategoriaBaja.php?error=data");
        exit;
    }
?>