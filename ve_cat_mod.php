<?php 
    include("encabezado.php");
    include("pie.php");
    include ("inc/conn.php");
    if (!perfil_valido(1)) {
        header("location:index.php");
    }

        global $db;
        $sql = "SELECT nombre_categoria
        FROM `categoria`
        GROUP BY nombre_categoria"; 
        
        $rs = $db->query($sql);
      
        $form = "  
                        <form action=' ' method='post'>  
                            <select class='form-select' aria-label='Default select example' id='categoria'>
                                    <option value='-1'selected> &#60;&#60;Seleccione una categoria &#62;&#62;</option>
                            ";

        foreach ($rs as $row) { //categorias
            $nomCat =  $row['nombre_categoria'];
            $form .= "                             	 
                 <option value=''>$nomCat </option>          	 
             ";
        }

        $form .= "  </select>
                <div class='contenedor'>
                <label for='nombre'class='col-sm-2 form-label'>Nombre</label>
                <div class='cont-input'>
                    <input type='text' class='form-control' name='nombre' id='nombre' title='Nombre' value=''>
                </div>
                </div>

                <div class='contenedor'>
                <label for='inputIMG'class='col-sm-2 form-label'>Importar imagen</label>
                <div class='cont-input'>
                    <input type='file' class='form-control' id='inputIMG'  aria-label='Upload'>      	 
                </div>           	 
                </div>

                <div class='contenedor'>      	 
                    <input type='submit' class='btn btn-secondary btn-lg' name='bAceptar' id='bAceptar' title='bAceptar' value='Aceptar'>     	 
                </div>
        </form>";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/ve_estilos.css" media="screen">
    <title>Muebles Giannis - Las mejores marcas</title>
    <script>
		//Validar
	</script>
    <style>
        label{
            color:white;
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

        form{
            width:600px;
        }
    </style>
</head>
<body>
    <header>
        <?php echo $encab; ?>
	</header>
    <main>
        <?php echo $form; ?>
    </main> 
    <footer>
        <?php echo $pie; ?>
    </footer>
</body>
</html>