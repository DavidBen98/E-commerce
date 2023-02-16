<?php 
    include "encabezado.php";

    if (!perfil_valido(1)) {
        header("location:index.php");
        exit;
    }

    $subcategorias = obtener_subcategorias();

    $formulario = " 
        <form class='cont' method='POST' action='../controlador/veFuncSubcategoriaBaja.php' onsubmit='return validarBajaSubategoria()' enctype='multipart/form-data'>     
            <label for='subcategoria'>Subcategoría</label>
            $subcategorias
            
            <input type='submit' class='btn' name='btn-eliminar-subcategoria' id='btn-eliminar-subcategoria' title='Eliminar subcategoría' value='Eliminar subcategoría'>    
    ";

    if (isset($_GET["elim"])){
        $formulario .= "
            <div class='contenedor mensaje' id='mensaje'>
                <p> ¡Se ha eliminado la subcategoría con éxito! </p>
            </div>
        ";
    }
    else if (isset($_GET["error"])){
        $formulario .="
            <div class='contenedor mensaje' id='mensaje'>
                <p> Error: los datos ingresados no son correctos, reintente por favor </p>
            </div>
        ";
    }

    $formulario .= "</form>";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="../js/funciones.js"></script>
    <script>
        document.addEventListener ("DOMContentLoaded", () => {
            let subcategoria = document.getElementsByClassName ("select-subcategoria")[0];
            subcategoria.setAttribute("id", "subcategoria");
        });
    </script>
    <link rel="icon" type="image/png" href="../images/iconos/logo_sitio.png">
    <link type="text/css"  href="../assets/css/estilos.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../assets/css/ve_estilos.css" media="screen">
    <title>Muebles Giannis - Las mejores marcas</title>
    <style>
        .cont{
            width:40%;
            height: auto;
            justify-content:center;
        }

        .cont input, .cont label, .cont select{
            width:100%;
            height:40px;
            text-align:center;
            margin-bottom: 10px;
        }

        .cont label{
            font-size: 1.3rem;
        }

        .btn{
            margin:20px 0;
        }

        select{
            font-size: 1.1rem;
        }

        #mensaje, .mensaje{
            background-color: black;
            color : white;
            margin-top : 20px;
            margin-bottom : 20px;
            padding : 10px;
            border-radius : .5rem;
            text-align : center;
        }
    </style>
</head>
<body>

    <header id="header">
        <?= $encabezado; ?>
	</header>

    <main id="main">
        <?= $formulario; ?>
    </main> 
    
</body>
</html>