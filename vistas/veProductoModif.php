<!DOCTYPE html>
<?php 
    include "encabezado.php";

    if (!perfil_valido(1)) {
        header("location:index.php");
        exit;
    }

    $categorias = obtener_categorias();
    $materiales = obtener_materiales();
    $marcas = obtener_marcas();
    $colores = obtener_colores();

    //Establecer si la foto es de portada
    //<div style='width:100%; display: flex; justify-content: center; align-items: center;'>
    //  <input type='checkbox' class='form-control' name='portada' id='portada' title='Portada' value='Imagen de portada'>  
    //  <label for='portada' id='lPortada'>Imagen de portada</label>
    //</div>

    $id = $_GET["id"];

    $formulario = "  
        <form class='cont' action='../controlador/veFuncProductoModifCaract.php' onsubmit='return validarModif()' method='post' id='cont-caracteristicas'>
    ";

    if (isset($_GET["modif"])){
        $formulario .= "
            <div class='mensaje'>
                <p> ¡El producto con id:'$id' se ha modificado exitosamente!</p>     
            </div>
        ";
    } else if (isset($_GET["error"])){
        $formulario .="
            <div class='contenedor mensaje' id='mensaje'>
                <p>Error: los datos ingresados no son correctos, reintente por favor</p>
            </div>
        ";
    }

    $formulario .= "
        <h2>Características</h2>
        
        <div class='contenedor'>
            <label for='id'>Id</label>
            <input type='text' name='id' class='form-control-plaintext' id='id' title='Código' value='$id' readonly> 
        </div>

        <div class='contenedor'>
            <label for='descripcion'>Descripción</label>
            <input type='text' class='form-control' name='descripcion' id='descripcion' title='Descripción' value=''>
        </div>
                
        <div class='contenedor'>
            <fieldset class='fieldset-marca' legend='material'>
                <label for='material' style='display:none;'>Material</label>
                <input type='text' class='form-control' name='input-material' id='material' title='Material' value=''>
                <legend class='ltitulo'>Materiales</legend>
                $materiales
            </fieldset>
        </div>

        <div class='contenedor'>
            <fieldset class='fieldset-color color-div'>
                <label for='color' style='display:none;'>Color</label>
                <input type='text' class='form-control' name='input-color' id='color' title='Color' value=''>
                <legend class='ltitulo'>Color</legend>
                $colores
            </fieldset> 
        </div>

        <div class='contenedor' id='caracteristicas'>
            <p>Características (Números redondos, en centímetros)</p>
            <label for='alto' id='caracteristica-uno'>Alto/Plazas/Largo/Altura del respaldo</label>
            <input type='number' class='form-control' name='caracteristicas[]' id='alto' title='alto' value='' step='5'>
            <label for='ancho' id='caracteristica-dos'>Ancho/Largo/Altura del piso al asiento</label>
            <input type='number' class='form-control' name='caracteristicas[]' id='ancho' title='ancho' value='' step='5'>
            <label for='profundidad' id='caracteristica-tres'>Profundidad/Ancho/Alto</label>
            <input type='number' class='form-control' name='caracteristicas[]' id='profundidad' title='profundidad' value='' step='5'>
        </div>

        <div class='contenedor'>
            <fieldset class='fieldset-marca' legend='marca'>
                <label for='marca' style='display:none;'>Marca</label>
                <input type='text' class='form-control' name='input-marca' id='marca' title='Marca' value=''>
                <legend class='ltitulo'>Marcas</legend>
                $marcas
            </fieldset> 
        </div>

        <div class='contenedor'>
            <label for='cant'>Stock</label>
            <input type='number' class='form-control' name='cant' id='cant' title='Cantidad' min='1' value=''>  
        </div>

        <div class='contenedor'>
            <label for='precio'>Precio unitario (Solo número, sin puntos ni comas)</label>
            <input type='number' class='form-control' name='precio' id='precio' title='Precio unitario' value='' placeholder='Ejemplo: 10000' min='1'>  
        </div>

        <div class='contenedor'>
            <label for='descuento'>Porcentaje de descuento (Solo número)</label>
            <input type='number' class='form-control' name='descuento' id='descuento' title='Descuento' placeholder='Ejemplo: 30' value='' min='0' max='100'>  
        </div>
        <div class='contenedor' id='cont-modificar-caract'>
            <input type='submit' name='caract' id='btn-caracteristicas' class='btn btn-enviar' title='' value='Modificar características'>
        </div>
    ";   
            
    $formulario .= "</form>";
