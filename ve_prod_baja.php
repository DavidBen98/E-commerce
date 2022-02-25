<?php 
    include("encabezado.php");
    require 'inc/conn.php';
    
    if (!perfil_valido(1)) {
        header("location:index.php");
    }
?>
<!DOCTYPE html>
<?php  
        $form="
				<form class='cont'>
					<label for='cod-img'>CODIGO-IMAGEN</label> <br>

					<select name='cod-img' class='hover'>						
					</select>	

					<div class='cont-btn'>
						<input type='submit' class='btn-enviar hover' name='enviar' id='enviar' title='Enviar' value='Enviar'> <br>
					</div>
				</form>			   
	";
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Muebles Giannis - Las mejores marcas</title>
    <link type="text/css"  href="assets/css/estilos.css" rel="stylesheet"/>
    <link type="text/css"  href="assets/css/ve_estilos.css" rel="stylesheet"/>

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
			echo $form;
		?>
	</main>
</body>
</html>