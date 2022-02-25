<?php 
    include("encabezado.php");
    if (!perfil_valido(1)) {
        header("location:index.php");
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Muebles Giannis - Las mejores marcas</title>
    <link type="text/css"  href="assets/css/estilos.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="assets/css/ve_estilos.css" media="screen">	
     <script>
        //Validar
    </script>
</head>
<body>
	<header id='header'>
        <?php echo $encab; ?>
	</header>
    <main>

    <form action="" method="post" class="cont-baj">

        <div class='cont-btn'>
            <input type='submit' class='btn-enviar' name='aceptar' id='aceptar' title='aceptar' value='Aceptar'> <br>
        </div>
	</form>
		
	</main>
</body>
</html>