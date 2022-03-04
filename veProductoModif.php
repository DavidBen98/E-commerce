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

    $codigo = $_GET['codigo'];

    $prod = "<form class='cont' action='veFuncProductoModifUbicacion.php' method='post' id='contUbicacion'>
                <h2 style='text-align:center; margin: auto;'>Ubicación</h2>";
            
                if (isset($_GET['modUbi'])){
                    $prod .= "<div class='mensaje'>
                            <p> ¡El producto '$codigo' se ha cambiado de ubicación exitosamente!</p>     
                         </div>";
                }

    $prod .= "  <div class='contenedor' id='catActual'>
                    
                </div>

                <div class='contenedor' style='display:none;'>
                    <input type='hidden' name='codigo' class='btn btn-enviar' title='' value='$codigo'>     
                </div>

                <div class='contenedor'>
                    <label for='categoria'>Categoría nueva</label>
                    $lista
                </div>

                <div class='contenedor' id='subc'>
                    
                </div>

                <div class='contenedor' id='ubicacion'>
                    <input type='submit' name='ubicacion' id='bUbicacion' class='btn btn-enviar' title='' value='Modificar ubicación'>
                </div>
            </form>

            <form class='cont' action='veFuncProductoModifCaract.php' method='post' id='contCaracterísticas'>";

            if (isset($_GET['modif'])){
                $prod .= "<div class='mensaje'>
                            <p> ¡El producto '$codigo' se ha modificado exitosamente!</p>     
                         </div>";
            }

    $prod .= "
                <h2 style='text-align:center; margin: auto;'>Características</h2>
                <div class='contenedor'>
                    <label for='codigo'>Código</label>
                    <input type='text' name='codigo' readonly class='form-control-plaintext' id='codigo' title='Código' value='$codigo' readonly> 
                </div>

                <div class='contenedor'>
                    <label for='descripcion'>Descripción</label>
                    <input type='text' class='form-control' name='descripcion' id='descripcion' title='Descripción' value=''>
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
                    <input type='number' class='form-control' name='caracteristicas[]' id='alto' title='alto' value=''>
                    <label for='ancho' id='caracDos'>Ancho/Largo/Altura del piso al asiento</label>
                    <input type='number' class='form-control' name='caracteristicas[]' id='ancho' title='ancho' value=''>
                    <label for='profundidad' id='caracTres'>Profundidad/Ancho/Alto</label>
                    <input type='number' class='form-control' name='caracteristicas[]' id='profundidad' title='profundidad' value=''>
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
                    <label for='descuento'>Porcentaje de descuento (Solo número)</label>
                    <input type='number' class='form-control' name='descuento' id='descuento' title='Descuento' placeholder='Ejemplo: 30' value='' minValue='0' maxValue='100'>  
                </div>
                <div class='contenedor' id='caracteristicas'>
                        <input type='submit' name='caract' id='bCaracteristicas' class='btn btn-enviar' title='' value='Modificar características'>
                </div>";

        if (isset($_GET['modif'])){
            $formulario .= "
            <div class='contenedor' id='elim'>
                <p>¡Se ha modificado el producto de manera exitosa!</p>
            </div>";
        }
        else if (isset($_GET['error'])){
            $prod .="
            <div class='contenedor' id='error'>
                <p>Error: los datos ingresados no son correctos, reintente por favor</p>
            </div>";
        }
            
    $prod .= "</form>";
?>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Muebles Giannis - Las mejores marcas</title>
    <link type="text/css"  href="assets/css/estilos.css" rel="stylesheet"/>
    <link type="text/css"  href="assets/css/ve_estilos.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
	<script src="js/funciones.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let codigo = getQueryVariable("codigo");

            function parsearCaracteristicas(cadena){
                let numero = "";
                for (let i=0;i<cadena.length;i++){
                    if (cadena[i] >= 48 || cadena[i] <= 57) {
                        numero += cadena[i];
                    }
                }

                numero = numero.trim();

                let hasta = numero.indexOf(" ");
                let elementoUno = numero.slice(0,hasta);
                numero = numero.replace (elementoUno+" ","");

                hasta = numero.indexOf(" ");
                let elementoDos = "";
                
                if (hasta === -1){
                    elementoDos = numero;
                }
                else{
                    elementoDos = numero.slice(0,hasta);
                    numero = numero.replace (elementoDos+" ","");

                    let elementoTres = numero;
                    document.getElementById('profundidad').value = elementoTres;
                    document.getElementById('profundidad').setAttribute('value', elementoTres);
                }       

                document.getElementById('alto').value = elementoUno;
                document.getElementById('ancho').value = elementoDos;

                document.getElementById('alto').setAttribute('value',elementoUno);
                document.getElementById('ancho').setAttribute('value',elementoDos);

                verCaract (codigo);
            }

            function verCaract (codigo){
                codigo = codigo.slice(0,4);

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
                    document.getElementById('profundidad').style.display = 'block';
                }
                else{
                    caracTres.style.display = 'none';
                    document.getElementById('profundidad').style.display = 'none';
                }
            }

            const completarDatos = () => {
                $.ajax ({
                    type: "POST",
                    url: "veFuncObtenerDatos.php",
                    data: "codigo=" + codigo,
                    success: function (datos){
                        let data = JSON.parse(datos);

                        let contenedor = document.getElementsByClassName ('contenedor');

                        let categoria = "<p><b>Categoría actual:</b> "+data.categoria+
                                        "</p><p><b>Subcategoría actual:</b> "+data.subcategoria+"</p>";

                        contenedor[0].innerHTML = categoria;
                        document.getElementById('codigo').value = codigo;
                        document.getElementById('descripcion').value = data.descripcion;
                        document.getElementById('material').value = data.material;
                        document.getElementById(data.color.toLowerCase()).checked = true;
                        document.getElementById('descripcion').value = data.descripcion;
                        document.getElementById('marca').value = data.marca;
                        document.getElementById('cant').value = Number(data.stock);
                        document.getElementById('precio').value = data.precio;
                        document.getElementById('descuento').value = data.descuento;
                        parsearCaracteristicas (data.caracteristicas);
                    }
                });
            }

            async function actualizar() {  
                let actualizar = await $.ajax ({
                                            type: "POST",
                                            url: "rellenarSelect.php",
                                            data: "categoria= " + $('#categoria').val (),
                                            success: function (r){
                                                $('#subc').html (r);

                                                let sub = document.getElementById ('subcategoria');
                                            }
                                        });
            }    
            
            async function init (){
                let act = await actualizar ();
                completarDatos ();

                let label = document.getElementsByClassName('label');
                label[0].innerText = 'Subcategoría nueva';
            }

            $('#categoria').change (function (){
                actualizar ();
            });

            init ();
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

        #contUbicacion, #contCaracteristicas{
            width:100%;
            background:rgba(147, 81, 22,0.4);
        }

        #contCaracteristicas{
            margin-top: 20px;
        }

        #catActual p{
            width: 100%;
            text-align:center;
            margin: 5px;
        }

        .btn:hover{
            background: #000;
        }

        #contUbicacion{
            margin-right:10px;
            width:40%;
        }

        .mensaje{
            display:flex;
            justify-content: center;
            background-color: #099;
            color: white;
            border-radius:5px;
            font-size: 1.1rem;
            width:100%;
            margin: 10px 0;
        }
    </style>
</head>
<body>

    <header id='header'>
        <?= $encabezado; ?>
	</header>

    <main id='main'>
        <h1 style='width:100%;text-align:center;'>Modificar producto</h1>

        <?= $prod; ?>
    </main>

</body>
</html>