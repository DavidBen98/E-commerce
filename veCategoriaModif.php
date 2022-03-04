<?php 
    include("encabezado.php");
    include ("inc/conn.php");
    if (!perfil_valido(1)) {
        header("location:index.php");
    }

    $lista = obtenerCategorias();
    
    $formulario = "  <form action='veFuncCategoriaModif.php' method='post' enctype='multipart/form-data' class='cont'>
                    <h1 style='width:100%;text-align:center;'>Modificar categoría</h1>
                                    
                    <label for='categoria' class='' style='width:80%; text-align:center; font-size:1.3rem;'>
                        Categoría
                    </label>
                    $lista
                    <div class='contenedor'>
                        <label for='nombre'class=''>Nuevo nombre</label>
                        <input type='text' class='form-control' name='nombre' id='nombre' title='Nombre' value=''>
                    </div>

                    <div class='archivo'>
                        <input type='file' class='form-control' id='imagen' aria-label='Upload'>           
                    </div> 

                    <div class='contenedor'>      	 
                        <input type='submit' class='btn' name='bAceptar' id='bAceptar' title='bAceptar' value='Modificar categoría'>     	 
                    </div>
            ";

            if (isset($_GET['modif'])){
                $formulario .= "<div class='contenedor' id='error'>
                             <p> ¡Se ha modificado la categoría con éxito! </p>
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

        #categoria{
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