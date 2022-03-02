<?php 
    include("encabezado.php");
    include ("inc/conn.php");
    include_once ("funciones.php");
    
    if (!perfil_valido(1)) {
        header("location:index.php");
    }
?>
<!DOCTYPE html>
<?php  
    $listas = obtenerCategorias();

	$form=" <form action='veFuncCategoriaBaja.php' method='post' class='cont'>
                <h1 style='width:100%;text-align:center;'>Baja categoría</h1>

                <label for='categoria'>CATEGORÍA</label>
                $listas
                <input type='submit' class='btn btn-enviar' name='eliminar' id='eliminar' title='Eliminar' value='Eliminar categoría'>
            ";

            if (isset($_GET['elim'])){
                $form .= "<div class='contenedor' id='error'>
                             <p> ¡Se ha eliminado la categoría con éxito! </p>
                          </div>
                ";
            }
            else if (isset($_GET['error'])){
                $form .="<div class='contenedor' id='error'>
                            <p> Error: los datos ingresados no son correctos, reintente por favor </p>
                        </div>
                ";
            }

    $form .="</form>		   
	";
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Muebles Giannis - Las mejores marcas</title>
    <link type="text/css"  href="assets/css/estilos.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="assets/css/ve_estilos.css" media="screen">
    <script>
		//Validar
	</script>
    <style>
        .cont{
            width:30%;
            justify-content:center;
            height: auto;
        }

        form label, #categoria{
            width:100%;
            text-align:center;
        }

        #categoria{
            border-radius:5px;
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