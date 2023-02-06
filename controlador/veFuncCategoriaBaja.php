<?php 
    require '../inc/conn.php';
    include_once ("funciones.php");

    global $db;
    
    $id = isset($_POST['categoria'])? $_POST['categoria']: null;

    if ($id !== null){
        $sql = "UPDATE categoria SET `activo`='0' WHERE id_categoria = '$id'";

        $rs = $db->query($sql);

        header ("location: ../vistas/veCategoriaBaja.php?elim=exito");
    }
    else{
        header ("location: ../vistas/veCategoriaBaja.php?error=data");
    }
?>
