<?php 
    include("pie.php");  
    include ("inc/conn.php");
    include ('config.php');
    include("encabezado.php"); 

    if (perfil_valido(3)) {
       header("location:index.php");
    }
    else if (perfil_valido(1)) {
        header("location:ve.php");
    }  

    global $db; 
    $nombreUser = $_SESSION['user'];

    $sql= "SELECT nombreUsuario, perfil, nroDni, nombre, apellido, email, provincia, ciudad, direccion
            FROM `usuario`
            WHERE nombreUsuario='$nombreUser'
    "; 
 
    $rs = $db->query($sql);

    $infoPersonal = "";
    foreach ($rs as $row) {
        $infoPersonal = "<div class='cont-perfil'> 
                            Nombre de usuario: {$row['nombreusuario']} <br>
                            Numero de DNI: {$row['nrodni']} <br>
                            Nombre: {$row['nombre']} <br>
                            Apellido: {$row['apellido']} <br>
                            Email: {$row['email']} <br>
                            Provincia: {$row['provincia']} <br>
                            Ciudad: {$row['ciudad']} <br>
                            Direccion: {$row['direccion']} <br>
                        </div>
        ";
    }
?>
<!DOCTYPE html>
<html lang="es">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css"  href="css/estilos.css" rel="stylesheet"/>
    <title>Catato Hogar</title>   
    <style>
        main{
            display:flex;
            justify-content:center;
            flex-wrap:wrap;
        }

        .cont-perfil{
            margin: 40px 0;
        }

        .btn{
		   background-color: #D3D3D3;
		   height: 40px;
		   width:200px;
		   cursor:pointer;
		   font-size:1.2rem;
		   border-radius: 5px;
		}

		.btn:hover{
			background-color: #B2BABB ;
            transition: all 0.3s linear;
            color: white;
            cursor:pointer;
		}

    </style>

</head>
<body id="body">
    <header> 
        <?php echo $encab; ?> 
    </header>

    <main>
        <?php echo $cont_usuarios;?>
        <?php echo  $infoPersonal;?>
    </main>

    <?php
        echo $pie;
    ?>
</body>
</html>