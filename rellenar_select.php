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

if (!empty($_POST['provincia'])){ //desde login(registrarse)
    $provincia = $_POST['provincia'];

    if ($provincia != 02 && ($provincia == 30 || $provincia ==78 || $provincia == 86)){
        //Si es entre rios, santa cruz o santiago del estero
        $url = 'https://apis.datos.gob.ar/georef/api/localidades?provincia='.$provincia.'&max=1000';
        $json = file_get_contents($url);
        $json = json_decode($json);
        $datos= $json->localidades;
    }
    else if($provincia != 02){
        //si es cualquier provincia menos las anteriores y ciudad de bs as
        $url = 'https://apis.datos.gob.ar/georef/api/municipios?provincia='.$provincia.'&max=1000';
        $json = file_get_contents($url);
        $json = json_decode($json);
        $datos= $json->municipios;
    }

    if ($provincia != 02){
        //si no es ciudad de bs as
        foreach ($datos as $name){    
            $municipio[] = $name -> nombre;    
        }
        sort($municipio);

        echo "<label for='ciudad' class='form-label'>Ciudad</label>
              <select id='ciu' name='ciudad' class='form-select'>";  
        foreach ($municipio as $nombre){ 
            echo "<option value='$nombre'>". $nombre . "</option>";
        }   
        echo "</select>";
    }
}



?>