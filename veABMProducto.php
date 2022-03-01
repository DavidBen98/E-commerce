<!DOCTYPE html>
<?php  
    include ('config.php');
    include ("encabezado.php"); 

    if (!perfil_valido(1)) {
        header("location:index.php");
    }
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
                if (ev.target.matches('#altaProductos')){
                    window.location.href='veProductoAlta.php';
                }
                else if (ev.target.matches('#bajaProductos')){
                    window.location.href='veProductoBaja.php';
                }
                else if (ev.target.matches('#modProductos')){
                    window.location.href='veProductoBaja.php?modif=true';
                }
            });   
        });
    </script>
    <style>
        .cont{
            background: rgba(147, 81, 22,0.2);
        }
    </style>
</head>

<body id='body'>
    <header id='header'>
		<?= $encab; ?>
	</header>

    <main id='main'>
        <div class='cont'>
            <h1 style='text-align:center; width:100%;'>PRODUCTOS</h1>
            <button class="btn hover" id='altaProductos'>ALTA</button>
            <button class="btn hover" id='bajaProductos'>BAJA</button>
            <button class="btn hover" id='modProductos'>MODIFICACIÓN</button>
        </div>
    </main>
</body>
</html>