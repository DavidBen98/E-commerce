<?php 
    require_once 'config.php';
    include("encabezado.php"); 
    include("pie.php");
    include("modalNovedades.php");
    include ("inc/conn.php");

    if (perfil_valido(3)) {
        header("location:index.php");
    }
    else if (perfil_valido(1)) {
        header("location:veABMProducto.php");
    } 
                 
    global $db;
    
    if (isset($_SESSION['idUsuario'])){ //si se inició sesion desde una cuenta nativa
        $idUsuario = $_SESSION['idUsuario'];
    }
    else if (isset($_SESSION['id'])){ //Si se inicio sesion desde Google
        $idUsuario = $_SESSION['id'];
    }
    else if (isset($_SESSION["id_tw"])){ //Si se inicio sesion desde twitter
        $idUsuario = $_SESSION["id_tw"];
    }

    $sql= "SELECT c.texto, c.respondido
            FROM `consulta` as c INNER JOIN `usuario` as u ON (c.usuario_id = u.id)
            WHERE c.usuario_id='$idUsuario'
    "; 

    $rs = $db->query($sql);

    $div = "<div class='consulta'>
                <div class='renglon' style='border-bottom:1px solid #858585; height:50px;'>      
                    <h1 style='margin: 0; display: flex; align-items: center; font-family: museosans500,arial,sans-serif; font-size:1.6rem;'>
                        Consultas realizadas
                    </h1>
                </div>         
    ";
    $i = 0;

    foreach ($rs as $row){
        $i++;
    }

    if ($i == 0){
        $div .= "<p>Aún no hay consultas realizadas </p>";
    }
    else{
        $div .= "<div class='renglon' style='border-bottom:1px solid #858585;'>      
                    <p><b>Consulta</b></p>
                    <p><b>Respuesta</b></p>
                </div> 
        ";
        
        $rs = $db->query($sql);

        foreach ($rs as $row) { 
            $respuesta = "";                     
            if ($row['respondido']){
                $respuesta = "Ha sido contestada la consulta";
            }
            else{
                $respuesta = "Pendiente";
            }
            
            $pregunta = ucfirst($row['texto']);
    
            $div .= "   <div class='renglon' style='border-bottom: 1px solid #D3D3D3;'> 
                            <p style='border-right: 1px solid #d3d3d3;'>$pregunta</p>
                            <p>$respuesta</p>
                        </div>
            ";
        }
    }

    $div .= "<div class='renglon' style='border-bottom: 1px solid #D3D3D3;'> 
                <button class='btn' id='nuevaConsulta' style='margin:15px;'>Nueva consulta </button>
            </div>
    </div>";
?>
<!DOCTYPE html>
<html lang="es">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css"  href="assets/css/estilos.css" rel="stylesheet"/>
    <link rel="icon" type="image/png" href="images/logo_sitio.png">
    <title>Muebles Giannis</title>   
    <script src="js/funciones.js"></script>
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
            padding: 0 10px;
        }

        .consulta p{
            width:45%;
            text-align:center;
            margin: 5px;
            padding: 5px;
        }

        .renglon{
            width:100%;
            display:flex;
            justify-content:center;
            margin:0;
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
        <?= $encabezado; ?> 
        <?= $encabezado_mobile; ?>
    </header>

    <main>
        <ol class='ruta'>
            <li style='margin-left:5px;'><a href='index.php'>Inicio</a></li>
            <li style='border:none;text-decoration: none;'>Consulta de usuario</li>
        </ol>
        
        <aside class='contenedor-botones'>
            <?= CONT_USUARIOS; ?>
        </aside>

        <?= $div; ?>  
        <?= $modalNovedades; ?>
    </main>

    <footer id='pie'>
		<?= $pie; ?> 
	</footer>
</body>
</html>