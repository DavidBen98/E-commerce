<!DOCTYPE html>
<?php 
    include("encabezado.php");
    include_once ("funciones.php");

    if (!perfil_valido(1)) {
        header("location:index.php");
    }

    $lista = obtenerCategorias();

    $prod = "<div class='contenedor'>
                <label for='categoria'>Categoría</label>
                $lista
            </div>
            <div class='contenedor' id='subc'>
                
            </div>

            <div class='contenedor' id='imagen'>
            </div>
    ";
?>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Muebles Giannis - Las mejores marcas</title>
    <link type="text/css"  href="assets/css/estilos.css" rel="stylesheet"/>
    <link type="text/css"  href="assets/css/ve_estilos.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
	<!--<script src="js/funciones.js"></script> -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const actualizarCodigo = () => {
                $.ajax ({
                    type: "POST",
                    url: "elimProd.php",
                    data: "categoria= " + $('#categoria').val () + "&subcategoria=" + $('#subcategoria').val (),
                    success: function (datos){
                        let input = document.getElementById('imagen');
                        
                        input.innerHTML = datos;

                        let imagen = document.getElementsByClassName('imagen');

                        for (let i = 0; i < imagen.length; i++){
                            imagen[i].addEventListener ('click', () => {
                                alert ("¿Desea eliminar el producto con código " + imagen[i].alt + "?");
                            })
                        }
                    }
                });
            }

            const actualizar = () => {  
                $.ajax ({
                    type: "POST",
                    url: "rellenarSelect.php",
                    data: "categoria= " + $('#categoria').val (),
                    success: function (r){
                        $('#subc').html (r);

                        actualizarCodigo ();

                        let sub = document.getElementById ('subcategoria');

                        sub.addEventListener ('change', function (){
                            actualizarCodigo ();
                        });
                    }
                });
            }    

            actualizar ();

            $('#categoria').change (function (){
                actualizar ();
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
            background:rgba(147, 81, 22,0.4);
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

    </style>
</head>
<body>
    <header id='header'>
        <?php echo $encab; ?>
	</header>

    <main id='main'>
        <form class='cont' action='altaProducto.php' method='post' enctype='multipart/form-data'>
            <?php 
                echo $prod; 
            ?>
        </form>
    </main>
</body>
</html>