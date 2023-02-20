<?php 
    require_once "../controlador/config.php";
    include  "../inc/conn.php";
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

    $contenedor_compras = "
        <div class='consulta'>
            <div class='renglon'>      
                <h1>
                    Compras realizadas
                </h1>
            </div>            
    ";

    $compras = obtener_compras($id_usuario);

    if (count($compras) == 0){
        $contenedor_compras .= "
                <div id='vacio'> Aún no hay compras realizadas</div>
                <div class='continuar'>
                    <button type='button' class='btn-final' id='continuar'>
                        Continúa navegando
                    </button>
                </div>
            </div>
        ";
    }
    else{
        $nro_compra = count($compras);

        foreach ($compras as $compra) { 
            $id_compra = $compra['id_compra'];
            $fecha = $compra['fecha'];
            $estado = $compra['estado'];
            $num_transaccion = $compra['num_transaccion'];
            $total = $compra['total'];

            $contenedor_compras .= "<div class='cont-compras'>";
            $contenedor_compras .= "
                <div class='cont-compra'>
                    <p class='nro-compra'> Compra nro: $nro_compra </p>
                    <div class='cont-info-compra'>
                        <p class='info-compra'>Información de la compra:</p>
                        <p>Número de transaccion: $num_transaccion</p>
                        <p>Fecha: $fecha</p> 
                        <p>Estado: $estado</p>
                        <p>Total: $total</p>
                        <p id='detalle-compra'>Detalle de la compra:</p>
                    </div>
                </div>
            ";

            foreach ($compra['detalles'] as $detalle) {
                $id_producto = $detalle['id_producto'];
                $codigo = $detalle['codigo'];
                $precio = $detalle['precio'];
                $cantidad = $detalle['cantidad'];
                $descripcion = $detalle["descripcion"];
                $path = obtener_imagen_producto($id_producto);

                $contenedor_compras.= "  
                    <div class='contenedor'>
                        <div class='descrip'> 
                            <div class='imagen-producto'>
                                <img src='../$path' class='productos img-cat' alt='$codigo'>
                            </div>
                            <div class='detalle-producto'>
                                <a href='detalleArticulo.php?art=$codigo' class='enlace'> $descripcion</a>
                                <p>Cantidad: $cantidad</p>
                                <p>Precio: $$precio</p>
                            </div>
                        </div>
                    </div>
                ";
            }

            $contenedor_compras .= "
                </div>
            ";
            $nro_compra--;
        }

        $contenedor_compras .= "</div>";
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
	<script>
        document.addEventListener ("DOMContentLoaded", () => {
            let continuar = document.getElementById("continuar");

            if (continuar != null){
                continuar.addEventListener("click", () => {
                    window.location = "productos.php?productos=todos";
                });  
            }

            let imagenes = document.getElementsByClassName("img-cat"); //Imagenes de los productos

            for (j=0;j<imagenes.length;j++){
                let articulo = imagenes[j].getAttribute("alt");
                imagenes[j].addEventListener("click", () => {
                    window.location = "detalleArticulo.php?art="+articulo;
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

        .cont-compras{
            display:flex;
            width:96%;
            flex-wrap: wrap;
            border: 2px solid #000;
            margin: 2%;
        }

        .cont-compra{
            width: 100%;
            display: flex;
            flex-wrap: wrap;
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

        .titulo div:first-child{
            display:flex; 
            flex-wrap:wrap;
        }

        .cont-info-compra {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
            padding: 2%;
            justify-content: center;
        }

        .cont-info-compra p{
            width: 100%;
            margin: 0;
            padding: 2px;
            text-align: center;
        }

        .info-compra{
            color: grey;
            padding: 1%;
            width: 100%;
            margin: 0;
        }

        #detalle-compra{
            width: 50%;
            background: #000;
            color: #ffffff;
            margin: 2%;
        }
        
        .enlace:first-child{
            color:#000; 
            margin-top:10px; 
            width:100%;
        }

        .enlace:last-child{
            font-size:16px; 
            color: #858585;
        }

        .detalle-producto{
            width: 65%;
        }

        .nro-compra{
            width: 100%;
            background: #000;
            color: #ffffff;
            text-align: center;
            font-size: 1.3rem;
            margin-top: 0;
            padding: 2%;
        }

        .imagen-producto{
            width: 30%;
        }

        .renglon{
            width:100%;
            display:flex;
            justify-content:center;
            margin:0;
            border-bottom:1px solid #858585; 
            height:50px;
        }

        .renglon h1{
            margin: 0; 
            display: flex; 
            align-items: center; 
            font-family: museosans500,arial,sans-serif; 
            font-size:1.6rem;
        }

        #vacio{
            margin:10px; 
            width:100%; 
            text-align:center; 
            height:30px;
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
            flex-wrap: wrap;
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

        #continuar{
            margin:auto;
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

        .elim-producto img{
            width:20px; 
            height:20px; 
            margin-right:1px;
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

        .elim-producto:first-child{
            width:45%; 
            padding-right: 8px; 
            border-right: 1px solid #D3D3D3;
        }

        .elim-producto:last-child{
            text-align:end;
        }

        .fav-prod:hover, .elim-prod:hover{
            color: #000;
            transition: all 0.5s linear;
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

        .img-cat{
            border:none;
        }

        .enlace{
            transition: all 0.5s linear;
        }

        .enlace:hover{
            color: #000;
            transition: all 0.5s linear;
        }

        .ruta li:first-child{
			margin-left:5px;
		}

        .ruta li:last-child{
			border:none;
			text-decoration: none;
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
        <?= imprimir_encabezado($encabezado, $encabezado_mobile); ?>
    </header>

    <main>
        <ol class="ruta">
            <li><a href="index.php">Inicio</a></li>
            <li>Mis compras</li>
        </ol>
        
        <aside class="contenedor-botones">
            <?= CONT_USUARIOS; ?>
        </aside>

        <?= $contenedor_compras; ?>  
        <?= $modal_novedades; ?> 
        <?= $modal_novedades_error; ?>
    </main>

    <footer id="pie">
		<?= $pie; ?> 
	</footer>
</body>
</html>