<?php 
    require_once "../controlador/config.php";
    include "../inc/conn.php";
    include "encabezado.php"; 
    include "modalNovedades.php";
    include "pie.php";

    if (perfil_valido(3)) {
        header("location:index.php");
        exit;
    }
    else if (perfil_valido(1)) {
        header("location:veABMProducto.php");
        exit;
    } 
                 
    if (isset($_SESSION["idUsuario"])){ //si se inició sesion desde una cuenta nativa
        $id_usuario = $_SESSION["idUsuario"];
    }
    else if (isset($_SESSION["id"])){ //Si se inicio sesion desde Google
        $id_usuario = $_SESSION["id"];
    }
    else if (isset($_SESSION["id_tw"])){ //Si se inicio sesion desde twitter
        $id_usuario = $_SESSION["id_tw"];
    }

    $rs = obtener_consultas($id_usuario);

    $consulta = "
        <div class='consulta'>
            <div class='renglon renglon-consultas'>      
                <h1>
                    Consultas realizadas
                </h1>
            </div>         
    ";

    $i = 0;
    foreach ($rs as $row){
        $i++;
    }

    if ($i == 0){
        $consulta .= "<p>Aún no hay consultas realizadas </p>";
    }
    else{
        $consulta .= "
            <div class='renglon renglon-consultas'>      
                <p><b>Consulta</b></p>
                <p><b>Respuesta</b></p>
            </div> 
        ";
        
        $rs = obtener_consultas($id_usuario);

        foreach ($rs as $row) { 
            if ($row["respondido"]){
                $respuesta = "Ha sido contestada la consulta";
            }
            else{
                $respuesta = "Pendiente";
            }
            
            $pregunta = ucfirst($row["texto"]);
    
            $consulta .= "   
                <div class='renglon renglon-consultas'> 
                    <p>$pregunta</p>
                    <p>$respuesta</p>
                </div>
            ";
        }
    }

    $consulta .= "
            <div class='renglon'> 
                <button class='btn' id='nueva-consulta'>Nueva consulta </button>
            </div>
        </div>
    ";
?>
<!DOCTYPE html>
<html lang="es">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css"  href="../assets/css/estilos.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="../images/iconos/logo_sitio.png">
    <title>Muebles Giannis</title>   
    <script src="../js/funciones.js"></script>
    <style>
        main{
            display:flex;
            flex-wrap: wrap;
            justify-content:start;
        }
        
        .contenedor-btn div:hover{
            cursor: pointer;
            background-color: rgba(147, 81, 22,0.2);
            transition: all 0.3s linear;
        }

        .consulta{
            width:60%;
            background-color:white;
            display:flex;
            flex-wrap:wrap;
            justify-content: center;
            border-radius:5px;
            border: 1px solid black;
            margin-bottom: 10%;
            margin-left: 5%;
            padding: 0 4%;
        }

        .consulta p{
            width: 45%;
            text-align: center;
            margin: 1%;
            padding: 1%;
        }

        .renglon{
            width:100%;
            display:flex;
            justify-content:center;
            margin:0;
        }

        .renglon-consultas{
            border-bottom:1px solid #858585; 
            height:50px;
            align-items: center;
        }

        .renglon-consultas p{
            border-right: 1px solid #d3d3d3;
        }

        .renglon-consultas h1{
            margin: 0; 
            display: flex; 
            align-items: center; 
            font-family: museosans500,arial,sans-serif; 
            font-size:1.6rem;
        }

        #nueva-consulta{
            margin:15px;
            border: 1px solid #000;
        }

        .ruta li:first-child{
			margin-left:5px;
		}

        .ruta li:last-child{
			border:none;
			text-decoration: none;
		}
        
        @media screen and (max-width: 860px){
            .consulta{
                width: 90%;
                margin: 0 auto 2%;
            }
        }
    </style>
</head>
<body id="body">
    <header>
        <?= imprimir_encabezado($encabezado, $encabezado_mobile); ?>
    </header>

    <main>
        <ol class="ruta">
            <li><a href="index.php">Inicio</a></li>
            <li>Consulta de usuario</li>
        </ol>
        
        <aside class="contenedor-botones">
            <?= CONT_USUARIOS; ?>
        </aside>

        <?= $consulta; ?>  
        <?= $modal_novedades; ?> 
        <?= $modal_novedades_error; ?>
    </main>

    <footer id="pie">
		<?= $pie; ?> 
	</footer>
</body>
</html>