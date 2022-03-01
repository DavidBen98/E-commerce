<?php 
    include ('config.php');
    include("encabezado.php"); 
    include("pie.php");
    include ("inc/conn.php");

    if (perfil_valido(3)) {
        header("location:index.php");
    }
    else if (perfil_valido(1)) {
        header("location:veABMProducto.php");
    } 
                 
    global $db;
    
    $mail = "";

    if (isset($_SESSION['user_email_address'])){
        $mail =$_SESSION['user_email_address'];
    }
    else if (isset($_SESSION['email'])){
        $mail =$_SESSION['email'];
    }

    $sql= "SELECT c.texto, c.respondido
            FROM `consulta` as c INNER JOIN `usuario` as u ON (c.email = u.email)
            WHERE c.email='$mail'
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
                        </div>";
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
        
        .contenedor-botones{
            width:20%;
            display:block;
            margin: 0 80px 30px 20px;
            border-radius: 5px;
            padding:0;
            background-color: rgba(0, 0, 0,0);
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
            margin-bottom: 30px;
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
    </style>
</head>
<body id="body">
    <header>
        <?php echo $encab; ?> 
    </header>

    <main>
        <ol class='ruta'>
            <li style='margin-left:5px;'><a href='index.php'>Inicio</a></li>
            <li style='border:none;text-decoration: none;'>Consulta de usuario</li>
        </ol>
        
        <aside class='contenedor-botones'>
            <?= $cont_usuarios; ?>
        </aside>

        <?= $div; ?>  
    </main>

    <footer id='pie'>
		<?= $pie; ?> 
	</footer>
</body>
</html>