<?php 
    include("encabezado.php");
    if (!perfil_valido(1)) {
        header("location:index.php");
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css"  href="assets/css/estilos.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="assets/css/ve_estilos.css" media="screen">
    <title>Muebles Giannis - Las mejores marcas</title>
    <style>
        .cont{
            width:40%;
            height: 250px;
        }

        .btn{
            margin:auto;
        }

        .archivo{
            display:flex;
            justify-content:center;
            width:100%;
            margin:20px;
        }

        .contenedor label{
            height:40px;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <header id='header'>
        <?php echo $encab; ?>
	</header>
    <main id='main'>

        <?php 
            echo "
                <form action='ve_altaCategoria.php' enctype='multipart/form-data' class='cont' method='post'>
                    
                    <div class='contenedor'>
                        <label for='nombre'class=''>Nombre de categoría</label>
                        <input type='text' class='form-control' name='nombre' id='nombre' title='Nombre' value=''> 
                    </div>

                    <div class='archivo'>
                        <input type='file' class='form-control' id='imagen' name='imagen' aria-label='Upload'>           
                    </div>    

                    <input type='submit' class='btn btn-secondary btn-lg' name='bAceptar' id='bAceptar' title='bAceptar' value='Agregar Categoría'>          
                
                </form> 
            "; 
        ?> 

    </main>
</body>
</html>