<?php 
    include("encabezado.php");
    include_once('funciones.php');

    if (!perfil_valido(1)) {
        header("location:index.php");
    }

    $lista = obtenerSubcategorias();

    $form = " <form class='cont' action='veFuncSubcategoriaBaja' enctype='multipart/form-data'>     
                <label for='subcategoria' class=''>Subcategoría</label>
                $lista
                
                <input type='submit' class='btn' name='bEliminarSubcat' id='bEliminarSubcat' title='Eliminar subcategoría' value='Eliminar subcategoría'>    
            ";

            if (isset($_GET['elim'])){
                $form .= "<div class='contenedor' id='error'>
                             <p> ¡Se ha eliminado la subcategoría con éxito! </p>
                          </div>
                ";
            }
            else if (isset($_GET['error'])){
                $form .="<div class='contenedor' id='error'>
                            <p> Error: los datos ingresados no son correctos, reintente por favor </p>
                        </div>
                ";
            }

    $form .= "</form>
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

        .btn{
            margin:20px 0;
        }

        select{
            font-size: 1.1rem;
        }

    </style>
</head>
<body>

    <header id='header'>
        <?= $encab; ?>
	</header>

    <main id='main'>
        <?= $form; ?>
    </main> 
    
</body>
</html>