<?php
    require_once "config.php";

    // Revocar el token OAuth
    $google_client->revokeToken();

    // Cerrar sesión de Twitter
    // if (isset($_SESSION['access_token'])) {
    //     $auth = new TwitterAuth($cliente);
    //     $auth->signOut();
    // }

    // Eliminar todos los datos de sesión
    $_SESSION = array();
    session_unset();
    session_destroy();

    // Redirigir a la página de inicio
    header("Location: ../vistas/index.php");
    exit;
?>