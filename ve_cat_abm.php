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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css"  href="assets/css/estilos.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="assets/css/ve_estilos.css" media="screen">
    <title>Muebles Giannis - Las mejores marcas</title>
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            document.addEventListener('click', ev => {
                if (ev.target.matches('#altaCat')){
                    window.location.href='ve_cat_alta.php';
                }
                else if (ev.target.matches('#bajaCat')){
                    window.location.href='ve_cat_baja.php';
                }
                else if (ev.target.matches('#modCat')){
                    window.location.href='ve_cat_mod.php';
                }
                else if (ev.target.matches('#altaSubcat')){
                    window.location.href='ve_subc_alta.php';
                }
                else if (ev.target.matches('#bajaSubcat')){
                    window.location.href='ve_subc_baja.php';
                }
                else if (ev.target.matches('#modSubcat')){
                    window.location.href='ve_subc_mod.php';
                }
            });

        }); 
    </script>
    <style>
        #main{
            height:auto;
        }
    </style>
</head>
<body>
    <header id='header'>
        <?php echo $encab; ?>
	</header>
    <main id='main'>

        <div class='cont cat'>
            <h1 style='text-align:center; width:100%;'>CATEGORÍAS</h1>
            <button class='btn hover' id='altaCat'>ALTA</button>
            <button class='btn hover' id='bajaCat'>BAJA</button>
            <button class='btn hover' id='modCat'>MODIFICACIÓN</button>
        </div>

        <div class='cont subc'>
            <h2 style='text-align:center;  width:100%;'>SUBCATEGORÍAS</h1>
            <button class='btn hover' id='altaSubcat'>ALTA</button>
            <button class='btn hover' id='bajaSubcat'>BAJA</button>
            <button class='btn hover' id='modSubcat'>MODIFICACIÓN</button>
        </div>

    </main>
</body>
</html>