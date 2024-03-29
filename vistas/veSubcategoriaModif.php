<?php 
    include "encabezado.php";
    include "../inc/conn.php";

    if (!perfil_valido(1)) {
        header("location:index.php");
        exit;
    }

    $categorias = obtener_categorias();
    $subcategorias = obtener_subcategorias();
    
    $formulario = "
        <h1 id='modSubcategoria'>Modificar subcategoría</h1>
        <div class='div-cont'>                
            <form action='../controlador/veFuncSubcategoriaUbicacion.php' onsubmit='return validarModUbiSubcategoria()' id='form-ubicacion' method='post' class='cont'>
                <h2>Ubicación</h2>

                <label for='subcategoria-ubicacion' class='label-subcategoria'>Subcategoría a modificar</label>
                $subcategorias

                <label for='categoria' class='label-categoria'>
                    Nueva ubicación
                </label>
                $categorias

                <div class='contenedor' id='ubicacion'>
                    <input type='submit' name='ubicacion' id='btn-ubicacion' class='btn btn-enviar' title='' value='Modificar ubicación'>
                </div>
    ";

    if (isset($_GET["modifU"])){
        $formulario .= "
            <div class='contenedor mensaje' id='mensaje'>
                <p>¡Se ha modificado el producto de manera exitosa!</p>
            </div>
        ";
    }
    else if (isset($_GET["errorU"])){
        $formulario .="
            <div class='contenedor mensaje' id='mensaje'>
                <p>Error: los datos ingresados no son correctos, reintente por favor</p>
            </div>
        ";
    }

    $formulario .="
        </form>

        <form action='../controlador/veFuncSubcategoriaModif.php' onsubmit='return validarModCarSubcategoria()' id='form-caracteristicas' method='post' enctype='multipart/form-data' class='cont'>
            <h2>Características</h2>
        
            <label for='subcategoria-caract' class='label-subcategoria'>Subcategoría a modificar</label>
            $subcategorias
        
            <div class='contenedor'>
                <div class='cont-check'>
                    <input type='checkbox' id='modificar-nombre' name='modificar-nombre' value='Modificar nombre'>
                    <label for='modificar-nombre'> Modificar nombre </label>
                </div>
                <label for='nombre' style='display:none;'>Nombre</label>
                <input type='text' class='form-control' name='nombre' id='nombre' title='Nombre' value=''>
            </div>

            <div class='img-actual'>
                <p>Imagen actual </p>
                <div>
                    <img src='../images/categorias/notfound.jpg' class='img-cat' id='img-cat' alt='Imagen categoría'> 
                </div>
            </div>

            <div class='archivo'>
                <div class='cont-check'>
                    <input type='checkbox' id='modificar-imagen' name='modificar-imagen' value='Modificar imagen'>
                    <label for='modificar-imagen'> Modificar imagen </label>
                </div>
                <input type='file' class='form-control' id='imagen' name='imagen' aria-label='Upload'>           
            </div> 

            <div class='contenedor'>      	 
                <input type='submit' class='btn' name='btn-aceptar' id='btn-aceptar' title='btn-aceptar' value='Modificar características'>     	 
            </div>
    ";

    if (isset($_GET["modif"])){
        $formulario .= "
            <div class='contenedor mensaje' id='mensaje'>
                <p>¡Se ha modificado el producto de manera exitosa!</p>
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
                <p> 
                    Debe modificar al menos una característica
                </p>
            ";
        } else if ($error === "2"){
            $formulario .= "
                <p> Error: debe completar el campo nombre. </p>
            ";
        }else if ($error === "3"){
            $formulario .= "
                <p> Error: debe seleccionar una imagen por favor. </p>
            ";
        } else if ($error === "4"){
            $formulario .= "
                <p> Error: sucedió un error al cargar la imagen, reintente en unos momentos por favor. </p>
            ";
        } else if ($error === "5"){
            $formulario .= "
                <p> Error: el nombre ingresado ya existe, reintente con otro por favor. </p>
            ";
        }

        $formulario .= "
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
	<script src="../js/jquery-3.3.1.min.js"></script>
	<script src="../js/funciones.js"></script>
    <link rel="icon" type="image/png" href="../images/iconos/logo_sitio.png">
    <link type="text/css"  href="../assets/css/estilos.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../assets/css/ve_estilos.css" media="screen">
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

        #categoria, .select-subcategoria{
            width:80%;
            text-align:center;
            margin:10px;
        }

        .label-subcategoria, .label-categoria{
            width:80%; 
            text-align:center; 
            font-size:1.3rem; 
            padding-top: 4%;
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

        .img-actual{
            border:1px solid #000; 
            padding: 5px; 
            margin: 20px 0; 
            width: 100%;
        }

        .img-actual div{
            display:flex; 
            justify-content:center;
        }

        .img-actual p{
            text-align:center; 
            margin: 5px;
        }

        #form-ubicacion{
            margin-right:20px;
            height: 400px;
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

        #mensaje, .mensaje{
            background-color: black;
            color : white;
            margin-top : 20px;
            margin-bottom : 20px;
            padding : 10px;
            border-radius : .5rem;
            text-align : center;
        }

        form h2{
            text-align:center; 
            margin: auto;
        }

        #modSubcategoria{
            width:100%;
            text-align:center;
        }

        .div-cont{
            display:flex; 
            justify-content:center; 
            width:100%; 
            margin-bottom: 20px;
        }
    </style>
      <script>
		document.addEventListener("DOMContentLoaded", () => {
            let modNombre = document.getElementById("modificar-nombre");
            let modImagen = document.getElementById("modificar-imagen");
            let subcategoria = document.getElementsByName("subcategoria");

            //VALIDATOR W3: se establece como id para que funcionen los for de los labels 
            subcategoria[0].setAttribute("id", "subcategoria-ubicacion");
            subcategoria[1].setAttribute("id", "subcategoria-caract");

            actualizarImagen();

            modNombre.addEventListener("change", () => {
                let checked = modNombre.checked;

                let nombre = document.getElementById("nombre");

                if (checked){
                    nombre.style.display = "block";
                } else {
                    nombre.style.display = "none";
                }
            });

            modImagen.addEventListener("change", () => {
                let checked = modImagen.checked;

                let imagen = document.getElementById("imagen");

                if (checked){
                    imagen.style.display = "block";
                } else {
                    imagen.style.display = "none";
                }
            });

            subcategoria[1].addEventListener("change", () => {
                actualizarImagen();
            });

            function actualizarImagen (){
                let subcat = subcategoria[1].options[subcategoria[1].selectedIndex].value;
                let img = document.getElementById("img-cat");

                $.ajax ({
                    type: "POST",
                    url: "../controlador/veObtenerImagen.php",
                    data: "subcategoria=" + subcat ,
                    success: function (r){
                        img.setAttribute("src", r);
                    }
                });
            }	

            let idSubcategoria = obtenerVariable("subcategoria");
            if (idSubcategoria != false){
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
    <header id="header">
        <?= $encabezado; ?>
	</header>

    <main id="main">
        <?= $formulario; ?>
    </main> 

</body>
</html>