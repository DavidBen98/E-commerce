<?php 
    include("encabezado.php");
    if (!perfil_valido(1)) {
        header("location:index.php");
    }
?>
<!DOCTYPE html>
<?php  
	$form="

	";
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css"  href="assets/css/estilos.css" rel="stylesheet"/>
    <link type="text/css"  href="assets/css/ve_estilos.css" rel="stylesheet"/>
    <title>Muebles Giannis - Las mejores marcas</title>
     <script>
        document.addEventListener('DOMContentLoaded', () => {

            document.addEventListener('click', ev => {
                if (ev.target.matches('#caracteristicas')){
                    window.location.href = 've_subc_mod_caract.php';
                }
                else if (ev.target.matches('#ubicacion')){
                    window.location.href = 've_subc_mod_ubicacion.php';
                }
            });

        });
    </script>
    <style>
        .cont{
            width:40%;
        }
    </style>
</head>
<body>
	<header id='header'>
        <?php echo $encab; ?>
	</header>
    <main id='main'>
    <div class='cont'>
        <input type='button' id='caracteristicas' class='btn btn-enviar'  style='width:auto;' value='Modificar características'>
        <input type='button' id='ubicacion' class='btn btn-enviar' id='Agregar' title='Agregar' value='Modificar ubicación'>     
	</div>
			
	</main>
</body>
</html>