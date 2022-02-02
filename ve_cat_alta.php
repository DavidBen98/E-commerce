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
        .contenedor{
            display:flex;
            width:500px;
        }

        input{
            width:300px;
        }

        main div{
			height:100px;
			width:300px;
		}

        form{
            display:flex;
            width: 500px;
            flex-wrap: wrap;
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

        .col-sm-2{
            display:block;
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
        <?php echo "
                    <form action=' ' method='post'>
                        <div class='contenedor'>
                            <label for='nombre'class='col-sm-2 form-label'>Nombre</label>
                            <div class='cont-input'>
                                <input type='' class='form-control' name='nombre' id='nombre' title='Nombre' value=''> 
                            </div>
                        </div>
                        <input type='file' class='form-control' id='inputGroupFile04' aria-label='Upload'>           
                        <input type='submit' class='btn btn-secondary btn-lg' name='bAceptar' id='bAceptar' title='bAceptar' value='Aceptar'>          
                    </form> 
                "; 
        ?> 
    </main>
</body>
</html>