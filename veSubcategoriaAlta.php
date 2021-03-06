<?php 
    include("encabezado.php");
    include_once('funciones.php');

    if (!perfil_valido(1)) {
        header("location:index.php");
    }

    $lista = obtenerCategorias();

    $formulario = "<form class='cont' action='veFuncSubcategoriaAlta.php' enctype='multipart/form-data'>     
                <label for='nombre'class='col-sm-2 form-label'>Nombre de subcategoría</label>
                <input type='text' name='tNombre' id='nombre' title='Ingrese el nombre de la subcategoria' value=''>  
                
                <label for='categoria'class='col-sm-2 form-label'>Categoría</label>
                $lista
                
                <div class='archivo'>
                    <input type='file' class='form-control' id='imagen' aria-label='Upload'>           
                </div>   
                
                <input type='submit' class='btn' name='bAgregarSubCat' id='bAgregarSubCat' title='Agregar subcategoria' value='Agregar subcategoria'>    
            ";
            
            if (isset($_GET['alta'])){
                $formulario .= "<div class='contenedor' id='error'>
                             <p> ¡Se ha añadido la subcategoría con éxito! </p>
                          </div>
                ";
            }
            else if (isset($_GET['error'])){
                $formulario .="<div class='contenedor' id='error'>
                            <p> Error: los datos ingresados no son correctos, reintente por favor </p>
                        </div>
                ";
            }

    $formulario .= "</form>
    ";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css"  href="assets/css/estilos.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="assets/css/ve_estilos.css" media="screen">
    <title>Muebles Giannis - Las mejores marcas</title>
    <script>
    </script>
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

        .archivo{
            display:flex;
            justify-content:center;
            width:100%;
            margin:20px;
        }

    </style>
</head>
<body>

    <header id='header'>
        <?= $encabezado; ?>
	</header>

    <main id='main'>
        <?= $formulario; ?>
    </main> 

</body>
</html>