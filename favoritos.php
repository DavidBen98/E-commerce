<?php 
    include ('config.php');
    include("encabezado.php"); 
    include("pie.php");
    include ("inc/conn.php");

    if (perfil_valido(3)) {
        header("location:index.php");
    }
    else if (perfil_valido(1)) {
        header("location:ve.php");
    } 
                 
    global $db;
    
    if (isset($_SESSION['idUsuario'])){ //si se inició sesion desde una cuenta nativa
        $id_usuario = $_SESSION['idUsuario'];
    }
    else if (isset($_SESSION['id'])){ //Si se inicio sesion desde Google
        $id_usuario = $_SESSION['id'];
    }
    else if (isset($_SESSION["user_id"])){ //Si se inicio sesion desde twitter
        $id_usuario = $_SESSION["user_id"];
    }

    if (!isset($_SESSION['idUsuario'])){
        $sql = "SELECT u.id
                FROM usuarios as u
                INNER JOIN usuarios_rs as rs ON rs.id = u.id
                WHERE rs.id_social = $id_usuario
        ";

        $rs = $db->execute($sql);

        foreach ($rs as $row){
            $id_usuario = $row['id'];
        }
    }

    $sql= "SELECT `descripcion`, `material`, `color`, `caracteristicas`, `marca` , `precio`,`codigo`,`id`
            FROM `producto` as p 
            INNER JOIN `favorito` as f on p.id = favorito.id_producto 
            WHERE favorito.id = '$id_usuario'
    "; 

    $rs = $db->query($sql);

    $div = "<div class='consulta'>
                <div class='renglon' style='border-bottom:1px solid #858585; height:40px;'>      
                    <p style='height:40px; width:100%;'><b>Productos</b></p>
                </div>            
    ";
    $i = 0;

    foreach ($rs as $row){
        $i++;
    }

    $rs = $db->query($sql);

    $div = "<div>";
    $selectNumero = 1; 
    if ($i == 0){
        echo "<div style='margin:10px;'> Aún no hay productos favoritos</div>";

        echo "<div class='contenedor-botones'>
                <div class= 'botones'>
                    <div class='continuar'>
                        <button type='button' class='btn-final' id='continuar'>Continúa comprando</button>
                    </div>
                </div>
            </div>";

        if (isset($_GET['elim'])){
            echo "<div class='mensaje'>¡El producto se ha eliminado correctamente!</div>";
        }
        echo "</div>";    
    }
    else{
        foreach ($rs as $row) { 
            $descripcion = $row['descripcion'];
            $material = $row['material'];
            $color = $row['color'];
            $caracteristicas = $row['caracteristicas'];
            $marca = $row['marca'];
            $precio = $row['precio'];
            $codigo = $row['codigo'];
            $id = $row['id'];
    
            $div.= "<div class='contenedor'>
                        <div class='descripcion'> 
                            <div class='principal'>                                                                                          
                                <img src='images/$codigo.png' class='productos' alt='Codigo del producto:$codigo'>
                                    <div class='titulo'>
                                        <p style='color:#000; margin-top:10px;'>$descripcion</p> 
                                        <p style='font-size:16px;'>$marca</p> 
                                        <div class='elim-fav'>
                                            <div class='elim-producto' style='width:45%; padding-right: 8px; border-right: 1px solid #D3D3D3;' >
                                                <img src='images/eliminar.png' style='width:20px; height:20px; margin-right:1px;' alt='Eliminar producto'>
                                                <a id='elim-prod-$selectNumero' class='elim-prod' onclick='eliminarProducto($id,$selectNumero)'> Eliminar producto</a>
                                            </div>
                                            <div class='elim-producto' style='text-align:end;'>
                                                <img src='images/carrito.png' style='width:20px; height:20px; margin-right:1px;' alt='Agregar al carrito'>
                                                <a id='agregar-fav-$selectNumero' class='fav-prod'> Agregar al carrito</a>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class='secundario'>
                                    <p class='definir'> 
                                        <b>Color:</b>
                                    </p> 
                                    <p class='caract'> $color </p>
                                    <p class='definir'> 
                                        <b>Material:</b>
                                    </p> 
                                    <p class='caract'>$material</p>
                                    <p class='definir'> 
                                        <b>Precio:</b>
                                    </p> 
                                    <p style='text-decoration:line-through; font-size:0.85rem;'>$$precio</p>
                            </div>                                            
                        </div>
                    </div>
            ";
        
            $selectNumero++;
        }
        $div .= "</div>";
    }
?>
<!DOCTYPE html>
<html lang="es">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css"  href="css/estilos.css" rel="stylesheet"/>
    <link rel="icon" type="image/png" href="images/logo_sitio.png">
    <title>Muebles Giannis</title>   
    <style>
        main{
            display:flex;
            flex-wrap: wrap;
            justify-content:start;
        }
        
        .contenedor-botones{
            width:20%;
            display:block;
            margin: 0 80px 30px 20px;
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
            background-color: #B2BABB;
            color: white;
            transition: all 0.3s linear;
        }

        .consulta{
            width:60%;
            background-color:white;
            display:flex;
            flex-wrap:wrap;
            justify-content: center;
            border-radius:5px;
            border: 1px solid black;
            margin-bottom: 30px;
            padding: 0 10px;
        }

        .consulta p{
            width:45%;
            text-align:center;
            margin: 5px;
            padding: 5px;
        }

        .renglon{
            width:100%;
            display:flex;
            justify-content:center;
            margin:0;
        }
    </style>
</head>
<body id="body">
    <header>
        <?php echo $encab; ?> 
    </header>

    <main>
        <?php 
            echo "<div class='contenedor-botones'>
                    $cont_usuarios
                  </div>";

            echo $div;
        ?>  
    </main>

    <?php
        echo $pie;
    ?>
</body>
</html>