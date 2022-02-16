<?php 
    include("encabezado.php");
    include ("inc/conn.php");
    if (!perfil_valido(1)) {
        header("location:index.php");
    }
?>
<!DOCTYPE html>
<?php  
    global $db; 

    //trae los nombres de las categorias
    $sql = "SELECT nombre_categoria
            FROM `categoria` 
            GROUP BY nombre_categoria 
    "; 

    $rs = $db->query($sql); 

    //lista de categorias
    $listas = " 
            <select id='categoria' class='hover' name='categoria'> 
    ";

    $nomCat = "";
    
    foreach ($rs as $row) {
        $listas .= " <option value='{$row['nombre_categoria']}'> {$row['nombre_categoria']} </option> ";
        $nomCat .= $row['nombre_categoria'] . ",";	
    }

    $arrNomCat = explode(",",$nomCat); 

    $listas .= " </select> "; 

	$form="
            <form action=' ' method='post' class='cont-baj'>
                <label for='categoria'>CATEGORÍA</label> <br>
                    $listas
                <br>
                <div class='cont-btn'>
                    <input type='submit' class='btn-enviar' name='enviar' id='enviar' title='Enviar' value='Enviar'> <br>
                </div>
            </form>			   
	";
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Muebles Giannis - Las mejores marcas</title>
    <link rel="stylesheet" type="text/css" href="assets/css/ve_estilos.css" media="screen">
    <script>
		//Validar
	</script>
	<style>
		form{
			width: 300px;
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
    <main>
		<?php echo $form; ?>
	</main>
</body>
</html>