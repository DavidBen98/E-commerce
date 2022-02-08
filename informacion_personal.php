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
    
    if (isset($_SESSION['idUsuario'])){
        $idUsuario = $_SESSION['idUsuario'];
    }
    else if (isset($_SESSION['user'])){
        $idUsuario = $_SESSION['user'];
    }
    else if ($_SESSION['id_tw']){
        $idUsuario = $_SESSION['id_tw'];
    }

    $sql= "SELECT nombreUsuario, perfil, nroDni, nombre, apellido, email, provincia, ciudad, direccion
            FROM `usuario`
            WHERE id='$idUsuario'
    "; 
 
    $rs = $db->query($sql);

    $infoPersonal = "";
    foreach ($rs as $row) {
        $infoPersonal = "<div class='cont-perfil'> 
                                <div class='renglon'>
                                    <p class='descripciones'>Nombre de usuario</p>
                                    <p class='dato'>{$row['nombreusuario']} </p>
                                </div>
                                <div class='renglon'>
                                    <p class='descripciones'>Número de DNI</p>
                                    <p class='dato'>{$row['nrodni']} </p>
                                </div>
                                <div class='renglon'>
                                    <p class='descripciones'>Nombre</p>
                                    <p class='dato'>{$row['nombre']} </p>
                                </div>
                                <div class='renglon'>
                                    <p class='descripciones'>Apellido</p>
                                    <p class='dato'>{$row['apellido']} </p>
                                </div>
                                <div class='renglon'>
                                    <p class='descripciones'>Email</p>
                                    <p class='dato'>{$row['email']} </p>
                                </div>
                                <div class='renglon'>
                                    <p class='descripciones'>Provincia</p>
                                    <p class='dato'>{$row['provincia']} </p>
                                </div>
                                <div class='renglon'>
                                    <p class='descripciones'>Ciudad</p>
                                    <p class='dato'>{$row['ciudad']} </p>
                                </div>
                                <div class='renglon' id='direccion'>
                                    <p class='descripciones'>Dirección</p>
                                    <p class='dato'>{$row['direccion']} </p>
                                </div>

                                <input type='button' id='btn-enviar' onclick='modificarDatos()' class='btn' value='Modificar datos'>

                        </div>
        ";
    }
?>
<!DOCTYPE html>
<html lang="es">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/logo_sitio.png">
    <link type="text/css"  href="css/estilos.css" rel="stylesheet"/>
    <script src="js/funciones.js"></script>
    <title>Muebles Giannis</title>   
    <style>
        main{
            display:flex;
            justify-content:center;
            flex-wrap:wrap;
        }

        .cont-perfil{
            display:flex;
            flex-wrap:wrap;
            justify-content: center;
            width: 60%;
            border-radius:5px;
            padding:10px;
            background-color:white;
            border: 1px solid black;
            margin-bottom: 30px;
        }

        .descripciones{
            background-color:white;
            border-right: 1px solid #D3D3D3;
            width:45%;
            margin:5px;
            padding: 5px;
        }

        .dato{
            background-color:white;
            width:45%;
            margin:5px;
            padding: 5px;
        }

        p{
            text-align:center;
        }

        .renglon{
            width:100%;
            display:flex;
            justify-content:center;
            margin:0;
            border-bottom: 1px solid #D3D3D3;
        }

        #direccion{
            border-bottom: none;
        }

        #btn-enviar{
            margin:10px;
        }

        .contenedor-botones{
            width:20%;
            display:block;
            margin: 0 80px 0 20px;
        }

        .contenedor-btn{
            width:100%;
            background-color: white;
            border-radius: 5px;
            text-align:center;
            border: 1px solid #000;
            transition: all 0.3s linear;
        }

        .contenedor-btn div{
            width:100%;
            text-align:center;
            border-bottom: 1px solid #d3d3d3;
            transition: all 0.3s linear;
            padding: 10px 0;
        }

        .contenedor-btn div:hover{
            cursor: pointer;
            background-color:  rgba(147, 81, 22,0.2);
            transition: all 0.3s linear;
        }
    </style>
</head>
<body id="body">
    <header> 
        <?php echo $encab; ?> 
    </header>

    <main>
        <?php 
            echo "<div style='display:flex; justify-content:start;'>
                    <div class='contenedor-botones'>
                        $cont_usuarios
                    </div>
                        $infoPersonal
                 </div>";
        ?>
    </main>

    <?php
        echo $pie;
    ?>
</body>
</html>