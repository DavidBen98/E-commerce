<?php 
    include "encabezado.php";
    if (!perfil_valido(1)) {
        header("location:index.php");
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../images/iconos/logo_sitio.png">
    <link type="text/css"  href="../assets/css/estilos.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="../assets/css/ve_estilos.css" media="screen">
    <title>Muebles Giannis - Las mejores marcas</title>
    <script>
        document.addEventListener("DOMContentLoaded", () => {

            document.addEventListener("click", ev => {
                if (ev.target.matches("#altaCat")){
                    window.location.href="veCategoriaAlta.php";
                }
                else if (ev.target.matches("#bajaCat")){
                    window.location.href="veCategoriaBaja.php";
                }
                else if (ev.target.matches("#modCat")){
                    window.location.href="veCategoriaModif.php";
                }
            });

        }); 
    </script>
    <style>
        #main{
            height:auto;
        }

        .cont h1{
            text-align:center; 
            width:100%;
        }
    </style>
</head>
<body>
    
    <header id="header">
        <?= $encabezado; ?>
	</header>

    <main id="main">
        <div class="cont cat">
            <h1>CATEGORÍAS</h1>
            <button class="btn hover" id="altaCat">ALTA</button>
            <button class="btn hover" id="bajaCat">BAJA</button>
            <button class="btn hover" id="modCat">MODIFICACIÓN</button>
        </div>
    </main>

</body>
</html>