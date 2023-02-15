<?php 
    include  "../inc/conn.php";
    require_once "../controlador/config.php";
    include_once "../controlador/apiDatos.php";
    include_once "encabezado.php"; 
    include_once "modalNovedades.php";
    include_once "pie.php";  

    if (perfil_valido(3)) {
       header("location:login.php");
       exit;
    }
    else if (perfil_valido(1)) {
        header("location:veABMProducto.php");
        exit;
    }  

    $ruta = "<ol class='ruta'>
                <li><a href='index.php'>Inicio</a></li>
                <li>Datos personales</li>
            </ol>
    ";
    
    if (isset($_SESSION["idUsuario"])){
        $id_usuario = $_SESSION["idUsuario"];
    } else if (isset($_SESSION["id"])){
        $id_usuario = obtener_usuario_con_rs($_SESSION["id"]);
    }
    // else if (isset($_SESSION["id_tw"])){
    //     $id_usuario = $_SESSION["id_tw"];
    // }
        
    $rs = obtener_usuario($id_usuario);

    $contenedor_informacion_personal = "";

    foreach ($rs as $row) {
        $provincia = isset($row["provincia"])? $row["provincia"] : null;
        $provincia = json_encode($provincia);

        $ciudad =  isset($row["ciudad"])? $row["ciudad"] : null;
        $ciudad = json_encode ($ciudad);
        
        $contenedor_informacion_personal = "
            <form action='../controlador/modificarPerfil.php' method='post' class='cont-perfil'> 
                <div class='renglon' id='renglon-h1'>      
                    <h1> Mis datos </h1>
                </div> 

                <div class='renglon'>
                    <label class='descripciones' for='nombre-usuario'>Nombre de usuario</label>
                    <input type='text' id='nombre-usuario' class='dato' name='nombre-usuario' title='nombre-usuario' value='{$row["nombre_usuario"]}' readonly>
                </div>

                <div class='renglon'>
                    <label class='descripciones' for='dni'>Número de DNI</label>
                    <input type='number' class='dato' name='dni' id='dni' title='dni' value='{$row["nro_dni"]}' readonly>
                </div>

                <div class='renglon'>
                    <label class='descripciones' for='nombre'>Nombre</label>
                    <input type='text' class='dato' id='nombre' name='nombre' title='nombre' value='{$row["nombre"]}' readonly>
                </div>

                <div class='renglon'>
                    <label class='descripciones' for='apellido'>Apellido</label>
                    <input type='text' class='dato' name='apellido' id='apellido' title='apellido' value='{$row["apellido"]}' readonly>
                </div>

                <div class='renglon'>
                    <label class='descripciones' for='email'>Email</label>
                    <input type='email' class='dato' id='email' name='email' title='email' value='{$row["email"]}' readonly>
                </div>

                <div class='renglon'>
                    <label class='descripciones' for='prov'>Provincia</label>
                    <input type='text' class='dato' name='provincia' id='prov' title='provincia' value='{$row["provincia"]}' readonly> 
                    <label class='descripciones' for='provincia' id='lModProvincia'>Provincia</label>
                    $select
                </div>

                <div class='renglon' id='renglon-ciudad'>
                    <label class='descripciones' for='input-ciudad'>Ciudad</label>
                    <input type='text' id='input-ciudad' class='dato' name='ciudad' title='ciudad' value='{$row["ciudad"]}' readonly>
                    <label class='descripciones' id='label-mod-ciudad' for='ciu'>Ciudad</label>
                </div>

                <div class='renglon'>
                    <label class='descripciones' for='direccion'>Dirección</label>
                    <input type='text' class='dato' name='direccion' id='direccion' title='direccion' value='{$row["direccion"]}' readonly>
                    <div class='direccion'>
                        <label for='input-calle' class='form-label'>Calle</label>
                        <input type='text' class='dato' name='direccion[]' id='input-calle' title='Nombre de calle'>
                        <label for='input-numero' class='form-label'>Número</label>
                        <input type='number' class='dato' name='direccion[]' id='input-numero' title='Número de calle'>
                        <label for='input-piso' class='form-label'>Depto</label>
                        <input type='text' class='dato' name='direccion[]' id='input-piso' title='Piso y número de departamento'>
                    </div>
                </div>

                <div class='renglon'>
                    <div class='cont-reg l-novedades'>                
        ";

        if ($row["suscripcion"] === 1){
            $contenedor_informacion_personal .= "<input type='checkbox' id='novedades' name='suscripcion'  value='{$row["suscripcion"]}' checked disabled>";
        } else {
            $contenedor_informacion_personal .= "<input type='checkbox' id='novedades' name='suscripcion'  value='{$row["suscripcion"]}' disabled>";
        }

        $contenedor_informacion_personal .=" 
                    <label>
                        Suscripción a las novedades
                    </label>			
                </div>
            </div>
        ";
    }

    $contenedor_informacion_personal .= "
        <div class='renglon renglon-mod'>
            <input type='button' id='modificar-datos' onclick='modDatos($provincia)' class='btn' value='Modificar datos'>
            <input type='button' id='cancelar' class='btn' value='Cancelar'>  
            <input type='submit' id='confirmar' class='btn' value='Confirmar'>
        </div>
    ";

    if (isset($_GET["error"])){
        $error = $_GET["error"];
        $contenedor_informacion_personal .= "<div class='renglon renglon-mod'>";

        if ($error == "1"){
            $contenedor_informacion_personal .= "<p class='mensaje' id='mensaje'>¡El nombre de usuario ingresado ya existe, reintente con otro por favor!</p>";
        } else if ($error == "2"){
            $contenedor_informacion_personal .= "<p class='mensaje' id='mensaje'>Falta ingresar al menos un campo </p>";
        }

        $contenedor_informacion_personal .= "</div>";
    }
    else if (isset($_GET["modif"])){
        $contenedor_informacion_personal .= "<p class='mensaje' id='mensaje-exito'>¡Se ha realizado la modificación con éxito!</p>";
    }

    $contenedor_informacion_personal .= "</form>";