?>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Muebles Giannis - Las mejores marcas</title>
    <link rel="icon" type="image/png" href="../images/iconos/logo_sitio.png">
    <link type="text/css"  href="../assets/css/estilos.css" rel="stylesheet">
    <link type="text/css"  href="../assets/css/ve_estilos.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
	<script src="../js/funciones.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let id = obtenerVariable("id");

            function parsearCaracteristicas(codigo, cadena){
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
                    document.getElementById("profundidad").value = elementoTres;
                    document.getElementById("profundidad").setAttribute("value", elementoTres);
                }       

                document.getElementById("alto").value = elementoUno;
                document.getElementById("ancho").value = elementoDos;

                document.getElementById("alto").setAttribute("value",elementoUno);
                document.getElementById("ancho").setAttribute("value",elementoDos);

                verCaract (codigo);
            }

            function verCaract (codigo){
                codigo = codigo.slice(0,4);
                let caracUno = document.getElementById("caracteristica-uno");
                let caracDos = document.getElementById("caracteristica-dos");
                let caracTres = document.getElementById("caracteristica-tres");

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

                if (codigo != "come" && codigo != "cosi" && codigo != "ofsi"){
                    caracTres.style.display = "block";
                    document.getElementById("profundidad").style.display = "block";
                }
                else{
                    caracTres.style.display = "none";
                    document.getElementById("profundidad").style.display = "none";
                }
            }

            const completarDatos = () => {
                $.ajax ({
                    type: "POST",
                    url: "../controlador/veFuncObtenerDatos.php",
                    data: "id=" + id,
                    success: function (datos){
                        let data = JSON.parse(datos);

                        let contenedor = document.getElementsByClassName ("contenedor");

                        // let categoria = "<p><b>Categoría actual:</b> "+data.categoria+
                        //                 "</p><p><b>Subcategoría actual:</b> "+data.subcategoria+"</p>";

                        // contenedor[0].innerHTML = categoria;
                        document.getElementById("id").value = id;
                        document.getElementById("descripcion").value = data.descripcion;
                        document.getElementById("material").value = data.material;
                        document.getElementById("color").value = data.color;
                        document.getElementById("descripcion").value = data.descripcion;
                        document.getElementById("marca").value = data.marca;
                        document.getElementById("cant").value = Number(data.stock);
                        document.getElementById("precio").value = data.precio;
                        document.getElementById("descuento").value = data.descuento;

                        parsearCaracteristicas (data.codigo,data.caracteristicas);
                    }
                });
            }

            const materiales = document.querySelectorAll('input[name="material"]');

            materiales.forEach(material => {
                material.addEventListener("change", () => {
                    const materialChequeado = document.querySelector('input[name="material"]:checked').value;
                    let inputMaterial = document.getElementById("material");
                    inputMaterial.value = materialChequeado;
                });
            });

            const marcas = document.querySelectorAll('input[name="marca"]');

            marcas.forEach(marcas => {
                marcas.addEventListener("change", () => {
                    const marcaChequeada = document.querySelector('input[name="marca"]:checked').value;
                    let inputMarca = document.getElementById("marca");
                    inputMarca.value = marcaChequeada;
                });
            });

            const colores = document.querySelectorAll('input[name="color"]');

            colores.forEach(colores => {
                colores.addEventListener("change", () => {
                    const colorChequeado = document.querySelector('input[name="color"]:checked').value;
                    let inputColor = document.getElementById("color");
                    inputColor.value = colorChequeado;
                });
            });

            completarDatos ();
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

        .fieldset-marca, .fieldset-color{
            display: flex;
            flex-wrap: wrap;
            width: 100%;
            justify-content: center;
            border: none;
        }

        .fieldset-marca select, .fieldset-color select{
            width:80%;
            text-align:center;
        }

        .label{
            font-weight: normal;
        }

        #color{
            width: 100%;
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

        #id-actual{
            display:none;
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

        #cont-ubicacion, #contCaracteristicas{
            width:100%;
            background:rgba(147, 81, 22,0.4);
        }

        #contCaracteristicas{
            margin-top: 20px;
        }

        #categoria-actual p{
            width: 100%;
            text-align:center;
            margin: 5px;
        }

        #cont-ubicacion{
            margin-right:10px;
            width:40%;
        }

        .color-div{
            width:100%;
            display: flex;
            justify-content: center;
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

        .color label{
            width:100%; 
            height:40px;
        }

        .material, .marca, .color {
            padding: 10px 0;
        }

        .material input, .marca input, .color input{
            width: auto;
            height: auto;
        }

        form h2{
            text-align:center; 
            margin: auto;
        }

        #main > h1{
            width:100%;text-align:center;
        }
    </style>
</head>
<body>

    <header id="header">
        <?= $encabezado; ?>
	</header>

    <main id="main">
        <h1>Modificar producto</h1>

        <?= $formulario; ?>
    </main>

</body>
</html>