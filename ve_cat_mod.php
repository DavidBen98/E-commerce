<?php 
    include("encabezado.php");
    include ("inc/conn.php");
    if (!perfil_valido(1)) {
        header("location:index.php");
    }

        $lista = obtenerCategorias();
      
        $form = "  <form action='eventosCat.php' method='post' enctype='multipart/form-data' class='cont'>
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
                </form>
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
        <?php echo $encab; ?>
	</header>

    <main id='main'>
        <?php echo $form; ?>
    </main> 

</body>
</html>