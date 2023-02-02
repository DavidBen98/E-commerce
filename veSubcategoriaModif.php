<?php 
    include("encabezado.php");
    include ("inc/conn.php");
    include_once('funciones.php');

    if (!perfil_valido(1)) {
        header("location:index.php");
    }

    $lista = obtenerCategorias();

    $subcategorias = obtenerSubcategorias();
    
    $formulario = "
        <h1 style='width:100%;text-align:center;'>Modificar subcategoría</h1>
        <div style='width:100%; display:flex; justify-content:center; margin-bottom: 20px;'>                
            <form action='server/veFuncSubcategoriaUbicacion.php' onsubmit='return validarModUbiSubcategoria()' id='formUbicacion' method='post' class='cont'>
                <h2 style='text-align:center; margin: auto;'>Ubicación</h2>

                <label for='subcategoria' class='' style='width:80%; text-align:center; font-size:1.3rem; padding-top: 10px;'>Subcategoría a modificar</label>
                $subcategorias

                <label for='categoria' class='' style='width:80%; text-align:center; font-size:1.3rem;'>
                    Nueva ubicación
                </label>
                $lista

                <div class='contenedor' id='ubicacion'>
                    <input type='submit' name='ubicacion' id='bUbicacion' class='btn btn-enviar' title='' value='Modificar ubicación'>
                </div>
    ";

    if (isset($_GET['modifU'])){
        $formulario .= "
            <div class='contenedor' id='elim'>
                <p>¡Se ha modificado el producto de manera exitosa!</p>
            </div>
        ";
    }
    else if (isset($_GET['errorU'])){
        $formulario .="
            <div class='contenedor' id='error'>
                <p>Error: los datos ingresados no son correctos, reintente por favor</p>
            </div>
        ";
    }

    $formulario .="
        </form>

        <form action='server/veFuncSubcategoriaModif.php' onsubmit='return validarModCarSubcategoria()' id='formCaracteristicas' method='post' enctype='multipart/form-data' class='cont'>
            <h2 style='text-align:center; margin: auto;'>Características</h2>
        
            <label for='subcategoria' class='' style='width:80%; text-align:center; font-size:1.3rem; padding-top: 10px;'>Subcategoría a modificar</label>
            $subcategorias
        
            <div class='contenedor'>
                <div class='cont-check'>
                    <input type='checkbox' id='modNombre' name='modNombre' value='Modificar nombre'>
                    <label for='nombre' class=''> Modificar nombre </label>
                </div>
                <input type='text' class='form-control' name='nombre' id='nombre' title='Nombre' value=''>
            </div>

            <div style='border:1px solid #000; padding: 5px; margin: 20px 0; width: 100%;'>
                <p style='text-align:center; margin: 5px;'>Imagen actual </p>
                <div style='display:flex; justify-content:center;'>
                <img src='' class='img-cat' id='img-cat' alt='Imagen categoría'> 
                </div>
            </div>

            <div class='archivo'>
                <div class='cont-check'>
                    <input type='checkbox' id='modImagen' name='modImagen' value='Modificar imagen'>
                    <label for='nombre' class=''> Modificar imagen </label>
                </div>
                <input type='file' class='form-control' id='imagen' aria-label='Upload'>           
            </div> 

            <div class='contenedor'>      	 
                <input type='submit' class='btn' name='bAceptar' id='bAceptar' title='bAceptar' value='Modificar características'>     	 
            </div>
    ";

    if (isset($_GET['modifC'])){
        $formulario .= "
            <div class='contenedor' id='elim'>
                <p>¡Se ha modificado el producto de manera exitosa!</p>
            </div>
        ";
    }
    else if (isset($_GET['errorC'])){
        $formulario .="
            <div class='contenedor' id='error'>
                <p>Error: los datos ingresados no son correctos, reintente por favor</p>
            </div>
        ";
    }
                
    $formulario .="
            </form>
        </div>
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
      <script>
		document.addEventListener('DOMContentLoaded', () => {
            let modNombre = document.getElementById('modNombre');
            let modImagen = document.getElementById('modImagen');
            let subcategoria = document.getElementsByName('subcategoria')[1];

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

            subcategoria.addEventListener('change', () => {
                actualizarImagen();
            });

            function actualizarImagen (){
                let subcat = subcategoria.options[subcategoria.selectedIndex].value;
                let img = document.getElementById('img-cat');

                $.ajax ({
                    type: "POST",
                    url: "server/veObtenerImagen.php",
                    data: "subcategoria=" + subcat ,
                    success: function (r){
                        img.setAttribute('src', r);
                    }
                });
            }	

            let idSubategoria = getQueryVariable('subcategoria');
            if (idSubategoria != false){
                for (let i = 0; i < subcategoria.options.length; i++) {
                    if (subcategoria.options[i].value == idSubcategoria) {
                        subcategoria.options[i].selected = true;
                        break;
                    }
                }

                actualizarImagen();
            }
        });
	</script>
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