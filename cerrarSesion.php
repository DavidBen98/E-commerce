<?php
    session_start();
    
    unset($_SESSION["user"]);
    unset($_SESSION["perfil"]);
    unset($_SESSION["nombre"]);

    $_SESSION=array();
    session_destroy();

    header('location:index.php');
?>