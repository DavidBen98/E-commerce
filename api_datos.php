<?php 
    $API_URL_prov= 'https://apis.datos.gob.ar/georef/api/provincias?';

    $json = file_get_contents($API_URL_prov);
    $json = json_decode($json);
    $datos= $json->provincias;
    $cant = count ($datos);
    $i = 0;
    for ($i; $i < $cant; $i++){
        $nombre_prov = $datos[$i]->nombre;
        $id_prov = $datos[$i] ->id;

        if ($i == 0){
            $a[0] = array('id' => $id_prov, 'nombre' => $nombre_prov);
        }
        else{
            $a[$i]= ['id' => $id_prov, 'nombre' => $nombre_prov]; 
        }
    }

    sort ($a);

    echo "<select id='provincia' name='provincia'>";
    foreach ($a as $provincia){
          echo "<option value=".$provincia['id'].">". $provincia['nombre']. "</option>";
    }
    echo "</select>";

    //echo "<option value=".$dato->nombre.">". $dato->nombre . "</option>";
?>