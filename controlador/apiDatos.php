<?php 
    include_once "config.php";
    $API_URL_prov= "https://apis.datos.gob.ar/georef/api/provincias?";

    $json = file_get_contents($API_URL_prov);
    $json = json_decode($json);
    $datos= $json->provincias;
    $cant = count ($datos);
    $i = 0;
    for ($i; $i < $cant; $i++){
        $nombreProvincia = $datos[$i]->nombre;
        $idProvincia = $datos[$i] ->id;

        if ($i == 0){
            $provincias[0] = array("id" => $idProvincia, "nombre" => $nombreProvincia);
        }
        else{
            $provincias[$i]= ["id" => $idProvincia, "nombre" => $nombreProvincia]; 
        }
    }

    sort ($provincias);

    $select = "<select id='provincia' name='provincia' title='Provincia'>
                <option value='-1'>Seleccione una opción</option>
    ";

    foreach ($provincias as $provincia){
        if (isset($_SESSION ["provincia"])){
            if ($_SESSION ["provincia"] == $provincia){
                $select.= "<option value=".$provincia["id"]."selected>". $provincia["nombre"]. "</option>";
            }
            else{
                $select.= "<option value=".$provincia["id"].">". $provincia["nombre"]. "</option>";
            }
        }
        else{
            $select.= "<option value=".$provincia["id"].">". $provincia["nombre"]. "</option>";
        }
    }
    $select .= "</select>";
?>