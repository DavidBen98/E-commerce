<?php 
    require 'inc/conn.php';

    global $db;
    
    $id = isset($_POST['categoria'])? $_POST['categoria']: null;

    if ($id !== null){
        $sql = "DELETE FROM categoria WHERE id_categoria = '$id'
        ";

        $rs = $db->query($sql);

        header ("location: veCategoriaBaja.php?elim=exito");

    }
    else{
        header ("location: veCategoriaBaja.php?error=data");
    }
?>