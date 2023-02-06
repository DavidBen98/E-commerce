<!DOCTYPE html>
<?php 
    include "encabezado.php";

    if (!perfil_valido(1)) {
        header("location:index.php");
    }

    $categorias = obtenerCategorias();

    $formulario = "
        <form class='cont' action='../controlador/veFuncProductoBaja.php' method='post' enctype='multipart/form-data'>
    ";

    if (isset($_GET["modif"])) {
        $formulario .= "<h1 id='h1'>Modificar producto</h1>";
    } else {
        $formulario .= "<h1 id='h1'>Baja producto</h1>";
    }

    $formulario .= "
        <div class='contenedor'>
            <label for='categoria'>Categoría</label>
            $categorias
        </div>

        <div class='contenedor' id='subc'>
            
        </div>

        <div class='contenedor' id='imagen'>
        
        </div>
    ";
    
    if (isset($_GET["elim"])){
        $formulario .= "
            <div class='contenedor mensaje' id='mensaje'>
                <p>¡Se ha eliminado el producto de manera exitosa!</p>
            </div>
        ";
    }
    else if (isset($_GET["error"])){
        $formulario .="
            <div class='contenedor' id='error'>
                <p>Error: los datos ingresados no son correctos, reintente por favor</p>
            </div>
        ";
    }

    $formulario .= "</form>";
?>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Muebles Giannis - Las mejores marcas</title>
    <link type="text/css"  href="../assets/css/estilos.css" rel="stylesheet"/>
    <link type="text/css"  href="../assets/css/ve_estilos.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const actualizarCodigo = () => {
                $.ajax ({
                    type: "POST",
                    url: "../controlador/veFuncProductoBaja.php",
                    data: "categoria= " + $("#categoria").val () + "&subcategoria=" + $("#subcategoria").val (),
                    success: function (datos){

                        let input = document.getElementById("imagen");

                        if (datos == "") {
                            input.innerHTML = datos;
                            let vacio = document.createElement("p");
                            let texto = document.createTextNode("No existen resultados que coincidan con la búsqueda");
                            vacio.appendChild(texto);
                            input.appendChild(vacio);
                        } else {
                            input.innerHTML = datos;
    
                            let imagen = document.getElementsByClassName("imagen");
    
                            for (let i = 0; i < imagen.length; i++){
                                imagen[i].addEventListener ("click", () => {
    
                                    if (window.location.search === "?modif=true"){
                                        window.location.href = "veProductoModif.php?id="+imagen[i].alt;
                                    }
                                    else{
                                        let confirmar = confirm ("¿Desea eliminar el producto con código " + imagen[i].alt + "?");
        
                                        if (confirmar){
                                            let codigo = imagen[i].alt;
        
                                            window.location.href = "../controlador/veFuncProductoBaja.php?eliminar="+codigo;
                                        }
                                    }
                                });
                            }
                        }
                    }
                });
            }

            const actualizar = () => {  
                $.ajax ({
                    type: "POST",
                    url: "rellenarSelect.php",
                    data: "categoria= " + $("#categoria").val (),
                    success: function (r){
                        $("#subc").html (r);

                        actualizarCodigo ();

                        let sub = document.getElementById ("subcategoria");

                        sub.addEventListener ("change", function (){
                            actualizarCodigo ();

                            let mensajeElim = document.getElementById ("mensaje");

                            if (mensajeElim != null) {
                                mensajeElim.remove();
                            }
                        });
                    }
                });
            }    

            actualizar ();

            $("#categoria").change (function (){
                actualizar ();

                let mensajeElim = document.getElementById ("mensaje");

                if (mensajeElim != null) {
                    mensajeElim.remove();
                }
            });
        });
	</script>
    <style>
        #main{
            height: auto;
        }
        .cont{
            height:auto;
            width:80%;
            justify-content: start;
            margin-bottom: 20px;
        }

        .contenedor{
            margin: 10px 0;
            padding-bottom:10px;
        }
        .contenedor select{
            width:80%;
            text-align:center;
        }

        .imagen{
            height:200px;
            object-fit: contain;
        }

        .producto{
            display:flex;
            flex-wrap:wrap;
            justify-content:center;
            width:230px;
            margin:10px;
        }

        .producto p{
            margin:auto;
            text-align:center;
            width: 100%;
        }

        #imagen{
            justify-content:center;
        }

        #agregar{
            background:transparent;
        }
      
        #elim{
            background: #000;
            color: white;
            border-radius: 5px;
            padding: 0;
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

        #h1{
            width:100%;
            text-align:center;
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