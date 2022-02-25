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
    <link type="text/css"  href="assets/css/estilos.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="assets/css/ve_estilos.css" media="screen">
    <title>Muebles Giannis - Las mejores marcas</title>
    <script>
        //Validar
    </script>
</head>
<body>
    <header id='header'>
        <?php echo $encab; ?>
	</header>
    <main>
        <?php  
            echo "  
                <form action=' ' method='post'>  
                    <select class='form-select' aria-label='Default select example' id='categoria'>
                            <option value='-1'selected> &#60;&#60;Seleccione una categoria &#62;&#62;</option>
                    
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
	    ?>
    </main> 
</body>
</html>