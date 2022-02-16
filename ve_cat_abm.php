<?php 
    include("encabezado.php");
    if (!perfil_valido(1)) {
        header("location:index.php");
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/ve_estilos.css" media="screen">
    <title>Muebles Giannis - Las mejores marcas</title>
    <style>
        main{
            height:470px;
        }

        .cont{
            display:flex;
            width:1300px;
            height:500px;
            background-color: #000;
            margin:auto;
        }

        label{
            color:white;
            width:100%;
        }

        main div{
			background-color:white;
			height:100px;
			width:300px;
		}

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
            width:110px;
            margin: auto;
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

        .cont-cat{
            background-color: #000;
            width:400px;
        }
    </style>
</head>
<body>
    <header>
        <?php echo $encab; ?>
	</header>
    <main id='main'>
        <div class='cont'>
            <div class='cont-cat'>
                <button class='btn hover' onclick="window.location.href='ve_cat_alta.php'">ALTA <BR> Categorías</button>
                <button class='btn hover' onclick="window.location.href='ve_cat_baja.php'">BAJA <BR> Categorías</button>
                <button class='btn hover' onclick="window.location.href='ve_cat_mod.php'">MODIFICACIÓN Categorías</button>
            </div>

            <div class='cont-cat'>
                <button class='btn hover' onclick="window.location.href='ve_subc_alta.php'">ALTA <BR> Subcategorías</button>
                <button class='btn hover' onclick="window.location.href='ve_subc_baja.php'">BAJA <BR> Subcategorías</button>
                <button class='btn hover' onclick="window.location.href='ve_subc_mod.php'">MODIFICACIÓN Subcategorías</button>
            </div>
        </div>
    </main>
</body>
</html>