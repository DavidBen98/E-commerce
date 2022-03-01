<?php 
    require 'inc/conn.php';

    global $db;
    
    $id = isset($_POST['subcategoria'])? $_POST['subcategoria']: null;

    if ($nombre !== null && $check !== false){
        $sql = "DELETE FROM subcategoria WHERE id_subcategoria = '$id'
        ";

        $rs = $db->query($sql);
    }
    else{
        header ("location: veSubcategoriaBaja.php?error=data");
    }
?>