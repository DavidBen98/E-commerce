<?php  
    include "inc/conn.php";
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
                WHERE rs.id_social = $id_usuario
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

    $sql = "SELECT usuario.id
            FROM usuario
            WHERE nombreUsuario = '$nombreUsuario' AND id != '$idUsuario'";

    $rs = $db->query ($sql);
 
    $i = 0;
    foreach ($rs as $row){
        $i++;
    }

    if ($i > 0){
        header ('location: informacionPersonal.php?error=1#mensaje');
    }
    else{
        $sql = "UPDATE `usuario` SET 
                `nombreUsuario`='$nombreUsuario',`nroDni`='$dni',`nombre`='$nombre',`apellido`='$apellido' 
                    WHERE `id`=$idUsuario";

        $rs = $db->query ($sql);

        header ('location: informacionPersonal.php?modif=exito');
    }
    

?>