<?php 
    require_once 'server/config.php';
    include("encabezado.php"); 
    include("pie.php");
    include("modalNovedades.php");
    include ("inc/conn.php");

    if (perfil_valido(3)) {
        header("location:login.php");
    }
    else if (perfil_valido(1)) {
        header("location:veABMProducto.php");
    } 
                 
    global $db;
    
    if (isset($_SESSION['idUsuario'])){ //si se inició sesion desde una cuenta nativa
        $idUsuario = $_SESSION['idUsuario'];
    }
    else if (isset($_SESSION['id'])){ //Si se inicio sesion desde Google
        $idUsuario = $_SESSION['id'];
    }
    else if (isset($_SESSION["user_id"])){ //Si se inicio sesion desde twitter
        $idUsuario = $_SESSION["user_id"];
    }

    if (!isset($_SESSION['idUsuario'])){
        $sql = "SELECT u.id
                FROM usuario as u
                INNER JOIN usuario_rs as rs ON rs.id = u.id
                WHERE rs.id_social = '$idUsuario'
        ";

        $rs = $db->query($sql);

        foreach ($rs as $row){
            $idUsuario = $row['id'];
        }
    }

    $sql= "SELECT `descripcion`, `material`, `color`, `caracteristicas`, `marca` , p.`precio`,`codigo`,p.`id`
            FROM `compra` as c
            INNER JOIN `detalle_compra` as d on d.id_compra = c.id
            INNER JOIN `producto` as p on p.id = d.id_producto 
            INNER JOIN `usuario` as u on u.id = c.id_usuario
            WHERE c.id_usuario = '$idUsuario'
    "; 

    $rs = $db->query($sql);

    $div = "<div class='consulta'>
                <div class='renglon' style='border-bottom:1px solid #858585; height:50px;'>      
                <h1 style='margin: 0; display: flex; align-items: center; font-family: museosans500,arial,sans-serif; font-size:1.6rem;'>
                    Compras realizadas
                </h1>
                </div>            
    ";
    $i = 0;

    foreach ($rs as $row){
        $i++;
    }

    $rs = $db->query($sql);

    $selectNumero = 1; 
    if ($i == 0){
        $div .= "<div style='margin:10px; width:100%; text-align:center; height:30px;'> Aún no hay compras realizadas</div>";

        $div .= "<div class='continuar' style='width: 100%; display: flex;'>
                        <button type='button' class='btn-final' id='continuar' style='margin:auto;'>
                            Continúa navegando
                        </button>
                </div>
        ";

        if (isset($_GET['elim'])){
            $div .= "<div class='mensaje'>¡El producto se ha eliminado correctamente!</div>";
        }
        $div .= "</div>";    
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

            $sql = "SELECT * FROM imagen_productos
                WHERE id_producto = $id AND portada=1
            ";

            $result = $db -> query($sql);
            $path = '';

            foreach ($result as $r){
                $path = $r['destination'];
            }
    
            $div.= "<div class='contenedor'>
                        <div class='descrip'> 
                            <div class='principal'>                                                                                          
                                <img src='$path' class='productos img-cat' alt='$codigo' style='border:none;'>
                                    <div class='titulo' style='text-align:left;'>
                                        <div style='display:flex; flex-wrap:wrap;'>
                                            <a href='detalleArticulo.php?art=$codigo' class='enlace' style='color:#000; margin-top:10px; width:100%;'> $descripcion</a>
                                            <a href='detalleArticulo.php?art=$codigo' class='enlace' style='font-size:16px; color: #858585;'> $marca</a>
                                        </div>
                                        <div class='elim-fav'>
                                            <div class='elim-producto' style='width:45%; padding-right: 8px; border-right: 1px solid #D3D3D3;' >
                                                <img src='images/eliminar.png' style='width:20px; height:20px; margin-right:1px;' alt='Eliminar producto'>
                                                <a id='elim-prod-$selectNumero' class='elim-prod' onclick='eliminarFavorito($id)'> Eliminar producto</a>
                                            </div>
                                            <div class='elim-producto' style='text-align:end;'>
                                                <img src='images/carrito.png' style='width:20px; height:20px; margin-right:1px;' alt='Agregar al carrito'>
                                                <a id='agregar-fav-$selectNumero' class='fav-prod' onclick='agregarProductoCompra($id)'> Agregar al carrito</a>
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
                                    <p>$$precio</p>
                            </div>                                            
                        </div>
                    </div>
            ";
        
            $selectNumero++;
        }
        if (isset($_GET['elim'])){
            $div .= "<div class='mensaje'>¡El producto se ha eliminado correctamente!</div>";
        }
        $div .= "</div>";
    }
