<!DOCTYPE html>
<?php 
    include "encabezado.php";

    if (!perfil_valido(1)) {
        header("location:index.php");
    }

    $categorias = obtenerCategorias();

    $marcas = obtenerMarcas();

    $materiales = obtenerMateriales();
    //Las caracteristicas del producto se pueden elegir entre algunas especificas o queda al libre arbitrio del usuario
    //Está conformado así para simplificar 
    //Ejemplo: en las marcas se puede poner cualquier texto (puede ocasionar info escrita de diferente manera)
    //Ejemplo: colores no se pueden agregar mas y no se pueden elegir mas de uno
    $formulario = "
        <form class='cont' action='../controlador/veFuncProductoAlta.php' onsubmit='return validarAlta()' method='post' enctype='multipart/form-data'>
            <h1>Alta producto</h1> 
    ";

    if (isset($_GET["alta"])){
        $formulario .= "
            <div class='contenedor mensaje' id='mensaje'>
                <p> ¡Se ha añadido el producto con éxito! </p>
            </div>
        ";
    }
    else if (isset($_GET["error"])){
        $error = $_GET["error"];

        if ($error == "1"){
            $formulario .="
                <div class='contenedor mensaje' id='mensaje'>
                    <p>
                        Error: la imagen no ha sido procesada con éxito, reintente nuevamente.
                    </p>
                </div>
            ";
        } else if ($error == "2") {
            $formulario .="
                <div class='contenedor mensaje' id='mensaje'>
                    <p>
                        Error: La extensión del archivo es incorrecta, reintente con las siguientes extensiones
                        png, jpeg, jpg.
                    </p>
                </div>
            ";
        } else if ($error == "3"){
            $formulario .="
                <div class='contenedor mensaje' id='mensaje'>
                    <p>
                        Error: Los datos ingresados no son correctos, verifique que todos los campos están completos
                        y cumplen con los requisitos de la aplicacion.
                    </p>
                </div>
            ";    
        } else {
            $formulario .="
                <div class='contenedor mensaje' id='mensaje'>
                    <p>
                        Ha ocurrido un error inesperado, reintente nuevamente en otro momento.
                    </p>
                </div>
            ";
        }
    }
                
    $formulario .= 
            "<div class='contenedor'>
                <label for='categoria'>Categoría</label>
                $categorias
            </div>

            <div class='contenedor' id='subc'>
                
            </div>
            
            <div class='contenedor'>
                <label for='codigo'>Código</label>
                <input type='text' name='codigo' class='form-control-plaintext' id='codigo' title='Código' value='' readonly> 
            </div>

            <div class='contenedor'>
                <label for='descripcion'>Descripción</label>
                <input type='text' class='form-control' name='descripcion' id='descripcion' title='Descripción' value=''>
            </div>

            <div class='contenedor'>
                <label for='imagen'>Imagen</label>
                <input type='file' class='form-control' name='imagen' id='imagen' title='Seleccionar imagen' value=''>
            </div>
                    
            <div class='contenedor'>
                <label for='material'>Material</label>
                $materiales
                <p> Nuevo material: *Solo en el caso de que todavia no exista</p>
                <input type='text' class='form-control' name='input-material' id='material' title='Material' value=''>
            </div>

            <div class='contenedor' id='color'>
                <label>Color</label>
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
                $marcas
                <p> Nueva marca: *Solo en el caso de que todavia no exista</p>
                <input type='text' class='form-control' name='input-marca' id='marca' title='Marca' value=''> 
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
                <label for='descuento'>Porcentaje de descuento (Solo número)</label>
                <input type='number' class='form-control' name='descuento' id='descuento' title='Descuento' placeholder='Ejemplo: 30' value='' minValue='0' maxValue='100'>  
            </div>
            
            <div class='contenedor' id='agregar'>
                <input type='submit' id='btnEnviar' name='aceptar' class='btn btn-enviar' title='' value='Agregar producto'>
            </div>
        </form>
    ";
