<?php 
    include("pie.php");  
    include("modalNovedades.php");
    include ("inc/conn.php");
    require_once 'server/config.php';
    include("encabezado.php"); 
    include_once('server/apiDatos.php');

    if (perfil_valido(3)) {
       header("location:login.php");
    }
    else if (perfil_valido(1)) {
        header("location:veABMProducto.php");
    }  

    global $db; 

    $ruta = "<ol class='ruta'>
                <li style='margin-left:5px;'><a href='index.php'>Inicio</a></li>
                <li style='border:none;text-decoration: none;'>Datos personales</li>
            </ol>";
    
    if (isset($_SESSION['idUsuario'])){
        $idUsuario = $_SESSION['idUsuario'];
    }
    else if (isset($_SESSION['user'])){
        $idUsuario = $_SESSION['user'];
    }
    else if ($_SESSION['id_tw']){
        $idUsuario = $_SESSION['id_tw'];
    }

    $sql= "SELECT nombreUsuario, perfil, nroDni, nombre, apellido, email, provincia, ciudad, direccion
            FROM `usuario`
            WHERE id='$idUsuario'
    "; 
 
    $rs = $db->query($sql);

    $infoPersonal = "";
    foreach ($rs as $row) {
        $provincia = isset($row['provincia'])? $row['provincia'] : null;
        $provincia = json_encode($provincia);

        $ciudad =  isset($row['ciudad'])? $row['ciudad'] : null;
        $ciudad = json_encode ($ciudad);
        

        $infoPersonal = "<form action='server/modificarPerfil.php' method='post' class='cont-perfil'> 
                                <div class='renglon' style='border-bottom:1px solid #858585; height:50px;'>      
                                    <h1 style='margin: 0; display: flex; align-items: center; font-family: museosans500,arial,sans-serif; font-size:1.6rem;'>
                                        Mis datos
                                    </h1>
                                </div>    
                                <div class='renglon'>
                                    <label class='descripciones' for='nombreUsuario'>Nombre de usuario</label>
                                    <input type='text' id='nombreUsuario' class='dato' name='nombreUsuario' title='nombreUsuario' value='{$row['nombreusuario']}' readonly>
                                </div>

                                <div class='renglon'>
                                    <label class='descripciones' for='dni'>Número de DNI</label>
                                    <input type='number' class='dato' name='dni' id='dni' title='dni' value='{$row['nrodni']}' readonly>
                                </div>

                                <div class='renglon'>
                                    <label class='descripciones' for='nombre'>Nombre</label>
                                    <input type='text' class='dato' id='nombre' name='nombre' title='nombre' value='{$row['nombre']}' readonly>
                                </div>

                                <div class='renglon'>
                                    <label class='descripciones' for='apellido'>Apellido</label>
                                    <input type='text' class='dato' name='apellido' id='apellido' title='apellido' value='{$row['apellido']}' readonly>
                                </div>

                                <div class='renglon'>
                                    <label class='descripciones' for='email'>Email</label>
                                    <input type='email' class='dato' id='email' name='email' title='email' value='{$row['email']}' readonly>
                                </div>

                                <div class='renglon'>
                                    <label class='descripciones' for='prov'>Provincia</label>
                                    <input type='text' class='dato' name='provincia' id='prov' title='provincia' value='{$row['provincia']}' readonly> 
                                    <label class='descripciones' for='provincia' style='display:none'>Provincia</label>
                                    $select
                                </div>

                                <div class='renglon' id='renglonCiudad'>
                                    <label class='descripciones' for='inputCiudad'>Ciudad</label>
                                    <input type='text' id='inputCiudad' class='dato' name='ciudad' title='ciudad' value='{$row['ciudad']}' readonly>
                                    <label class='descripciones' for='ciu' style='display:none;'>Ciudad</label>
                                </div>

                                <div class='renglon'>
                                    <label class='descripciones' for='direccion'>Dirección</label>
                                    <input type='text' class='dato' name='direccion' id='direccion' title='direccion' value='{$row['direccion']}' readonly>
								    <div class='direccion'>
                                        <label for='inputCalle' class='form-label'>Calle</label>
                                        <input type='text' class='dato' name='direccion[]' id='inputCalle' title='Nombre de calle'>
                                        <label for='inputNumero' class='form-label'>Número</label>
                                        <input type='text' class='dato' name='direccion[]' id='inputNumero' title='Número de calle'>
                                        <label for='inputPiso' class='form-label'>Depto</label>
                                        <input type='text' class='dato' name='direccion[]' id='inputPiso' title='Piso y número de departamento'>
                                    </div>
                                </div>";
    }

    $infoPersonal .=            "<div class='renglon' style='border:none;'>
                                    <input type='button' id='modificarDatos' onclick='modDatos($provincia)' class='btn' value='Modificar datos'>
                                    <input type='button' id='cancelar' class='btn' value='Cancelar' style='display:none;'>  
                                    <input type='submit' id='confirmar' class='btn' value='Confirmar' style='display:none;'>
                                </div>";

                                if (isset($_GET['error'])){
                                    $error = $_GET['error'];
                                    $infoPersonal .= "<div class='renglon' style='border:none;'>";

                                    if ($error == '1'){
                                        $infoPersonal .= "<p class='mensaje' id='mensaje'>¡El nombre de usuario ingresado ya existe, reintente con otro por favor!</p>";
                                    }

                                    $infoPersonal .= "</div>";
                                }
                                else if (isset($_GET['modif'])){
                                    $infoPersonal .= "<p class='mensaje' id='mensaje' style='background:#099;'>¡Se ha realizado la modificación con éxito!</p>";
                                }
    $infoPersonal .= "</form>";

?>
<!DOCTYPE html>
<html lang="es">
<head> 
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css"  href="assets/css/estilos.css" rel="stylesheet"/>
    <link rel="icon" type="image/png" href="images/logo_sitio.png">
	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
	<script src="js/funciones.js"></script>
    <title>Muebles Giannis</title>
    <script>
        $(document).ready(function(){
			actualizarCiudad();

            $('#provincia').change (function (){
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

        #direccion{
            border-bottom: none;
        }

        #modificarDatos, #confirmar, #cancelar{
            margin:10px;
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

        #contenedorCiudad{
            display:flex;
            justify-content:center;
        }

        #ciu{
            width:100%;
        }

        #inputNumero, #inputPiso{
            width:8%;
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
            
            .direccion{
                flex-wrap:wrap;
                justify-content:center;
            }
            
            .direccion > .form-label{
                width:100%;
                text-align:center;
            }
        }
    </style>
</head>
<body id="body">
    <header> 
        <?= $encabezado; ?> 
        <?= $encabezado_mobile; ?>
    </header>

    <main>
        <?= $ruta; ?>

        <aside class='contenedor-botones'>
            <?= CONT_USUARIOS; ?>
        </aside>

        <section>
            <?= $infoPersonal; ?>
        </section>

        <?= $modalNovedades; ?>

    </main>

    <footer id='pie'>
		<?= $pie; ?> 
	</footer>
</body>
</html>