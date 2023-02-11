<?php 
    include "encabezado.php";
    if (!perfil_valido(1)) {
        header("location:index.php");
        exit;
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
                if (ev.target.matches("#alta-subcategoria")){
                    window.location.href="veSubcategoriaAlta.php";
                }
                else if (ev.target.matches("#baja-subcategoria")){
                    window.location.href="veSubcategoriaBaja.php";
                }
                else if (ev.target.matches("#modificar-subcategoria")){
                    window.location.href="veSubcategoriaModif.php";
                }
            });

        }); 
    </script>
    <style>
        #main{
            height:auto;
        }

        .cont h2{
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
        <div class="cont">
            <h2>SUBCATEGORÍAS</h1>
            <button class="btn hover" id="alta-subcategoria">ALTA</button>
            <button class="btn hover" id="baja-subcategoria">BAJA</button>
            <button class="btn hover" id="modificar-subcategoria">MODIFICACIÓN</button>
        </div>
    </main>

</body>
</html>