?>
<!DOCTYPE html>
<html lang="es">
<head> 
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css"  href="../assets/css/estilos.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="../images/iconos/logo_sitio.png">
	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
	<script src="../js/funciones.js"></script>
    <title>Muebles Giannis</title>
    <script>
        $(document).ready(function(){
			actualizarCiudad();

            $("#provincia").change (function (){
                actualizarCiudad();
            });

		});
    </script>
    <title>Muebles Giannis</title>   
    <style>
        main{
            display:flex;
            justify-content:center;
            flex-wrap:wrap;
        }

        .cont-perfil{
            display:flex;
            flex-wrap:wrap;
            justify-content: center;
            width: 60%;
            border-radius:5px;
            padding:0 10px;
            background-color:white;
            border: 1px solid black;
            margin-bottom: 30px;
        }

        .descripciones{
            display: flex;
            align-items: center;
            justify-content: center;
            background-color:white;
            border-right: 1px solid #D3D3D3;
            width:45%;
            margin:5px;
            padding: 5px;
        }

        .dato{
            background-color:white;
            width:45%;
            margin:5px;
            padding: 5px;
            border: none;
            text-align: center;
            font-family: "Salesforce Sans", serif;
            font-size: 1.1rem;
            line-height: 1.5em;
        }

        .direccion .dato{
            width: 100%;
        }

        p{
            text-align:center;
        }

        .renglon{
            width:100%;
            display:flex;
            justify-content:center;
            margin:0;
            border-bottom: 1px solid #D3D3D3;
        }

        .renglon h1{
            margin: 0; 
            display: flex; 
            align-items: center; 
            font-family: museosans500,arial,sans-serif; 
            font-size:1.6rem;
        }

        .renglon-mod{
            border:none;
        }

        #direccion{
            border-bottom: none;
        }

        #modificar-datos, #confirmar, #cancelar{
            margin:10px;
        }

        #confirmar, #cancelar{
            display:none;
        }

        .ruta{
            width: 100%;
			display: flex;
			margin-top: 0;
			background: #000;
			padding-left: 20px;
        }

        .ruta li{
            list-style-type: none;
            padding: 0 10px;
            border-right: 1px solid white;
            margin: 4px 0;
            text-decoration: underline;
            color: white;
			font-family: museosans500,arial,sans-serif;
        }

		.ruta li a{
			color: white;
		}

        #cancelar:hover{
            background-color: #D5D5D5;
        }

        .mensaje{
            width:100%;
            margin: 10px;
            text-align: center;
            background-color: #000;
            color: white;
            border-radius:5px;
            padding: 10px 0;
            font-size: 1.1rem;
        }

        #provincia, #ciu{
            display:none;
            text-align:center;
            background-color: white;
            width: 45%;
            margin: 10px;
            padding: 8px 24px;
            text-align: center;
            font-family: "Salesforce Sans", serif;
            font-size: 1.1rem;
            line-height: 1.5em;
            border-radius:5px;
        }

        #contenedor-ciudad{
            display:flex;
            justify-content:center;
        }

        #ciu{
            width:100%;
        }

        #label-mod-ciudad, #lModProvincia{
            display:none;
        }

        #input-numero, #input-piso{
            width:50%;
        }
        
        main > section {
            display: flex;
            width: 65%;
            height: auto;
            margin: 0 0 4% 10%;
        }
        
        .direccion{
            width:47%; 
            align-items:center; 
            justify-content:end; 
            display:none;
        }

        .ruta li{
			margin-left:5px;
		}

		.ruta li:last-child{
            border:none;
            text-decoration: none;
        }

        #mensaje-exito{
            background:#099;
        }

        #renglon-h1{
            border-bottom:1px solid #858585; 
            height:50px;
        }

        .direccion{
            flex-wrap:wrap;
            justify-content:center;
        }
            
        .direccion > .form-label{
            width:100%;
            text-align:center;
        }

        .cont-reg{
			display:flex;
			justify-content:center;
			flex-wrap:wrap;
            margin: 5px;
            padding: 5px;
		}

        .cont-reg label{
            display: flex;
            align-items: center;
        }
        
        @media screen and (max-width:860px){
            main > section {
                margin: auto;
                width: 95%;
                padding-bottom: 0;
                margin-bottom: 2%;
            }
            
            .cont-perfil{
                width: 100%;
            }
            
            .descripciones, .dato{
                width: 90%;
                border:none;
            }
            
            .renglon{
                flex-wrap:wrap;
            }
        }
    </style>
</head>
<body id="body">
    <header> 
        <?= imprimir_encabezado($encabezado, $encabezado_mobile); ?>
    </header>

    <main>
        <?= $ruta; ?>

        <aside class="contenedor-botones">
            <?= CONT_USUARIOS; ?>
        </aside>

        <section>
            <?= $contenedor_informacion_personal; ?>
        </section>

        <?= $modal_novedades; ?> 
        <?= $modal_novedades_error; ?>
    </main>

    <footer id="pie">
		<?= $pie; ?> 
	</footer>
</body>
</html>