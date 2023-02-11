<!DOCTYPE html>
<?php  
    include "../controlador/config.php";
    include "encabezado.php"; 

    if (!perfil_valido(1)) {
        header("location:index.php");
        exit;
    }
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../images/iconos/logo_sitio.png">
    <link type="text/css"  href="../assets/css/estilos.css" rel="stylesheet"/>
    <link type="text/css"  href="../assets/css/ve_estilos.css" rel="stylesheet"/>
    <title>Muebles Giannis - Las mejores marcas</title>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.addEventListener("click", ev => {
                if (ev.target.matches("#alta-productos")){
                    window.location.href="veProductoAlta.php";
                }
                else if (ev.target.matches("#baja-productos")){
                    window.location.href="veProductoBaja.php";
                }
                else if (ev.target.matches("#modificar-productos")){
                    window.location.href="veProductoBaja.php?modif=true";
                }
            });   
        });
    </script>
    <style>
        .cont{
            background: rgba(147, 81, 22,0.2);
        }

        .cont h1{
            text-align:center; 
            width:100%;
        }
    </style>
</head>

<body id="body">
    <header id="header">
		<?= $encabezado; ?>
	</header>

    <main id="main">
        <div class="cont">
            <h1>PRODUCTOS</h1>
            <button class="btn hover" id="alta-productos">ALTA</button>
            <button class="btn hover" id="baja-productos">BAJA</button>
            <button class="btn hover" id="modificar-productos">MODIFICACIÓN</button>
        </div>      
    </main>
    
</body>
</html>