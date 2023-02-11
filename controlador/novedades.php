<?php
    include "../inc/conn.php";
    require_once "config.php";

    global $db;

    $email = isset($_POST["modal-email"]) ? trim($_POST["modal-email"]) : null;

    if ($email === null) {
        header("location: ../vistas/index.php?error=1");
        exit;
    }

    $stmt = $db->prepare("SELECT id FROM usuario WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetch();
    if ($result === false) {
        header("location: ../vistas/index.php?error=2");
        exit;
    }

    $id = $result["id"];
    $stmt = $db->prepare("UPDATE usuario SET suscripcion = 1 WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    header("location: ../vistas/index.php?sus=true");
    exit;
?>