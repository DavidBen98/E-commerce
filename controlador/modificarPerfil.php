<?php  
    include "../inc/conn.php";
    require_once 'config.php';
    
    global $db;
    $idUsuario = "";

    if (isset($_SESSION['idUsuario'])){
        $idUsuario = $_SESSION['idUsuario'];
    }
    else if (isset($_SESSION['user'])){
        $idUsuario = $_SESSION['user'];
        $mail = false;
    }
    else if ($_SESSION['id_tw']){
        $idUsuario = $_SESSION['id_tw'];
    }

    if (!isset($_SESSION['idUsuario'])){
        $sql = "SELECT u.id
                FROM usuario as u
                INNER JOIN usuario_rs as rs ON rs.id = u.id
                WHERE rs.id_social = '$idUsuario'
        ";

        $rs = $db->query($sql);

        foreach ($rs as $row){
            $idUsuario = $row['id'];
        }
    }

    $nombreUsuario = isset($_POST['nombreUsuario'])? $_POST['nombreUsuario']:null;
    $dni = isset($_POST['dni'])? $_POST['dni']:null;
    $nombre = isset($_POST['nombre'])? $_POST['nombre']:null;
    $apellido = isset($_POST['apellido'])? $_POST['apellido']:null;
    $email = isset($_POST['email'])? $_POST['email']:null;
    $provincia = isset($_POST['provincia']) && $_POST['provincia'] != -1? trim($_POST['provincia']) : "";
    $ciudad = isset($_POST['ciudad'])? trim($_POST['ciudad']) : "";
    $direccion = isset($_POST['direccion'])? $_POST['direccion'] : "";

    $sql = "SELECT usuario.id
            FROM usuario
            WHERE nombreUsuario = '$nombreUsuario' AND id != '$idUsuario'
    ";

    $rs = $db->query ($sql);
 
    $i = 0;
    foreach ($rs as $row){
        $i++;
    }

    if ($i > 0){
        header ('location: ../informacionPersonal.php?error=1#mensaje');
    }
    else{
        switch ($provincia) {
            case '':
                $ciudad = "";
                break;
            case '02':
                $provincia = "Ciudad Autónoma de Buenos Aires";
                break;
            case '06':
                $provincia = "Buenos Aires";
                break;
            case '10':
                $provincia = "Catamarca";
                break;
            case '14':
                $provincia = "Córdoba";
                break;
            case '18':
                $provincia = "Corrientes";
                break;
            case '22':
                $provincia = "Chaco";
                break;
            case '26':
                $provincia = "Chubut";
                break;
            case '30':
                $provincia = "Entre Ríos";
                break;
            case '34':
                $provincia = "Formosa";
                break;
            case '38':
                $provincia = "Jujuy";
                break;
            case '42':
                $provincia = "La Pampa";
                break;
            case '46':
                $provincia = "La Rioja";
                break;
            case '50':
                $provincia = "Mendoza";
                break;
            case '54':
                $provincia = "Misiones";
                break;
            case '58':
                $provincia = "Neuquén";
                break;
            case '62':
                $provincia = "Río Negro";
                break;
            case '66':
                $provincia = "Salta";
                break;
            case '70':
                $provincia = "San Juan";
                break;
            case '74':
                $provincia = "San Luis";
                break;
            case '78':
                $provincia = "Santa Cruz";
                break;
            case '82':
                $provincia = "Santa Fe";
                break;
            case '86':
                $provincia = "Santiago del Estero";
                break;
            case '90':
                $provincia = "Tucumán";
                break;
            case '94':
                $provincia = "Tierra del Fuego, Antártida e Islas del Atlántico Sur";
                break;
        }

        $dire = "";

        if ($direccion[0] != "" && $direccion[1] != "" && $direccion[2] != ""){
            for ($i=0;$i<count($direccion);$i++){
                if ($direccion[$i] != "")
                if ($i == 2){
                    $dire .= ', ' . $direccion[$i];
                }else{
                    $dire .= $direccion[$i] . ' ';
                }
            }
        }

        $dire = trim($dire);

        $sql = "UPDATE `usuario` SET 
                `nombreUsuario`='$nombreUsuario',`nroDni`='$dni',`nombre`='$nombre',`apellido`='$apellido', `provincia` = '$provincia', `ciudad` = '$ciudad', `direccion` = '$dire'
                WHERE `id`='$idUsuario'
        ";

        $rs = $db->query ($sql);

        header ('location: ../informacionPersonal.php?modif=exito#mensaje');
    }
?>