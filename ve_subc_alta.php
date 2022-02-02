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
        .cont{
			width:800px;
		}

		.cont-btn{
			display:flex;
			justify-content:center;
		}

        label{
            color:white;
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

        form{
            width:600px;
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
    <script>
    </script>
</head>
<body>
    <header>
        <?php echo $encab; ?>
	</header>
    <main>
        <form class="cont" enctype="multipart/form-data">
            
            <?php crearListaCategorias(); ?>	

			<br>

            <!--<label for="cod-img">CODIGO-IMAGEN</label> <br>
            <select name="cod-img" class="hover">						
            </select>	-->
          
            <input type="button" name="bImportImg" id="bImportImg" title="Importar Imagen" value="Importar Imagen"> <br>
            <input type="text" name="tNombre" id="tNombre" title="Ingrese el nombre de la subcategoria" value=""> <br>
            <input type="submit"  name="bAgregarSubCat" id="bAgregarSubCat" title="Agregar subcategoria" value="Agregar subcategoria"> <br>
            
        </form>	

    </main> 
</body>
</html>