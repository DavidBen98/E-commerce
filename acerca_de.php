<!DOCTYPE html>
<?php 
	include('config.php');
	include ("encabezado.php");
    include("pie.php");

    if (perfil_valido(1)) {
        header("location:ve.php");
    }
?>
<html lang="es">
<head>   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Catato Hogar</title>
    <link rel="stylesheet" type="text/css" href="css/estilos.css" media="screen">
    <style>
        #main{
            display:flex;
            justify-content:center;
            height:270px;
            padding-bottom: 30px;
        }

        #cont-acerca{
            width:400px;
            display:flex;
            justify-content:center;
            flex-wrap: wrap;
            background-color: white;
            padding-left:0;
            border: 2px solid #000;
            border-radius: 5px;
        }

        #cont-acerca h1 {
            width: 100%;
            height: 50px;
            padding: 10px 0;
            margin: 0;
            border-bottom: 1.5px solid black;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        main ul {
            list-style:none;
            padding: 0;
            height: 197px;
            margin:0;
        }

        #cont-acerca li{
            width:400px;
            text-align:center;
        }
    </style>
</head> 
<body>
    <header>
        <?php echo $encab; ?>
    </header>

    <main id="main">
        <div id="cont-acerca"> 
            <h1>Hecho por</h1>
            <ul >              
                <li> Maciel Fanny </li>
                <li> Benedette David </li>
            </ul>
        </div>
    </main>
  	
    <?php 
        echo $pie;
    ?>
    
</body>
</html>