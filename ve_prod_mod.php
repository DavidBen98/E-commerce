<?php 
    include("encabezado.php");
    if (!perfil_valido(1)) {
        header("location:index.php");
    }
?> 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css"  href="assets/css/estilos.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="assets/css/ve_estilos.css" media="screen">
    <title>Muebles Giannis - Las mejores marcas</title>
</head>
<body>
    <header id='header'>
        <?php echo $encab; ?>
	</header> 
    <main>
        
        <input type='button' onclick="window.location.href='ve_prod_alta.php'" class='btn btn-secondary btn-lg' name='bCambiarCarac' id='bCambiarCarac' title='Cambiar caracteristicas' value='Cambiar caracteristicas'>
        <input type='button' onclick="window.location.href='ve_prod_mod_ubicacion.php'" class='btn btn-secondary btn-lg' name='bCambiarUbica' id='bCambiarUbica' title='Cambiar Ubicacion' value='Cambiar Ubicacion'>
             
    </main>
</body>
</html>