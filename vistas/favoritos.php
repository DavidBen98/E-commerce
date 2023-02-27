<?php 
    //Ignorado: contraste letras grises con fondo blanco
    require_once "../controlador/config.php";
    include "../inc/conn.php";
    include "encabezado.php"; 
    include "modalNovedades.php";
    include "pie.php";

    if (perfil_valido(3)) {
        header("location:login.php");
        exit;
    }
    else if (perfil_valido(1)) {
        header("location:veABMProducto.php");
        exit;
    } 
                 
    if (isset($_SESSION["idUsuario"])){ //si se inició sesion desde una cuenta nativa
        $id_usuario = $_SESSION["idUsuario"];
    }
    else if (isset($_SESSION["id"])){ //Si se inicio sesion desde Google
        $id_usuario = $_SESSION["id"];
    }
      // else if (isset($_SESSION["user_id"])){ //Si se inicio sesion desde twitter
    //     $id_usuario = $_SESSION["user_id"];
    // }

    if (!isset($_SESSION["idUsuario"])){
        $rs = obtener_usuario_con_id_rs($id_usuario);

        foreach ($rs as $row){
            $id_usuario = $row["id"];
        }
    }

    $contenedor_favoritos = "
        <div class='consulta' id='consulta'>
            <div class='renglon'>      
                <h2>
                    Favoritos
                </h2>
            </div>            
    ";

    $i = 0;
    $rs = obtener_favoritos($id_usuario);

    foreach ($rs as $row){
        $i++;
    }

    $rs = obtener_favoritos($id_usuario);

    $select_numero = 1; 

    if ($i == 0){
        $contenedor_favoritos .= "
            <div class='vacio'> 
                Aún no hay productos favoritos
            </div>

            <div class='continuar'>
                    <button type='button' class='btn-final' id='continuar'>
                        Continúa navegando
                    </button>
            </div>
        ";

        if (isset($_GET["elim"])){
            $contenedor_favoritos .= "<div class='mensaje' id='mensaje'>¡El producto se ha eliminado correctamente!</div>";
        }

        $contenedor_favoritos .= "</div>";    
    } else {
        foreach ($rs as $row) { 
            $descripcion = $row["descripcion"];
            $material = $row["material"];
            $color = $row["color"];
            $caracteristicas = $row["caracteristicas"];
            $marca = $row["marca"];
            $precio = $row["precio"];
            $codigo = $row["codigo"];
            $id = $row["id"];

            $path = obtener_imagen_producto($id);
    
            $contenedor_favoritos.= "
                <div class='contenedor'>
                    <div class='descrip'> 
                        <div class='principal'>                                                                                          
                            <img src='../$path' class='productos img-cat' alt='$codigo'>
                                <div class='titulo'>
                                    <div class='cont-enlaces'>
                                        <p class='enlace'> $descripcion</p>
                                        <p class='enlace'> $marca</p>
                                    </div> 
                                    <div class='contenedor-eventos'>
                                        <div class='evento-producto' >
                                            <img src='../images/iconos/eliminar.png' alt='Eliminar producto'>
                                            <button class='elim-fav' value='$id'> Eliminar producto</button>
                                        </div>
                                        <div class='evento-producto'>
                                            <img src='../images/iconos/carrito.png' alt='Agregar al carrito'>
                                            <a id='agregar-fav-$select_numero' class='prod-fav' onclick='agregarProducto($id)'> Agregar al carrito</a>
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
                                    <p> $color </p>
                                    <p> $material </p>
                                    <p> $$precio </p>
                                </div>
                        </div>                                            
                    </div>
                </div>
            ";
        
            $select_numero++;
        }
        if (isset($_GET["elim"])){
            $contenedor_favoritos .= "<div class='mensaje' id='mensaje'>¡El producto se ha eliminado correctamente!</div>";
        }
        $contenedor_favoritos .= "</div>";
    }
