<!DOCTYPE html>
<?php  
    include ('config.php');
    include ("encabezado.php"); 

    if (!perfil_valido(1)) {
        header("location:index.php");
    }
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css"  href="assets/css/ve_estilos.css" rel="stylesheet"/>
    <title>Muebles Giannis - Las mejores marcas</title>
    <style>
        #imagen{
            display:flex;
            align-items:center;
            width: 100%;
            
        }
        #buscar{
            display:flex;
            justify-content: center;
            align-items: center;
            width:80%;
            height:100%;
            margin-left:50px;
        }

        #btn-lupa{
            width:40px;
            height:40px;
            display:flex;
            align-items:center;
            margin-right:20px;
        }

        #header-buscar{
            width:490px;
            margin:0;
        }

        #lupa{
            height:33px;
            border-radius:5px;
        }

        #span{
            margin: auto;
        }

        #barra_superior{
            display:flex;
            justify-content:center;
            align-items:center;
            width: 160px;
            font-size: 1.3rem;
            background-color: #40D6E5;
            border-radius: 5px;
            height:30px;
        }

        #cerrar{
            padding:4px 5px 5px;
            text-decoration: none;
            color: white;
            background-color:black;
            height:20px;
            border-radius: 5px;
            margin:auto;
        }

        #contenedor-botones{
            width: 100%;
            background-color: #000;
        }

        main{
            display:flex;
            align-items: center;
            height:500px;
            background-color: #000;
        }
    </style>
</head>

<body id='body'>
    <header>
		<?php echo $encab; ?>
	</header>
    <main>
        <div id="contenedor-botones">
            <button class="btn hover" onclick="window.location.href='ve_prod_alta.php'">ALTA <BR> Productos</button>
            <button class="btn hover" onclick="window.location.href='ve_prod_baja.php'">BAJA <BR> Productos</button>
            <button class="btn hover" onclick="window.location.href='ve_prod_mod.php'">MODIFICACIÓN Productos</button>
        </div>
    </main>
</body>
</html>