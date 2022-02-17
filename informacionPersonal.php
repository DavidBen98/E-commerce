<?php 
    include("pie.php");  
    include ("inc/conn.php");
    include ('config.php');
    include("encabezado.php"); 

    if (perfil_valido(3)) {
       header("location:index.php");
    }
    else if (perfil_valido(1)) {
        header("location:ve.php");
    }  

    global $db; 
    
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
        $prov = isset($row['provincia'])? $row['provincia'] : null;
        $prov = json_encode($prov);

        $ciudad =  isset($row['ciudad'])? $row['ciudad'] : null;
        $ciudad = json_encode ($ciudad);
        
        include('apiDatos.php');

        $infoPersonal = "<form action='modificarPerfil.php' method='post' class='cont-perfil'> 
                                <div class='renglon'>
                                    <p class='descripciones'>Nombre de usuario</p>
                                    <input type='text'  class='dato' name='nombreUsuario' title='nombreUsuario' value='{$row['nombreusuario']}' readonly>
                                </div>

                                <div class='renglon'>
                                    <p class='descripciones'>Número de DNI</p>
                                    <input type='number' class='dato' name='dni' title='dni' value='{$row['nrodni']}' readonly>
                                </div>

                                <div class='renglon'>
                                    <p class='descripciones'>Nombre</p>
                                    <input type='text' class='dato' name='nombre' title='nombre' value='{$row['nombre']}' readonly>
                                </div>

                                <div class='renglon'>
                                    <p class='descripciones'>Apellido</p>
                                    <input type='text' class='dato' name='apellido' title='apellido' value='{$row['apellido']}' readonly>
                                </div>

                                <div class='renglon'>
                                    <p class='descripciones'>Email</p>
                                    <input type='email' class='dato' name='email' title='email' value='{$row['email']}' readonly>
                                </div>

                                <div class='renglon'>
                                    <p class='descripciones'>Provincia</p>
                                    <input type='text' class='dato' name='provincia' id='prov' title='provincia' value='{$row['provincia']}' readonly> 
                                    $select
                                </div>

                                <div class='renglon' id='ciudad'>
                                    <p class='descripciones'>Ciudad</p>
                                    <input type='text' id='inputCiudad' class='dato' name='ciudad' title='ciudad' value='{$row['ciudad']}' readonly>
                                </div>

                                <div class='renglon'>
                                    <p class='descripciones'>Dirección</p>
                                    <input type='text' class='dato' name='direccion' title='direccion' value='{$row['direccion']}' readonly>
                                </div>";
    }

    $infoPersonal .=            "<div class='renglon' style='border:none;'>
                                    <input type='button' id='modificarDatos' onclick='modDatos($prov)' class='btn' value='Modificar datos'>
                                    <input type='button' id='cancelar' onclick='modDatos()' class='btn' value='Cancelar' style='display:none;'>  
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
        function modDatos(provincia){
            let input = document.getElementsByClassName('dato');
            let confirmar = document.getElementById('confirmar');
            let cancelar = document.getElementById('cancelar');
            let modificar = document.getElementById('modificarDatos');
            let mensaje = document.getElementById ('mensaje');

            if (input[0].readOnly){
                for (let i=0; i< input.length; i++){
                    if (i !== 4){
                        input[i].readOnly = false;
                        input[i].style.border = '1px solid #000';
                        input[i].style.borderRadius = '5px';
                    }
                }
                confirmar.style.display = 'block';
                cancelar.style.display = 'block';
                modificar.style.display = 'none';

                if (mensaje != null){
                    mensaje.style.display = 'none';
                }

                let selectProvincia = document.getElementById('provincia');
                selectProvincia.style.display = 'block';
                document.getElementById('prov').style.display = 'none';

                for (let i=0; i<selectProvincia.length;i++){
                    if (selectProvincia[i].innerHTML == provincia){
                        selectProvincia[i].selected = true;
                    }
                }

                actualizarCiudad();
                let inputCiudad = document.getElementById('inputCiudad');
                inputCiudad.style.display = 'none';
            }
            else{
                location.reload();
            }
        }

        //$(document).ready(function(){
            $('#provincia').change (function (){
                actualizarCiudad();
            });
		//});

		function actualizarCiudad (ciudad){
			$.ajax ({
				type: "POST",
				url: "rellenarSelect.php",
				data: "prov=" + $('#provincia').val() + "ciudad=" + $('#inputCiudad').val(),
				success: function (datos){
                    let contenedorCiudad = document.getElementById('ciudad');
                    let div = document.createElement('div');
                    let select = datos['select'];
                    console.log(select);
                    // div.innerHTML = select;
                    // contenedorCiudad.appendChild(div);

                    // let selectCiudad = document.getElementById('ciu');
                    
                    // for (let i=0; i<selectCiudad.length;i++){
                    //     if (selectCiudad[i].value == datos->ciudad){
                    //         selectCiudad[i].selected = true;
                    //     }
                    //     else{
                    //         console.log (selectCiudad[i].value);
                    //     }
                    // }
				}
			});
		}	
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

        .contenedor-botones{
            width:20%;
            display:block;
            margin: 0 80px 0 20px;
        }

        .contenedor-btn{
            width:100%;
            background-color: white;
            border-radius: 5px;
            text-align:center;
            border: 1px solid #000;
            transition: all 0.3s linear;
        }

        .contenedor-btn div{
            width:100%;
            text-align:center;
            border-bottom: 1px solid #d3d3d3;
            transition: all 0.3s linear;
            padding: 10px 0;
        }

        .contenedor-btn div:hover{
            cursor: pointer;
            background-color:  rgba(147, 81, 22,0.2);
            transition: all 0.3s linear;
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

        #provincia{
            display:none;
            text-align:center;
            background-color: white;
            width: 45%;
            margin: 10px;
            padding: 5px;
            text-align: center;
            font-family: "Salesforce Sans", serif;
            font-size: 1.1rem;
            line-height: 1.5em;
            border-radius:5px;
        }
    </style>
</head>
<body id="body">
    <header> 
        <?php echo $encab; ?> 
    </header>

    <main>
        <?php 
            echo "<ol class='ruta'>
                    <li style='margin-left:5px;'><a href='index.php'>Inicio</a></li>
                    <li style='border:none;text-decoration: none;'>Datos personales</li>
                  </ol>
            ";
            echo "<div style='display:flex; justify-content:start;'>
                    <div class='contenedor-botones'>
                        $cont_usuarios
                    </div>
                        $infoPersonal
                 </div>";
        ?>
    </main>

    <?php
        echo $pie;
    ?>
</body>
</html>