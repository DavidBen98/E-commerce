<?php 
    require 'inc/conn.php';

    global $db;
    
    $id = isset($_POST['categoria'])? $_POST['categoria']: null;

    if ($nombre !== null && $check !== false){
        $sql = "DELETE FROM categoria WHERE id_categoria = '$id'
        ";

        $rs = $db->query($sql);
    }
    else{
        header ("location: ve_cat_baja.php?error=data");
    }
?>