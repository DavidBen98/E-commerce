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
                    <p class='nro-compra'> Compra Nº $nro_compra </p>
                    <div class='cont-info-compra'>
                        <p class='info-compra'>Información de la compra:</p>
                        <p>Número de transaccion: $num_transaccion</p>
                        <p>Fecha: $fecha</p> 
                        <p>Estado: $estado</p>
                        <p>Total: $$total</p>
                        <div class='detalle-compra'>Detalle de la compra</div>
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

        .cont-info-compra {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
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

        .detalle-compra{
            width: 80%;
            background: #000;
            color: #ffffff;
            margin: 2%;
            border-radius: 5px;
            text-align:center;
            padding: 1%;
        }
        
        .enlace{
            color:#000; 
            margin-top:10px; 
            width:100%;
            transition: all 0.5s linear;
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

        .continuar{
            height: 20%;
            width: 100%; 
            display: flex;
        }

        .btn-final{
            margin-top:10px;
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

        #continuar{
            margin:auto;
        }

        .img-cat:hover{
            cursor: pointer;
        }

        .img-cat{
            border:none;
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