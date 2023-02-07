<?php
    include "../inc/conn.php";
    require_once "config.php";

    global $db;

    $email = isset($_POST["email"])? $_POST["email"]:null;

    if ($email !== null){
        $sql = "SELECT id
                FROM usuario
                WHERE email = '$email'
        ";

        $rs = $db->query($sql);

        $exist = false;

        foreach ($rs as $row){
            $exist = true;
            $id = $row["id"];
            $sql = "UPDATE `usuario` SET `suscripcion`='1' WHERE id = '$id'";

            $db->query($sql);
        }

        if (!$exist){
            header ("location: ../vistas/index.php?error=2");
        } else {
            header ("location: ../vistas/index.php?sus=true");
        }
    } else {
        header ("location: ../vistas/index.php?error=1");
    }
?>