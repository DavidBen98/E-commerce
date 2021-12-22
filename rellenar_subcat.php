<?php require 'inc/conn.php';


global $db;

if (!empty($_POST['categoria'])){
    $cate = $_POST['categoria'];

    $sql = "SELECT nombre_subcategoria, id_subcategoria
        FROM subcategoria
        WHERE id_categoria = $cate";

    $rs = $db->query($sql); 

    echo "  <label for='subcategoria' class='label'> Subcategorías </label>
            <select id='subcategoria' name='subcategoria' class='form-select'>";

    foreach ($rs as $row) {
        echo "<option value=".$row['id_subcategoria'].">". $row['nombre_subcategoria'] . "</option>";
    }
    
    echo "</select>";
}

?>