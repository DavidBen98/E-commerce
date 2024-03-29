<?php 
    require "../inc/conn.php";

    global $db;

    if (!empty($_POST["categoria"])){
        $categoria = $_POST["categoria"];

        $sql = "SELECT nombre_subcategoria, id_subcategoria
                FROM subcategoria
                WHERE id_categoria = '$categoria'
        ";

        $rs = $db->query($sql); 

        if (!empty($_POST["subcategoria"]) && $_POST["subcategoria"] == "nueva"){
            echo "  
                <label for='select-subcategoria' class='label'> Subcategoría nueva </label>
                <select name='subcategoria' class='form-select select-subcategoria' id='select-subcategoria'>
            ";
        } else {
            echo "  
                <label for='select-subcategoria' class='label'> Subcategorías </label>
                <select name='subcategoria' class='form-select select-subcategoria' id='select-subcategoria'>
            ";
        }

        foreach ($rs as $row) {
            echo "<option value=".$row["id_subcategoria"].">". $row["nombre_subcategoria"] . "</option>";
        }
        
        echo "</select>";
    }
    else{
        include_once "../controlador/apiDatos.php";
    }

    if (!empty($_POST["provincia"])){ //desde login(registrarse)
        $provincia = $_POST["provincia"];

        if ($provincia != 02 && ($provincia == 30 || $provincia ==78 || $provincia == 86)){
            //Si es entre rios, santa cruz o santiago del estero
            $url = "https://apis.datos.gob.ar/georef/api/localidades?provincia=".$provincia."&max=1000";
            $json = file_get_contents($url);
            $json = json_decode($json);
            $datos= $json->localidades;
        }
        else if($provincia != 02){
            //si es cualquier provincia menos las anteriores y ciudad de bs as
            $url = "https://apis.datos.gob.ar/georef/api/municipios?provincia=".$provincia."&max=1000";
            $json = file_get_contents($url);
            $json = json_decode($json);
            $datos= $json->municipios;
        }

        if ($provincia != 02 && $provincia != -1){
            //si no es ciudad de bs as
            foreach ($datos as $name){    
                $municipio[] = $name -> nombre;    
            }

            sort($municipio);

            echo "
                <label for='ciu' class='form-label'>Ciudad</label>
                <select id='ciu' name='ciudad' class='form-select'>
            ";  
            
            foreach ($municipio as $nombre){ 
                echo "<option value='$nombre'>". $nombre . "</option>";
            }   
            echo "</select>";
        }
    }

    if (!empty($_POST["prov"])){ //desde modificarDatos
        $provincia = $_POST["prov"];
        $ciudad = $_POST["ciudad"];

        $select_ciudad = "";
        if ($provincia != 02 && ($provincia == 30 || $provincia ==78 || $provincia == 86)){
            //Si es entre rios, santa cruz o santiago del estero
            $url = "https://apis.datos.gob.ar/georef/api/localidades?provincia=".$provincia."&max=1000";
            $json = file_get_contents($url);
            $json = json_decode($json);
            $datos= $json->localidades;
        }
        else if($provincia != 02){
            //si es cualquier provincia menos las anteriores y ciudad de bs as
            $url = "https://apis.datos.gob.ar/georef/api/municipios?provincia=".$provincia."&max=1000";
            $json = file_get_contents($url);
            $json = json_decode($json);
            $datos= $json->municipios;
        }

        if ($provincia != 02 && $provincia != -1){
            //si no es ciudad de bs as
            foreach ($datos as $name){    
                $municipio[] = $name -> nombre;    
            }

            sort($municipio);

            $select_ciudad =  "<select id='ciu' name='ciudad' title='Ciudad' class='form-select'>"; 

            foreach ($municipio as $nombre){ 
                if ($nombre == $ciudad){
                    $select_ciudad .= "<option value='$nombre' selected>". $nombre . "</option>";
                }
                else{
                    $select_ciudad .= "<option value='$nombre'>". $nombre . "</option>";
                }
            }   
        
            $select_ciudad .= "</select>";
        }

        echo $select_ciudad;
        exit;
    }
?>