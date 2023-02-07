<?php 
    include_once "config.php";
    $API_URL_prov= "https://apis.datos.gob.ar/georef/api/provincias?";

    // Validación de la URL
    if (!filter_var($API_URL_prov, FILTER_VALIDATE_URL)) {
        exit('URL inválida');
    }

    $json = file_get_contents($API_URL_prov);

    if ($json === false) {
        exit('No se pudo obtener la respuesta de la API');
    }

    $json = json_decode($json, true);
    if (!is_array($json) || !isset($json['provincias'])) {
        exit('La respuesta de la API no es válida');
    }

    $datos= $json['provincias'];

    // $json = json_decode($json);
    // $datos= $json->provincias;
    $cant = count ($datos);
    $i = 0;
    for ($i; $i < $cant; $i++){
        // $nombreProvincia = $datos[$i]->nombre;
        // $idProvincia = $datos[$i] ->id;

        // if ($i == 0){
        //     $provincias[0] = array("id" => $idProvincia, "nombre" => $nombreProvincia);
        // }
        // else{
        //     $provincias[$i]= ["id" => $idProvincia, "nombre" => $nombreProvincia]; 
        // }
        $nombreProvincia = $datos[$i]['nombre'];
        $idProvincia = $datos[$i]['id'];

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
                $select.= "<option value=".htmlspecialchars($provincia["id"], ENT_QUOTES, 'UTF-8')."selected>".htmlspecialchars($provincia["nombre"], ENT_QUOTES, 'UTF-8')."</option>";
            }
            else{
                $select.= "<option value=".htmlspecialchars($provincia["id"], ENT_QUOTES, 'UTF-8').">".htmlspecialchars($provincia["nombre"], ENT_QUOTES, 'UTF-8')."</option>";
            }
        }
        else{
            $select.= "<option value=".htmlspecialchars($provincia["id"], ENT_QUOTES, 'UTF-8').">".htmlspecialchars($provincia["nombre"], ENT_QUOTES, 'UTF-8')."</option>";
        }
    }
    $select .= "</select>";
?>