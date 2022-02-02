<?php 
    include("encabezado.php");
    if (!perfil_valido(1)) {
        header("location:index.php");
    }
?>
<!DOCTYPE html>
<?php 
    $prod = "<div class='contenedor'>
                <label for='codigo' class='col-sm-2 form-label'>Código</label>
                <div class='cont-input'>
                    <input type='text' name='codigo' readonly class='form-control-plaintext' id='codigo' title='Código' value='' readonly> 
                </div>
            </div>

            <div class='contenedor'>
                <label for='descripcion' class='col-sm-2 form-label'>Descripción</label>
                <div class='cont-input'>
                    <input type='text' class='form-control' name='descripcion' id='descripcion' title='Descripción' value=''>
                </div>
            </div>
                    
            <div class='contenedor'>
                <label for='material' class='col-sm-2 form-label'>Material</label>
                <div class='cont-input'>
                    <input type='text' class='form-control' name='material' id='material' title='Material' value=''>
                </div>
            </div>

            <div class='contenedor'>
                <label for='color' class='col-sm-2 form-label'>Color</label>
                <div class='cont-input'>
                    <input type='text' class='form-control' name='color' id='color' title='Color' value=''> 
                </div>
            </div>

            <div class='contenedor'>
                <label for='medidaAl' class='col-sm-2 form-label'>Caracteristicas</label>
                <div class='cont-input'>
                    <input type='text' class='form-control' name='Caracteristicas' id='Caracteristicas' title='Caracteristicas' value=''>
                </div>
            </div>

            <div class='contenedor'>
                <label for='marca' class='col-sm-2 form-label'>Marca</label>
                <div class='cont-input'>
                    <input type='text' class='form-control' name='marca' id='marca' title='Marca' value=''> 
                </div>
            </div>

            <div class='contenedor'>
                <label for='cant' class='col-sm-2 form-label'>Cantidad</label>
                <div class='cont-input'>
                    <input type='text' class='form-control' name='cant' id='cant' title='Cantidad' value=''>  
                </div>
            </div>

            <div class='cont-input'>
                <input type='submit' name='aceptar' class='btn-enviar hover' title='' value='Aceptar'>
            </div>
    ";
?>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Muebles Giannis - Las mejores marcas</title>
    <link type="text/css"  href="css/ve_estilos.css" rel="stylesheet"/>
    <script>
		//Validar
	</script>
    <style>
        #main{
            height:800px;
            padding-top:20px;
            background-color:white;
        }

        body{
            background-color:white;
        }

        main div{
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
    </style>
</head>
<body>
    <header>
        <?php echo $encab; ?>
	</header>
    <main id='main'>
        <form class='cont'>
            <?php 
                echo $prod; 
            ?>
        </form>
    </main>
</body>
</html>