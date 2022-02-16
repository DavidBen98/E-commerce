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
    <link rel="stylesheet" type="text/css" href="assets/css/ve_estilos.css" media="screen">
    <title>Muebles Giannis - Las mejores marcas</title>
    <style>
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
        //Validar
    </script>
</head>
<body>
    <header>
        <?php echo $encab; ?>
	</header>
    <main>
        <?php  
            $path_archivo ='images/categorias/cod_categorias.txt';  

            if (file_exists($path_archivo)) {
                $f = fopen($path_archivo,'r');    	 
                echo "  
                        <form action=' ' method='post'>  
                            <select class='form-select' aria-label='Default select example' id='categoria'>
                                    <option value='-1'selected> &#60;&#60;Seleccione una categoria &#62;&#62;</option>
                            ";

                            $i = -1;
                            while (!feof($f) ) {  
                                $linea = fgets($f);   			 
                                $arr = explode('|',$linea);
                                echo "                             	 
                                        <option value='$i++'> $arr[1]</option>          	 
                                ";
                            }
                            echo "
                                </select>   

                                <select id='subcategoria' name='subcategoria'>
                                </select>

                                <br>

                                <div class='contenedor'>
                                    <label for='nombre'class='col-sm-2 form-label'>Nombre</label>
                                    <div class='cont-input'>
                                        <input type='text' class='form-control' name='nombre' id='nombre' title='Nombre' value=''>
                                    </div>
                                </div>

                                <div class='contenedor'>
                                    <label for='inputIMG'class='col-sm-2 form-label'>Importar imagen</label>
                                    <div class='cont-input'>
                                        <input type='file' class='form-control' id='inputIMG' aria-describedby='inputGroupFileAddon04' aria-label='Upload'>      	 
                                    </div>           	 
                                </div>

                                <div class='contenedor'>      	 
                                    <input type='submit' class='btn btn-secondary btn-lg' name='Aceptar' id='Aceptar' title='Aceptar' value='Aceptar'>     	 
                                </div>
                        </form>
                    ";
                fclose($f);
            } 	 
	    ?>
    </main> 
</body>
</html>