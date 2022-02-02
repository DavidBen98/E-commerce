<?php 
    include("encabezado.php");
    if (!perfil_valido(1)) {
        header("location:index.php");
    }
?> 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/ve_estilos.css" media="screen">
    <title>Muebles Giannis - Las mejores marcas</title>
    <style>
        main{
            background-color: #00008B;
            height: 500px;
        }

        button{
            cursor: pointer;
            width:200px;
        }

        main > a{
            cursor: pointer;
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
    </style>
</head>
<body>
    <header>
        <?php echo $encab; ?>
	</header> 
    <main>
        
        <input type='button' onclick="window.location.href='ve_prod_alta.php'" class='btn btn-secondary btn-lg' name='bCambiarCarac' id='bCambiarCarac' title='Cambiar caracteristicas' value='Cambiar caracteristicas'>
        <input type='button' onclick="window.location.href='ve_prod_mod_ubicacion.php'" class='btn btn-secondary btn-lg' name='bCambiarUbica' id='bCambiarUbica' title='Cambiar Ubicacion' value='Cambiar Ubicacion'>
             
    </main>
</body>
</html>