<?php 
    include("encabezado.php");
    include ("inc/conn.php");
    if (!perfil_valido(1)) {
        header("location:index.php");
    }

    $lista = obtenerCategorias();

    $formulario = "  
        <form action='veFuncCategoriaModif.php' onsubmit='return validarModificacionCategoria()' method='post' enctype='multipart/form-data' class='cont'>
            <h1 style='width:100%;text-align:center;'>Modificar categoría</h1>
                            
            <label for='categoria' class='' style='width:80%; text-align:center; font-size:1.3rem;'>
                Categoría
            </label>
            $lista
            
            <div class='contenedor'>
                <div class='cont-check'>
                        <input type='checkbox' id='modNombre' name='modNombre' value='Modificar nombre'>
                    <label for='nombre' class=''> Modificar nombre </label>
                </div>
                <input type='text' class='form-control' name='nombre' id='nombre' placeholder='Ejemplo: Jardin' title='Nombre' value=''>
            </div>

            
            <div style='border:1px solid #000; padding: 5px; margin: 20px 0; width: 100%;'>
                <p style='text-align:center; margin: 5px;'>Imagen actual </p>
                <div style='display:flex; justify-content:center;'>
                <img src='' class='img-cat' id='img-cat' alt='Imagen categoría'> 
                </div>
            </div>

            <div class='archivo' id='archivo'>
                <div class='cont-check'>
                    <input type='checkbox' id='modImagen' name='modImagen' value='Modificar imagen'>
                    <label for='nombre' class=''> Modificar imagen </label>
                </div>
                <input type='file' name='imagen' class='form-control' id='imagen' aria-label='Upload'>          
            </div> 

            <div class='contenedor'>      	 
                <input type='submit' class='btn' name='bAceptar' id='bAceptar' title='bAceptar' value='Modificar categoría'>     	 
            </div>
    ";

    if (isset($_GET['modif'])){
        $formulario .= "
            <div class='contenedor' id='mensaje'>
                <p> ¡Se ha modificado la categoría con éxito! </p>
            </div>
        ";
    } else if (isset($_GET['error'])){
        $error = $_GET['error'];
        $formulario .="
            <div class='contenedor' id='mensaje'>
        ";
        if ($error === '1'){
            $formulario .="
                <p> Error: debe modificar al menos un campo </p>
            ";
        } else if ($error === '2'){
            $formulario .="
                <p> Error: rellene correctamente el campo nombre por favor. </p>
            ";
        } else if ($error === '3'){
            $nombre = isset($_GET['nombre']);

            if ($nombre){
                $formulario .="
                    <p> Se modificó correctamente el nombre </p>
                ";
            }

            $formulario .="
                <p> Error: seleccione una imagen por favor </p>
            ";
        } else if ($error === '4'){
            //No hace falta en este momento preguntar por el error 4 en particular,
            //pero se hace por si se necesita agregar errores en el futuro
            $formulario .="
                <p> Error: ha ocurrido un error al subir la imagen </p>
            ";
        }     
        $formulario .="
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
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/funciones.js"></script>
    <link type="text/css"  href="assets/css/estilos.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="assets/css/ve_estilos.css" media="screen">
    <title>Muebles Giannis - Las mejores marcas</title>
    <script>
		document.addEventListener('DOMContentLoaded', () => {
            let modNombre = document.getElementById('modNombre');
            let modImagen = document.getElementById('modImagen');
            let categoria = document.getElementById('categoria');

            actualizarImagen();

            modNombre.addEventListener('change', () => {
                let checked = modNombre.checked;

                let nombre = document.getElementById('nombre');

                if (checked){
                    nombre.style.display = 'block';
                } else {
                    nombre.style.display = 'none';
                }
            });

            modImagen.addEventListener('change', () => {
                let checked = modImagen.checked;

                let imagen = document.getElementById('imagen');

                if (checked){
                    imagen.style.display = 'block';
                } else {
                    imagen.style.display = 'none';
                }
            });

            categoria.addEventListener('change', () => {
                actualizarImagen();
            });

            function actualizarImagen (){
                let cat = categoria.options[categoria.selectedIndex].value;
                let img = document.getElementById('img-cat');

                $.ajax ({
                    type: "POST",
                    url: "veObtenerImagen.php",
                    data: "categoria=" + cat ,
                    success: function (r){
                        img.setAttribute('src', r);
                    }
                });
            }	

            let idCategoria = getQueryVariable('categoria');
            if (idCategoria != false){
                for (let i = 0; i < categoria.options.length; i++) {
                    if (categoria.options[i].value == idCategoria) {
                        categoria.options[i].selected = true;
                        break;
                    }
                }

                actualizarImagen();
            }
        });
	</script>
    <style>
        #main{
            height: auto;
        }

        .cont{
            width:40%;
            justify-content:center;
            height: auto;
            margin-bottom: 20px;
        }

        #categoria{
            width:80%;
            text-align:center;
            margin:10px;
        }

        .archivo{
            display:flex;
            justify-content:center;
            flex-wrap: wrap;
            width:100%;
            /* margin:20px; */
        }

        .archivo label{
            width: 100%;
            text-align:center;
        }

        .contenedor{
            display:flex;
            justify-content:center;
            flex-wrap: wrap;
        }

        .cont-check{
			display:flex;
			justify-content:start;
			align-items: center;
            text-align:start;
			width:50%;
            margin: 20px;
		}

        .contenedor input[type="checkbox"]{
            height: auto;
            width: auto;
        }

        #nombre, #imagen{
            display: none;
        }

        #mensaje{
            color: white;
            padding: 0;
            margin-top: 10px;
        }

        #mensaje p{
            background: #000;
            width: 100%;
            padding: 20px 0;
            text-align:center;
            border-radius: 5px;
            margin: 10px 0 0 0;
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