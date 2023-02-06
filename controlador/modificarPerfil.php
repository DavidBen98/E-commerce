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
        $rs = obtenerUsuarioConRS($idUsuario);

        foreach ($rs as $row){
            $idUsuario = $row['id'];
        }
    }

    $nombreUsuario = (isset($_POST['nombreUsuario']) && !empty($_POST['nombreUsuario']) && trim($_POST['nombreUsuario']) != "")? trim($_POST['nombreUsuario']) : null;
    $nombre = (isset($_POST['nombre']) && trim($_POST['nombre']) != "")? trim($_POST['nombre']) : null;
    $apellido = (isset($_POST['apellido']) && trim($_POST['apellido']) != "")? trim($_POST['apellido']) : null;
    $dni = (isset($_POST['dni']) && strlen(trim($_POST['dni'])) > 6)? trim($_POST['dni']) : null;
    $email = (isset($_POST['email']) && trim($_POST['email']) != "")? trim($_POST['email']) : null;
    $provincia = (isset($_POST['provincia']) && trim($_POST['provincia']) != "" && $_POST['provincia'] != -1)? trim($_POST['provincia']) : null;
    $ciudad = (isset($_POST['ciudad']) && trim($_POST['ciudad']) != "")? trim($_POST['ciudad']) : null;
    $direccion = (isset($_POST['direccion']) && trim($_POST['direccion'][0]) != "" && trim($_POST['direccion'][1]) != "")? $_POST['direccion'] : null;
    $suscripcion = ($_POST['suscripcion'] == '1')? 1 : 0;

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
        header ('location: ../vistas/informacionPersonal.php?error=1#mensaje');
    }
    else if ($nombre == null || $apellido == null || $dni == null || $email == null || $provincia == null || ($ciudad == null && $provincia !="02") || $direccion == null || $nombreUsuario == null){
        header("location:../vistas/informacionPersonal.php?error=2");
    } else {
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
                if ($direccion[$i] != "") {
                    if ($i == 2){
                        $dire .= ', ' . $direccion[$i];
                    }else{
                        $dire .= $direccion[$i] . ' ';
                    }
                }
            }
        }

        $dire = trim($dire);

        $sql = "UPDATE `usuario` SET 
                `nombreUsuario`='$nombreUsuario',`nroDni`='$dni',`nombre`='$nombre',`apellido`='$apellido', `provincia` = '$provincia', `ciudad` = '$ciudad', `direccion` = '$dire'
                WHERE `id`='$idUsuario'
        ";

        $rs = $db->query ($sql);

        header ('location: ../vistas/informacionPersonal.php?modif=exito#mensaje');
    }
?>