?>
<!DOCTYPE html>
<html lang="es">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css"  href="../assets/css/estilos.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="../images/iconos/logo_sitio.png">
    <title>Muebles Giannis</title> 
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="../js/funciones.js"></script>
    <style>
        main{
            display:flex;
            flex-wrap: wrap;
            justify-content:start;
        }

        .contenedor{
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            align-items: center;
            border-bottom: 1px solid #D3D3D3;
            width: 100%;
            min-height: 130px;
            padding: 4% 0;
            margin: 0 4%;
        }

        .contenedor-btn div:hover{
            cursor: pointer;
            background-color: rgba(147, 81, 22,0.2);
        }

        .consulta{
            background-color: white;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            border-radius: 5px;
            border: 1px solid black;
            padding: 0 4%;
            width: 100%;
        }

        .renglon{
            width:100%;
            display:flex;
            justify-content:center;
            margin:0;
            border-bottom:1px solid #858585; 
            height:50px;
        }

        .renglon h2{
            margin: 0; 
            display: flex; 
            align-items: center; 
            font-family: museosans500,arial,sans-serif; 
            font-size:1.6rem;
        }

        .vacio{
            margin:10px; 
            width:100%; 
            text-align:center; 
            height:30px;
        }

        .cont-enlaces{
            display:flex; 
            flex-wrap:wrap;
        }

        .enlace{
            color:#000; 
            margin-top:10px; 
            width:100%;
        }

        .enlace:last-child{
            margin-top: 0;
            width: auto;
            font-size:16px; 
            color: #858585;
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
            padding-top: 2%;
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
            text-align:left;
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
            width: 100%; 
            display: flex;
        }

        #continuar{
            margin:auto;
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
            background-color: rgba(147, 81, 22,0.7);
            transition: all 0.3s linear;
            color: white;
            cursor:pointer;
        }

        .cant-compra{
            padding: 2% 4%;
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
            padding-right: 3%; 
            border-right: 1px solid #D3D3D3; 
            justify-content:end;
        } 

        .evento-producto:last-child{
            text-align:end; 
            justify-content:start; 
            padding-left: 3%;
            padding-right: 0;
            border-right: none;
        }

        .evento-producto img{
            width:20px; 
            height:20px; 
            margin-right:1px;
        }
        
        .prod-fav{
            padding-left: 2px;
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
            cursor: pointer;
        }

        .mensaje{
            width: 100%;
            margin: 1%;
            text-align: center;
            background-color: #000;
            color: white;
            border-radius: 5px;
            padding: 2% 0;
            font-size: 1.1rem;
        }

        .mensaje a{
            text-decoration: underline;
            color: white;
            transition: all 0.5s linear;
        }

        .mensaje a:hover{
            transition: all 0.5s linear;
        }

        .parrafo-exito{
            background-color: #099;
			width: 100%;
			padding: 2% 0;
			color: white;
			margin: 2%;
			border-radius: 5px;
			text-align: center;
		}

        .carrito-compras{
            text-decoration: underline;
            color: white;
            transition: all 0.4s ease-in;
        }

        .carrito-compras:hover{
            transition: all 0.4s ease-in;
        }

        .img-cat{
            border:none;
        }

        .img-cat:hover{
            cursor: pointer;
        }

        .enlace{
            transition: all 0.4s ease-in;
        }

        .enlace:hover{
            color: #000;
            transition: all 0.4s ease-in;;
            cursor: pointer;
        }
        
        main > section{
            display:flex; 
            width:75%; 
            height:auto;
            margin: 0 0 4% 2%;
        }

        .ruta li:first-child{
			margin-left:5px;
		}

        .ruta li:last-child{
			border:none;
			text-decoration: none;
		}
        
        @media screen and (max-width:860px){
            main > section{
                display: flex;
                width: 95%;
                margin: 0 auto 5%;
                height: auto;
            }
            
            #consulta{
                padding: 0 2%;
                margin: auto;
            }
            
            .contenedor {
                width: 100%;
                min-height: 130px;
                padding: 2% 0;
                margin: 0 2%;
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
        <?= imprimir_encabezado($encabezado, $encabezado_mobile); ?>
    </header>

    <main>

        <ol class="ruta">
            <li><a href="index.php">Inicio</a></li>
            <li>Favoritos</li>
        </ol>

        <aside class="contenedor-botones">
            <?= CONT_USUARIOS; ?>
        </aside>

        <section>
            <?= $contenedor_favoritos; ?>
        </section>
        
        <?= $modal_novedades; ?> 
        <?= $modal_novedades_error; ?>

    </main>

    <footer id="pie">
		<?= $pie; ?> 
	</footer>
</body>
</html>