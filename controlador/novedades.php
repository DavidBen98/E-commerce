<?php
    include "../inc/conn.php";
    require_once "config.php";

    global $db;

    $email = isset($_POST["modal-email"]) ? trim($_POST["modal-email"]) : null;
    $pagina_previa = $_COOKIE['previous_page'];
    $position = strpos($pagina_previa, "suserror");

    //Si ya recibia error, entonces no contemplar esa variable
    if ($position) {
        $pagina_previa = substr($pagina_previa, 0, $position-1);
    } 

    $position = strpos($pagina_previa, "?");

    if ($position){
        $pagina_previa .= "&";
    } else {
        $pagina_previa .= "?";
    }

    if ($email === null) {
        header("location: ..{$pagina_previa}suserror=1");
        exit;
    }

    $stmt = $db->prepare("SELECT id FROM usuario WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetch();
    if ($result === false) {
        header("location: ..{$pagina_previa}suserror=2");
        exit;
    }

    $id = $result["id"];
    $stmt = $db->prepare("UPDATE usuario SET suscripcion = 1 WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    header("location: ..{$pagina_previa}sus=true");
    exit;
?>