?>
<!DOCTYPE html>
<html lang="es">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css"  href="assets/css/estilos.css" rel="stylesheet"/>
    <link rel="icon" type="image/png" href="images/logo_sitio.png">
    <title>Muebles Giannis</title> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="js/funciones.js"></script>
	<script>
        document.addEventListener ('DOMContentLoaded', () => {
            let continuar = document.getElementById('continuar');

            if (continuar != null){
                continuar.addEventListener("click", () => {
                    window.location = "productos.php?productos=todos";
                });  
            }

            let imagenes = document.getElementsByClassName('img-cat'); //Imagenes de los productos

            for (j=0;j<imagenes.length;j++){
                let articulo = imagenes[j].getAttribute('alt');
                imagenes[j].addEventListener("click", () => {
                    window.location = 'detalleArticulo.php?art='+articulo;
                });
            }
        });	
    </script>
    <style>
        main{
            display:flex;
            flex-wrap: wrap;
            justify-content:start;
        }

        .contenedor{
            display: flex;
            justify-content:space-between;
            flex-wrap:wrap;
            align-items:center;
            border-bottom: 1px solid #D3D3D3;
            width:100%;
            height:180px;
            padding:10px 0;
            margin: 0 10px;
        }

        .consulta{
            width:70%;
            background-color:white;
            display:flex;
            flex-wrap:wrap;
            justify-content: center;
            border-radius:5px;
            border: 1px solid black;
            margin: 0 0 4% 2%;
            padding: 0 1%;
        }

        .renglon{
            width:100%;
            display:flex;
            justify-content:center;
            margin:0;
        }

        .productos{
            width: 160px;
            height:160px;
            padding-right: 10px;
            object-fit: contain;
        }

        .descrip{
            width:100%;
            height:90%;
            display:flex;
            justify-content:start;
        }

        .precio{
            width:250px;
            height: 100%;
            display: flex;
            align-content: center;
            flex-wrap:wrap;
            justify-content:space-between;
            border-left: 1px solid #D3D3D3;
        }

        .precio p{
            width:45%;
            font-size: 1rem;
            height: 30px;
            margin: 0;
        }

        .precio div{
            width:45%;
            font-size: 1rem;
            height: 30px;
            margin: 0;
        }

        .cont-btn{
            display:flex;
            justify-content:space-between;
            margin: 0 10px;
            height: 60px;
            border-bottom: 1px solid #D3D3D3;
            padding-top: 10px;
        }

        .checkout{
            width:200px;
        }

        .principal{
            width:70%;
            display:flex;
            justify-content: space-between;
            flex-wrap:wrap;
            height: 160px;
        }

        .principal p{
            width:200px;
            margin: 0;
            text-align:start;
            height: auto;
        }

        .secundario{
            width:45%;
            display:flex;
            flex-wrap:wrap;
            align-content:start;
            padding-left: 100px;
        }

        .secundario p{
            margin: 10px 0;
            color: #000;
            text-align:start;
            font-size: 1rem;
        }

        .definir{
            width:30%;
        }

        .caract{
            width:70%;
        }

        .mercadopago-button{
            height:40px;
            width: 250px;
            font-weight: 700;
        }

        .mercadopago-button:hover{
            background: #099;
            transition: all 0.3s linear;
        }

        .titulo{
            width:300px;
            height: auto;
        }

        .botones{
            height:100%;
            width:250px;
            margin: 0 10px;

        }

        .botones .checkout {
            height: 20%;
        }

        .continuar{
            height: 20%;
        }

        .btn-final{
            margin-top:10px;
        }

        .totales{
            display:flex;
            width:250px;
            margin: 0;
            justify-content:center;
        }

        .subtotal{
            background-color: #E9E9E9;
            font-size: 0.75rem;
        }

        .total{
            background-color: #D3D3D3;
        }

        .txt-totales{
            display:flex;
            align-items:center;
            width: 50%;
            font-family: museosans500,arial,sans-serif;
            padding-left: 10px;
            margin: 0;
            color: #000;
        }

        .continuar button{
            width:250px;
            height: 40px;
            background: rgba(147, 81, 22,0.5);
            border-radius: 5px;
            border: 1px solid #000;
            font-weight: 700;
            cursor: pointer;
        }

        .continuar button:hover{
            background-color: rgba(147, 81, 22,1);
            transition: all 0.3s linear;
            color: white;
            cursor:pointer;
        }

        .cant-compra{
            padding: 5px 10px;
        }

        .elim-fav{
            display:flex;
            justify-content:space-between;
            width:100%;
            text-align:start;
            margin-top:20px;
            font-size: 0.75rem;
            align-items:center;
        }

        .elim-producto{
            color: #858585;
            display: flex;
            align-items: center;
        } 
        
        .fav-prod{
            padding-left: 2px;
            transition: all 0.5s linear;
            color: #858585;
        }

        .elim-prod{
            transition: all 0.5s linear;
            color: #858585;
        }

        .fav-prod:hover, .elim-prod:hover{
            color: #000;
            transition: all 0.5s linear;
            font-size: 0.8rem;
            cursor: pointer;
        }

        .mensaje{
            width:100%;
            margin: 10px;
            text-align: center;
            background-color: #000;
            color: white;
            border-radius:5px;
            padding: 10px 0;
            font-size: 1.1rem;
        }

        .mensaje a{
            text-decoration: underline;
            color: white;
            transition: all 0.5s linear;
        }

        .mensaje a:hover{
            font-size:1.2rem;
            transition: all 0.5s linear;
        }

        .parrafo-exito{
            background-color: #099;
			width:100%;
			padding: 10px 0;
			color: white;
			margin:10px;
			border-radius: 5px;
			text-align:center;
		}

        .carrito-compras{
            text-decoration: underline;
            color: white;
            transition: all 0.5s linear;
        }

        .carrito-compras:hover{
            font-size:1.2rem;
            transition: all 0.5s linear;
        }

        .img-cat:hover{
            cursor: pointer;
        }

        .enlace{
            transition: all 0.5s linear;
        }

        .enlace:hover{
            color: #000;
            font-size:1.15rem;
            transition: all 0.5s linear;
        }
        
        @media screen and (max-width:860px){
            main{
                min-height: 70vh;
                align-items: start;
            }
            
            .ruta{
                height: 40px;
            }
            .consulta{
                width:95%;
                padding: 0;
                margin: 0 auto 4%;
                min-height: 40vh;
            }
            
            .continuar{
                margin: 4%;
            }
            
            .contenedor-botones{
                margin-top: 0;
            }
        }
    </style>
</head>
<body id="body">
    <header>
        <?= $encabezado; ?> 
        <?= $encabezado_mobile; ?>
    </header>

    <main>
        <ol class='ruta'>
            <li style='margin-left:5px;'><a href='index.php'>Inicio</a></li>
            <li style='border:none;text-decoration: none;'>Mis compras</li>
        </ol>
        
        <aside class='contenedor-botones'>
            <?= CONT_USUARIOS; ?>
        </aside>

        <?= $div; ?>  
        <?= $modalNovedades; ?>
    </main>

    <footer id='pie'>
		<?= $pie; ?> 
	</footer>
</body>
</html>