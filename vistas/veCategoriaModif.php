<?php 
    include "encabezado.php";
    include "../inc/conn.php";
    if (!perfil_valido(1)) {
        header("location:index.php");
        exit;
    }

    $categorias = obtener_categorias();

    $formulario = "  
        <form action='../controlador/veFuncCategoriaModif.php' onsubmit='return validarModificacionCategoria()' method='post' enctype='multipart/form-data' class='cont'>
            <h1>Modificar categoría</h1>
                            
            <label for='categoria' class='label-categoria'>
                Categoría
            </label>
            $categorias
            
            <div class='contenedor'>
                <div class='cont-check'>
                    <input type='checkbox' id='modificar-nombre' name='modificar-nombre' value='Modificar nombre'>
                    <label for='nombre' > Modificar nombre </label>
                </div>
                <input type='text' class='form-control' name='nombre' id='nombre' placeholder='Ejemplo: Jardin' title='Nombre' value=''>
            </div>

            
            <div class='img-actual'>
                <p> Imagen actual </p>
                <div>
                    <img src='../images/categorias/notfound.jpg' class='img-cat' id='img-cat' alt='Imagen categoría'> 
                </div>
            </div>

            <div class='archivo' id='archivo'>
                <div class='cont-check'>
                    <input type='checkbox' id='modificar-imagen' name='modificar-imagen' value='Modificar imagen'>
                    <label for='nombre'> Modificar imagen </label>
                </div>
                <input type='file' name='imagen' class='form-control' id='imagen' aria-label='Upload'>          
            </div> 

            <div class='contenedor'>      	 
                <input type='submit' class='btn' name='btn-aceptar' id='btn-aceptar' title='btn-aceptar' value='Modificar categoría'>     	 
            </div>
    ";

    if (isset($_GET["modif"])){
        $formulario .= "
            <div class='contenedor' id='mensaje'>
                <p> ¡Se ha modificado la categoría con éxito! </p>
            </div>
        ";
    } else if (isset($_GET["error"])){
        $error = $_GET["error"];
        $formulario .="
            <div class='contenedor' id='mensaje'>
        ";
        
        if ($error === "1"){
            $formulario .="
                <p> Error: debe modificar al menos un campo </p>
            ";
        } else if ($error === "2"){
            $formulario .="
                <p> Error: rellene correctamente el campo nombre por favor. </p>
            ";
        } else if ($error === "3"){
            $nombre = isset($_GET["nombre"]);

            if ($nombre){
                $formulario .="
                    <p> Se modificó correctamente el nombre </p>
                ";
            }

            $formulario .="
                <p> Error: seleccione una imagen por favor </p>
            ";
        } else if ($error === "4"){
            $formulario .="
                <p> Error: ha ocurrido un error al subir la imagen </p>
            ";
        } else if ($error === "5"){
            //No hace falta en este momento preguntar por el error 4 en particular,
            //pero se hace por si se necesita agregar errores en el futuro
            $formulario .="
                <p> Error: el nombre ingresado ya existe, reintente con otro por favor. </p>
            ";
        }  

        $formulario .="
            </div>
        ";
    }

    $formulario .= "</form>";
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
    <script>
		document.addEventListener("DOMContentLoaded", () => {
            let modNombre = document.getElementById("modificar-nombre");
            let modImagen = document.getElementById("modificar-imagen");
            let categoria = document.getElementById("categoria");

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

            categoria.addEventListener("change", () => {
                actualizarImagen();
            });

            function actualizarImagen (){
                let cat = categoria.options[categoria.selectedIndex].value;
                let img = document.getElementById("img-cat");

                $.ajax ({
                    type: "POST",
                    url: "../controlador/veObtenerImagen.php",
                    data: "categoria=" + cat ,
                    success: function (r){
                        img.setAttribute("src", r);
                    }
                });
            }	

            let idCategoria = obtenerVariable("categoria");
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

        #mensaje, .mensaje{
            background-color: black;
            color : white;
            margin-top : 20px;
            margin-bottom : 20px;
            padding : 10px;
            border-radius : .5rem;
            text-align : center;
        }

        form h1{
            width:100%;
            text-align:center;
        }

        .label-categoria{
            width:80%; 
            text-align:center; 
            font-size:1.3rem;
        }

        .img-actual{
            border:1px solid #000; 
            padding: 5px; 
            margin: 20px 0; 
            width: 100%;
        }

        .img-actual p{
            text-align:center;
            margin: 5px;
        }

        .img-actual div{
            display:flex; 
            justify-content:center;
        }
    </style>
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