?>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Muebles Giannis - Las mejores marcas</title>
    <link rel="icon" type="image/png" href="../images/iconos/logo_sitio.png">
    <link type="text/css"  href="../assets/css/estilos.css" rel="stylesheet"/>
    <link type="text/css"  href="../assets/css/ve_estilos.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
	<script src="../js/funciones.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const actualizarCodigo = () => {
                $.ajax ({
                    type: "POST",
                    url: "../controlador/actualizarCodigo.php",
                    data: "categoria= " + $("#categoria").val () + "&subcategoria=" + $("#subcategoria").val (),
                    success: function (nroProducto){
                        let input = document.getElementById("codigo");
                        let categoria = document.getElementById("categoria");
                        categoria = categoria.options[categoria.selectedIndex].text;
                        categoria = categoria.substring(0,2);

                        let subcategoria = document.getElementById("subcategoria");

                        if (subcategoria.selectedIndex != -1){
                            subcategoria = subcategoria.options[subcategoria.selectedIndex].text;
                            subcategoria = subcategoria.substring(0,2);
    
                            let codigo = (categoria + subcategoria + nroProducto).toLowerCase();
                            input.setAttribute("value",codigo);
    
                            codigo = (categoria + subcategoria).toLowerCase();

                            verCaract(codigo);
                        } else {
                            divSubcategoria = document.getElementById ("subc");
                            let linkNuevaSubcategoria = document.createElement("a");
                            let parrafo = document.createElement("p");
                            let text = document.createTextNode("Ir a crear nueva subcategoría");
                            parrafo.appendChild(text);
                            parrafo.setAttribute("style", "text-decoration: underline;");
                            linkNuevaSubcategoria.setAttribute("href","veSubcategoriaAlta.php");
                            linkNuevaSubcategoria.appendChild(parrafo);
                            divSubcategoria.appendChild(linkNuevaSubcategoria);

                            input.setAttribute("value", "Error, no existe subcategoria seleccionada");
                        }

                        //No escalable al agregar mas categorias/subcategorias
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
                        });
                    }
                });
            }    

            actualizar ();

            $("#categoria").change (function (){
                actualizar ();
            });

            function verCaract (codigo){
                let caracUno = document.getElementById ("caracUno");
                let caracDos = document.getElementById ("caracDos");
                let caracTres = document.getElementById ("caracTres");

                //Según la subcategoría se establecen el nombre de las características
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
                    caracUno.innerHTML = "Plazas";
                    caracDos.innerHTML = "Largo";
                    caracTres.innerHTML = "Ancho";
                }
                else{
                    caracUno.innerHTML = "Alto";
                    caracDos.innerHTML = "Ancho";
                    caracTres.innerHTML = "Profundidad";
                }

                //Mostrar o no mostrar elementos HTML segun la cantidad de caracteristicas 
                //que tiene la subcategoría
                let inputProfundidad = document.getElementById ("profundidad");

                if (codigo != "come" && codigo != "cosi" && codigo != "ofsi"){
                    caracTres.style.display = "block";
                    inputProfundidad.style.display = "block";
                }
                else{
                    caracTres.style.display = "none";
                    inputProfundidad.style.display = "none";
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
        
        .contenedor label {
            padding: 10px 0;
        }

        #codigo{
            background-color: #ccc;
        }

        #imagen{
            padding: 20px 0 0 10px;
            border: none;
            width: auto;
        }

        #color{
            justify-content:start;
            padding: 0 10% 10px;
        }

        #color > label{
            width:100%; 
            height:40px;
        }

        #color div label{
            width:40%;
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

        #btnEnviar:hover{
            cursor: pointer;
        }

		.marca, .material{
			display:flex;
			justify-content:start;
			align-items: center;
			width:40%;
		}

        .marca input, .material input{
            min-height: 15px;
            width: 8%;
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

        .mensaje p{
            text-align:center;
        }

        form h1{
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