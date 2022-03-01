<!DOCTYPE html>
<?php 
    include("encabezado.php");
    include_once ("funciones.php");

    if (!perfil_valido(1)) {
        header("location:index.php");
    }


    $lista = obtenerCategorias();
    //Las caracteristicas del producto se pueden elegir entre algunas especificas o queda al libre arbitrio del usuario
    //Está conformado así para simplificar 
    //Ejemplo: en las marcas se puede poner cualquier texto (puede ocasionar info escrita de diferente manera)
    //Ejemplo: colores no se pueden agregar mas y no se pueden elegir mas de uno
    $prod = "<div class='contenedor'>
                <label for='categoria'>Categoría</label>
                $lista
            </div>
            <div class='contenedor' id='subc'>
                
            </div>
            <div class='contenedor'>
                <label for='codigo'>Código</label>
                <input type='text' name='codigo' readonly class='form-control-plaintext' id='codigo' title='Código' value='' readonly> 
            </div>

            <div class='contenedor'>
                <label for='descripcion'>Descripción</label>
                <input type='text' class='form-control' name='descripcion' id='descripcion' title='Descripción' value=''>
            </div>

            <div class='contenedor'>
                <label for='imagen'>Imagen</label>
                <input type='file' class='form-control' name='imagen' id='imagen' title='Seleccionar imagen' value=''>
                <div style='width:100%; display: flex; justify-content: center; align-items: center;'>
                    <input type='checkbox' class='form-control' name='portada' id='portada' title='Portada' value='Imagen de portada'>  
                    <label for='portada' id='lPortada'>Imagen de portada</label>
                </div>
            </div>
                    
            <div class='contenedor'>
                <label for='material'>Material</label>
                <input type='text' class='form-control' name='material' id='material' title='Material' value=''>
            </div>

            <div class='contenedor' id='color'>
                <label style='width:100%; height:40px;'>Color</label>
                <div><input type='radio' id='amarillo' name='color' value='amarillo' checked><label for='amarillo'>Amarillo</label></div>
                <div><input type='radio' id='azul' name='color' value='azul'><label for='azul'>Azul</label></div>
                <div><input type='radio' id='beige' name='color' value='beige'><label for='beige'>Beige</label></div>
                <div><input type='radio' id='blanco' name='color' value='blanco'><label for='blanco'>Blanco</label></div>
                <div><input type='radio' id='blancoviejo' name='color' value='blanco viejo'><label for='blancoviejo'>Blanco viejo</label></div>
                <div><input type='radio' id='celeste' name='color' value='celeste'><label for='celeste'>Celeste</label></div>
                <div><input type='radio' id='gris' name='color' value='gris'><label for='gris'>Gris</label></div>
                <div><input type='radio' id='marron' name='color' value='marron'><label for='marron'>Marrón</label></div>
                <div><input type='radio' id='morado' name='color' value='morado'><label for='morado'>Morado</label></div>
                <div><input type='radio' id='naranja' name='color' value='naranja'><label for='naranja'>Naranja</label></div>
                <div><input type='radio' id='negro' name='color' value='negro'><label for='negro'>Negro</label></div>
                <div><input type='radio' id='rojo' name='color' value='rojo'><label for='rojo'>Rojo</label></div>
                <div><input type='radio' id='rosa' name='color' value='rosa'><label for='rosa'>Rosa</label></div>
                <div><input type='radio' id='verde' name='color' value='verde'><label for='verde'>Verde</label></div>
                <div><input type='radio' id='violeta' name='color' value='violeta'><label for='violeta'>Violeta</label></div>
            </div>

            <div class='contenedor' id='caracteristicas'>
                <label for='alto'>Características (Números redondos, en centímetros)</label>
                <label for='alto' id='caracUno'>Alto/Plazas/Largo/Altura del respaldo</label>
                <input type='number' class='form-control' name='caracteristicas[]' id='alto' title='alto' value='0' step='5'>
                <label for='ancho' id='caracDos'>Ancho/Largo/Altura del piso al asiento</label>
                <input type='number' class='form-control' name='caracteristicas[]' id='ancho' title='ancho' value='0' step='5'>
                <label for='profundidad' id='caracTres'>Profundidad/Ancho/Alto</label>
                <input type='number' class='form-control' name='caracteristicas[]' id='profundidad' title='profundidad' value='0' step='5'>
            </div>

            <div class='contenedor'>
                <label for='marca'>Marca</label>
                <input type='text' class='form-control' name='marca' id='marca' title='Marca' value=''> 
            </div>

            <div class='contenedor'>
                <label for='cant'>Stock</label>
                <input type='number' class='form-control' name='cant' id='cant' title='Cantidad' minValue='1' value=''>  
            </div>

            <div class='contenedor'>
                <label for='precio'>Precio unitario (Solo número, sin puntos ni comas)</label>
                <input type='number' class='form-control' name='precio' id='precio' title='Precio unitario' value='' placeholder='Ejemplo: 10000' minValue='1'>  
            </div>

            <div class='contenedor'>
                <label for='descuento'>Descuento (Solo número)</label>
                <input type='number' class='form-control' name='descuento' id='descuento' title='Descuento' placeholder='Ejemplo: 30' value='' minValue='0' maxValue='100'>  
            </div>
            <div class='contenedor' id='agregar'>
                    <input type='submit' name='aceptar' class='btn btn-enviar' title='' value='Agregar producto'>
            </div>";

            if (isset($_GET['error'])){
                $prod .="
                <div class='contenedor' id='error'>
                    <p>Error: los datos ingresados no son correctos, reintente por favor</p>
                </div>";
            }
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
                    url: "actCodigo.php",
                    data: "categoria= " + $('#categoria').val () + "&subcategoria=" + $('#subcategoria').val (),
                    success: function (nroProducto){
                        let input = document.getElementById('codigo');
                        let categoria = document.getElementById('categoria');
                        categoria = categoria.options[categoria.selectedIndex].text;
                        categoria = categoria.substring(0,2);

                        let subcategoria = document.getElementById('subcategoria');
                        subcategoria = subcategoria.options[subcategoria.selectedIndex].text;
                        subcategoria = subcategoria.substring(0,2);

                        let codigo = (categoria + subcategoria + nroProducto).toLowerCase();
                        input.setAttribute('value',codigo);

                        let caracUno = document.getElementById ('caracUno');
                        let caracDos = document.getElementById ('caracDos');
                        let caracTres = document.getElementById ('caracTres');
                        let inputProfundidad = document.getElementById ('profundidad');

                        codigo = (categoria + subcategoria).toLowerCase();

                        //No escalable al agregar mas categorias/subcategorias
                        verCaract();

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

            function verCaract (){
                            if (codigo == "ofsi"){
                                caracUno.innerHTML = "Altura del respaldo";
                                caracDos.innerHTML = "Altura del piso al asiento";
                            }
                            else if (codigo == "doco"){
                                caracUno.innerHTML = "Largo";
                                caracDos.innerHTML = "Ancho";
                                caracTres.innerHTML = "Alto";
                            }
                            else if (codigo == "doca"){
                                caracUno.innerHTML = 'Plazas';
                                caracDos.innerHTML = 'Largo';
                                caracTres.innerHTML = "Ancho";
                            }
                            else{
                                caracUno.innerHTML = "Alto";
                                caracDos.innerHTML = "Ancho";
                                caracTres.innerHTML = "Profundidad";
                            }
    
                            if (codigo != "come" && codigo != "cosi" && codigo != "ofsi"){
                                caracTres.style.display = 'block';
                                inputProfundidad.style.display = 'block';
                            }
                            else{
                                caracTres.style.display = 'none';
                                inputProfundidad.style.display = 'none';
                            }
                        }
        });
	</script>
    <style>
        #main{
            height: auto;
        }
        .cont{
            height:auto;
            width:40%;
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

        .label{
            font-weight: normal;
        }

        #codigo{
            background-color: #ccc;
        }

        #imagen{
            padding:20px 0 0 10px;
            border:none;
        }

        #portada{
            width:5%;
            height:auto;
        }

        #lPortada{
            width:auto;
        }

        #color{
            justify-content:start;
            padding: 0 10% 10px;
        }

        #color div label{
            width:40%;
            text-align:start;
        }

        #color div input{
            width:8%;
            height:15px;
        }

        #color div{
            width:50%;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        #agregar{
            background:transparent;
        }

        #error{
            background: #000;
            color: white;
            border-radius: 5px;
            padding: 0;
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