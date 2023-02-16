<?php 
    include "encabezado.php";
    if (!perfil_valido(1)) {
        header("location:index.php");
        exit;
    }

    $formulario = "
        <form action='../controlador/veFuncCategoriaAlta.php' onsubmit='return validarAltaCategoria()' enctype='multipart/form-data' class='cont' method='post'>            
            <h1>Alta categoría</h1>

            <div class='contenedor'>
                <label for='nombre'>Nombre de categoría</label>
                <input type='text' class='form-control' name='nombre' id='nombre' title='Nombre' value=''> 
            </div>

            <div class='archivo'>
                <label for='imagen'>Imagen de portada</label>
                <input type='file' class='form-control' id='imagen' name='imagen' aria-label='Upload'>           
            </div>    

            <div class= 'agregar'>
                <input type='submit' class='btn btn-secondary btn-lg' name='btn-aceptar' id='btn-aceptar' title='btn-aceptar' value='Agregar Categoría'>
            </div>
    ";
            
    if (isset($_GET["alta"])){
        $formulario .= "
            <div class='contenedor mensaje' id='mensaje'>
                <p> ¡Se ha añadido la categoría con éxito! </p>
            </div>
        ";
    }
    else if (isset($_GET["error"])){
        $error = $_GET["error"];

        $formulario .= "
            <div class='contenedor mensaje' id='mensaje'>
        ";

        if ($error === "1"){
            $formulario .= "
                <p> Error: ha ocurrido un inconveniente al subir la imagen, 
                    verifique que la extensión es .png, .jpg o .jpeg y 
                    reintente en un momento por favor. 
                </p>
            ";
        } else if ($error === "2"){
            $formulario .= "
                <p> Error: el nombre ingresado ya existe, reintente con otro por favor. </p>
            ";
        }else if ($error === "3"){
            $formulario .= "
                <p> Error: el nombre ingresado no cumple con los requisitos. </p>
            ";
        } else if ($error === "4"){
            $formulario .= "
                <p> Error: seleccione una imagen por favor. </p>
            ";
        }

        $formulario .= "
            </div>
        ";
    }

    $formulario .= "</form>";

    $categorias_inactivas = obtener_categorias_inactivas();

    $inactivas = "
        <form class='cont' method='POST' action='../controlador/veFuncCategoriaAlta.php' onsubmit='' enctype='multipart/form-data'>     
            <label for='nombre-inactivo' class='col-sm-2 form-label'>Reactivar subcategoría</label>
            $categorias_inactivas
            <div class= 'agregar'>
                <input type='submit' class='btn' name='bAgregarCat' title='Reactivar categoria' value='Reactivar categoria'>    
            </div>
    ";

    if (isset($_GET["reactivacion"])){
        $inactivas .= "
            <div class='contenedor mensaje' id='reactivacion'>
                <p> Exito <p/>
            </div>
        ";
    }

    $inactivas .= "
        </form>
    ";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="../js/funciones.js"></script>
    <link rel="icon" type="image/png" href="../images/iconos/logo_sitio.png">
    <link type="text/css"  href="../assets/css/estilos.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../assets/css/ve_estilos.css" media="screen">
    <title>Muebles Giannis - Las mejores marcas</title>
    <style>
        .cont{
            width:40%;
            margin: 1px;
            height: auto;
            justify-content:center;
        }

        .cont input, .cont label, .cont select{
            width:100%;
            height:40px;
            text-align:center;
            margin-bottom: 10px;
        }

        .btn{
            margin:auto;
            width: 100%;
        }

        .archivo{
            display:flex;
            justify-content:center;
            flex-wrap:wrap;
            width:100%;
            margin:20px;
        }

        .archivo input{
            width: auto;
        }

        .contenedor label{
            height:40px;
            font-size: 1.2rem;
        }

        .agregar {
            margin: auto;
            display: flex;
            justify-content:center;
            flex-wrap: wrap;
            width: 100%;
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

        form h1{
            width:100%;
            text-align:center;
        }
    </style>
</head>
<body>

    <header id="header">
        <?= $encabezado; ?>
	</header>

    <main id="main">  
        <?= $formulario; ?> 
        <?= $inactivas; ?>
    </main>

</body>
</html>