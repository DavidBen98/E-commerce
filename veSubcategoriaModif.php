<?php 
    include("encabezado.php");
    include ("inc/conn.php");
    include_once('funciones.php');

    if (!perfil_valido(1)) {
        header("location:index.php");
    }

    $lista = obtenerCategorias();

    $subcategorias = obtenerSubcategorias();
    
    $formulario = "<h1 style='width:100%;text-align:center;'>Modificar subcategoría</h1>
             <div style='width:100%; display:flex; justify-content:center; margin-bottom: 20px;'>                
                <form action='veFuncSubcategoriaUbicacion.php' id='formUbicacion' method='post' class='cont'>
                    <h2 style='text-align:center; margin: auto;'>Ubicación</h2>

                    <label for='subcategoria' class='' style='width:80%; text-align:center; font-size:1.3rem;'>Subcategoría</label>
                    $subcategorias

                    <label for='categoria' class='' style='width:80%; text-align:center; font-size:1.3rem;'>
                        Nueva ubicación
                    </label>
                    $lista

                    <div class='contenedor' id='ubicacion'>
                        <input type='submit' name='ubicacion' id='bUbicacion' class='btn btn-enviar' title='' value='Modificar ubicación'>
                    </div>";

                    if (isset($_GET['modifU'])){
                        $formulario .= "
                        <div class='contenedor' id='elim'>
                            <p>¡Se ha modificado el producto de manera exitosa!</p>
                        </div>";
                    }
                    else if (isset($_GET['errorU'])){
                        $prod .="
                        <div class='contenedor' id='error'>
                            <p>Error: los datos ingresados no son correctos, reintente por favor</p>
                        </div>";
                    }

        $formulario .="</form>

                <form action='veFuncSubcategoriaCarac.php' id='formCaracteristicas' method='post' enctype='multipart/form-data' class='cont'>
                    <h2 style='text-align:center; margin: auto;'>Características</h2>
                
                    <label for='subcategoria' class='' style='width:80%; text-align:center; font-size:1.3rem;'>Subcategoría</label>
                    $subcategorias
                
                    <div class='contenedor'>
                        <label for='nombre'class=''>Nuevo nombre</label>
                        <input type='text' class='form-control' name='nombre' id='nombre' title='Nombre' value=''>
                    </div>

                    <div class='archivo'>
                        <input type='file' class='form-control' id='imagen' aria-label='Upload'>           
                    </div> 

                    <div class='contenedor'>      	 
                        <input type='submit' class='btn' name='bAceptar' id='bAceptar' title='bAceptar' value='Modificar características'>     	 
                    </div>";

                    if (isset($_GET['modifC'])){
                        $formulario .= "
                        <div class='contenedor' id='elim'>
                            <p>¡Se ha modificado el producto de manera exitosa!</p>
                        </div>";
                    }
                    else if (isset($_GET['errorC'])){
                        $prod .="
                        <div class='contenedor' id='error'>
                            <p>Error: los datos ingresados no son correctos, reintente por favor</p>
                        </div>";
                    }
                    
            $formulario .="</form>
            </div>
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
		//Validar
	</script>
    <style>
        #main{
            height: auto;
        }

        .cont{
            width:40%;
            justify-content:center;
            height: auto;
        }

        #categoria, #subcategoria{
            width:80%;
            text-align:center;
            margin:10px;
        }

        .archivo{
            display:flex;
            justify-content:center;
            width:100%;
            margin:20px;
        }

        .contenedor input{
            height:40px;
        }

        #formUbicacion{
            margin-right:20px;
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