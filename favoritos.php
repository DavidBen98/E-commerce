<?php 
    require_once 'config.php';
    include("encabezado.php"); 
    include("pie.php");
    include ("inc/conn.php");

    if (perfil_valido(3)) {
        header("location:login.php");
    }
    else if (perfil_valido(1)) {
        header("location:veABMProducto.php");
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
                FROM usuario as u
                INNER JOIN usuario_rs as rs ON rs.id = u.id
                WHERE rs.id_social = '$id_usuario'
        ";

        $rs = $db->query($sql);

        foreach ($rs as $row){
            $id_usuario = $row['id'];
        }
    }

    $sql= "SELECT `descripcion`, `material`, `color`, `caracteristicas`, `marca` , `precio`,`codigo`,p.`id`
            FROM `producto` as p 
            INNER JOIN `favorito` as f on p.id = f.id_producto 
            WHERE f.id_usuario = '$id_usuario'
    "; 

    $rs = $db->query($sql);

    $div = "<div class='consulta' id='consulta'>
                <div class='renglon' style='border-bottom:1px solid #858585; height:50px;'>      
                    <h1 style='margin: 0; display: flex; align-items: center; font-family: museosans500,arial,sans-serif; font-size:1.6rem;'>
                        Favoritos
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
                $div .= "<div style='margin:10px; width:100%; text-align:center; height:30px;'> Aún no hay productos favoritos</div>";

        $div .= "<div class='continuar' style='width: 100%; display: flex;'>
                        <button type='button' class='btn-final' id='continuar' style='margin:auto;'>
                            Continúa navegando
                        </button>
                </div>";

        if (isset($_GET['elim'])){
            $div .= "<div class='mensaje' id='mensaje'>¡El producto se ha eliminado correctamente!</div>";
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
    
            $div.= "<div class='contenedor'>
                        <div class='descrip'> 
                            <div class='principal'>                                                                                          
                                <img src='images/$id/$codigo.png' class='productos img-cat' alt='$codigo' style='border:none;'>
                                    <div class='titulo' style='text-align:left;'>
                                        <div class='cont-enlaces' style='display:flex; flex-wrap:wrap;'>
                                            <p class='enlace' style='color:#000; margin-top:10px; width:100%;'> $descripcion</p>
                                            <p class='enlace' style='font-size:16px; color: #858585;'> $marca</p>
                                        </div> 
                                        <div class='contenedor-eventos'>
                                            <div class='evento-producto' style='padding-right: 3%; border-right: 1px solid #D3D3D3; justify-content:end' >
                                                <img src='images/eliminar.png' style='width:20px; height:20px; margin-right:1px;' alt='Eliminar producto'>
                                                <button class='elim-fav' value='$id'> Eliminar producto</button>
                                            </div>
                                            <div class='evento-producto' style='text-align:end; justify-content:start; padding-left: 3%'>
                                                <img src='images/carrito.png' style='width:20px; height:20px; margin-right:1px;' alt='Agregar al carrito'>
                                                <a id='agregar-fav-$selectNumero' class='prod-fav' onclick='agregarProducto($id)'> Agregar al carrito</a>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class='secundario'>
                                    <div class='definir'> 
                                        <b>Color:</b>
                                        <b>Material:</b>
                                        <b>Precio:</b>
                                    </div> 
                                    <div class='caract'> 
                                        <p>$color </p>
                                        <p>$material</p>
                                        <p>$$precio</p>
                                    </div>
                            </div>                                            
                        </div>
                    </div>
            ";
        
            $selectNumero++;
        }
        if (isset($_GET['elim'])){
            $div .= "<div class='mensaje' id='mensaje'>¡El producto se ha eliminado correctamente!</div>";
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
            min-height:130px;
            padding:10px 0;
            margin: 0 10px;
        }

        .contenedor-btn div:hover{
            cursor: pointer;
            background-color: rgba(147, 81, 22,0.2);
            transition: all 0.3s linear;
        }

        .consulta{
            background-color:white;
            display:flex;
            flex-wrap:wrap;
            justify-content: center;
            border-radius:5px;
            border: 1px solid black;
            padding: 0 10px;
            width: 100%;
        }

        .renglon{
            width:100%;
            display:flex;
            justify-content:center;
            margin:0;
        }

        .productos{
            width: 30%;
            height:80%;
            padding-right: 10px;
            object-fit: contain;
        }

        .descrip{
            width:100%;
            height:100%;
            display:flex;
            justify-content: space-between;
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
            width:50%;
            display:flex;
            justify-content: space-between;
            flex-wrap:wrap;
            height: 100%;
        }

        .principal p{
            width:200px;
            margin: 0;
            text-align:start;
            height: auto;
        }

        .secundario{
            width: 50%;
            display: flex;
            flex-wrap: wrap;
            align-content: start;
            justify-content: end;
        }

        .definir, .caract{
            width:65%;
            height:100%;
            display:flex;
            flex-wrap:wrap;
            align-items:center;
        }

        .definir{
            width:30%;
        }

        .definir b{
            width:100%;
        }

        .caract p{
            margin:0;
            width:100%;
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
            width: 65%;
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

        .contenedor-eventos{
            display:flex;
            justify-content:space-between;
            width:100%;
            text-align:start;
            margin-top:4%;
            font-size: 0.8rem;
            align-items:center;
        }

        .evento-producto{
            width:45%; 
            color: #858585;
            display: flex;
            align-items: center;
        } 
        
        .prod-fav{
            padding-left: 2px;
            transition: all 0.5s linear;
            color: #858585;
        }

        .elim-fav {
            transition: all 0.5s linear;
            color: #858585;
            font-family: "Salesforce Sans", serif;
            line-height: 1.5rem;
            background-color: white;
            border: none;
            font-size: 0.8rem;
            padding-left: 4px;
            padding-right: 0;
        }

        .prod-fav:hover, .elim-fav:hover{
            color: #000;
            transition: all 0.5s linear;
            font-size: 0.9rem;
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
            transition: all 0.4s ease-in;
        }

        .carrito-compras:hover{
            font-size:1.3rem;
            transition: all 0.4s ease-in;
        }

        .img-cat:hover{
            cursor: pointer;
        }

        .enlace{
            transition: all 0.4s ease-in;
        }

        .enlace:hover{
            color: #000;
            font-size:1.2rem;
            transition: all 0.4s ease-in;;
            cursor: pointer;
        }
        
        main > section{
            display:flex; 
            width:75%; 
            height:auto;
            margin: 0 0 4% 2%;
        }
        
        @media screen and (max-width:860px){
            main > section{
                display: flex;
                width: 95%;
                margin: 0 auto 5%;
                height: auto;
            }
            
            #consulta{
                padding: 0 1%;
                margin: auto;
            }
            
            .contenedor {
                width: 100%;
                min-height: 130px;
                padding: 1% 0;
                margin: 0 1%;
            }
            
            .descrip {
                width: 100%;
                height: 100%;
                display: flex;
                justify-content: space-between;
            }
            
            .principal {
                width: 100%;
                display: flex;
                justify-content: space-between;
                flex-wrap: wrap;
                height: 100%;
            }
            
            .titulo{
                width: 65%;
                height: auto;
            }
            
            .principal p {
                margin-top: 1%;
                width: auto;
                margin: 0;
                text-align: start;
                height: auto;
                font-size: 1rem;
            }
            
            .contenedor-eventos {
                display: flex;
                justify-content: center;
                width: 100%;
                text-align: start;
                margin-top: 5%;
                font-size: 0.8rem;
                align-items: center;
            }
            
            .secundario{
                display:none;
            }
        }
    </style>
</head>
<body id="body">
    <header>
        <?= $encabezado; ?> 
    </header>

    <main>

        <ol class='ruta'>
            <li style='margin-left:5px;'><a href='index.php'>Inicio</a></li>
            <li style='border:none;text-decoration: none;'>Favoritos</li>
        </ol>

        <aside class='contenedor-botones'>
            <?= CONT_USUARIOS; ?>
        </aside>

        <section>
            <?= $div; ?>
        </section>
        

    </main>

    <footer id='pie'>
		<?= $pie; ?> 
	</footer>
</body>
</html>