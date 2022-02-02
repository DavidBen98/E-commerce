<?php 
    include("encabezado.php");
    require 'inc/conn.php';
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
        "; 

        $rs = $db->query($sql); 

        //lista de categorias
        $listas = " 
                <label for='categoria'>CATEGORIA</label> <br>
                <select id='categoria' class='hover' name='categoria'> 
        ";

        $nomCat = "";
        
        foreach ($rs as $row) {
            $listas .= " <option value='{$row['nombre_categoria']}'> {$row['nombre_categoria']} </option> ";
            $nomCat .= $row['nombre_categoria'] . ",";	
        }

        $arrNomCat = explode(",",$nomCat); 

        //lista subcategorias
        $listas .= "  </select> <br>
                    <label for='subcategoria'>SUBCATEGORIA</label> <br>
                <select name='subcategoria' class='hover'> 
        ";    
          
        foreach ($arrNomCat as $valor) {
            $nomCat = $valor;  

            $sql1 = "SELECT nombre_subcategoria
                    FROM `subcategoria`
                    WHERE nombre_categoria='$nomCat'
            "; 
            
            $rs1 = $db->query($sql1);

            foreach ($rs1 as $row1) {                         
                $listas .= " <option value='{$row1['nombre_subcategoria']}'> $nomCat - {$row1['nombre_subcategoria']} </option> ";                                    
            }
        }

        $listas .= " </select> "; 

        $form="
				<form class='cont'>
					
                    ".$listas  ."
					<br>

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
    <link type="text/css"  href="css/ve_estilos.css" rel="stylesheet"/>
    <style>
		.cont{
			width:400px;
		}

		.cont-btn{
			display:flex;
			justify-content:center;
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
			echo $form;
		?>
	</main>
</body>
</html>