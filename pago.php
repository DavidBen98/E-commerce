<!DOCTYPE html>
<?php
    require 'config.php';
    include("pie.php"); 
    require 'inc/conn.php';
    require 'vendor/autoload.php';

    $ruta = "<ol class='ruta'>
                <li><a href='index.php'>Inicio</a></li>
                <li><a href='carritoCompras.php'>Carrito de compras</a></li>
                <li style='border:none;text-decoration: none;'>Pago</li>
            </ol>
    ";

    MercadoPago\SDK::setAccessToken('TEST-5976931908635341-011902-66f238a2e8fba7fb50819cd40a6ecef9-172145106');
    
    $preference = new MercadoPago\Preference();

    global $db; 
    $productos_mp = isset ($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
    $lista_carrito = array();
    $productos_agregados = 0;

    if ($productos_mp != null){
        foreach ($productos_mp as $key => $cantidad){
            $sql = $db->prepare("SELECT id, precio, codigo, descripcion, material, color, marca, stock, descuento, $cantidad AS cantidad
                                 FROM producto
                                 WHERE id=?");
            $sql -> execute ([$key]);
            $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
        }
    }
    else{
        header('location: carritoCompras.php');
        exit;
    }

    $carrito = "<div class='carrito'>";
        
    if ($lista_carrito != null){
        $carrito .= "<div class='checkout-btn cont-btn'>";
    }
    else{
        $carrito .= "<div class='checkout-btn cont-btn' id='ocultar'>";
    }

    $carrito .= "<div>
                    <p style='margin:0; height:30px;'>
                        <b style='font-family: museosans500,arial,sans-serif;'>FINALIZAR COMPRA</b><br>
                    </p>
                    <p style='font-size: 0.9rem; font-weight:700; color: #858585; font-family: museosans500,arial,sans-serif; margin:0;'>  
                        RESUMEN";

    $carrito .= "   </p>
            </div>
        </div>
    ";


        $selectNumero = 1; 
        $total = 0;
        $i = 1;

        foreach($lista_carrito as $producto){
            $subtotal = 0;
            $id = $producto['id'];
            $codigo = $producto['codigo'];
            $descripcion = ucfirst($producto['descripcion']);
            $marca = ucfirst($producto['marca']);
            $color = ucfirst($producto['color']);
            $material = ucfirst($producto['material']);
            $stock = intval($producto['stock']);
            $cantidad = intval($producto['cantidad']);
            
            if ($stock < $cantidad){
                $cantidad = $stock;
            }

            $precio = intval($producto['precio']);
            $descuento = intval($producto['descuento']);
            $precio_desc = $precio - (($precio * $descuento) /100);
            $subtotal += $cantidad * $precio_desc; 
            $total += $subtotal; 
 
            $item = new MercadoPago\Item();
            $item->id = $i;
            $item->title = $descripcion;
            $item->quantity = $cantidad;
            $item->unit_price = $precio_desc;
            $item->currency_id = "ARS";

            array_push($productos_mp, $item);
            unset ($item);

            $i++;

            $carrito .= "<div class='contenedor'>
                                <div class='principal'>                                                                                          
                                    <img src='images/$codigo.png' class='productos img-cat' alt='$codigo' style='border:none;'>
                                        <div class='titulo'>
                                            <div class='cont-enlaces' style='display:flex; flex-wrap:wrap;'>
                                                <p class='enlace' style='color:#000; margin-top:10px; width:100%;'> $descripcion</p>
                                                <p class='enlace'>Cantidad: $cantidad</p> 
                                            </div>
                                            <div class='enlace' style='width:40%;'>
                                                <p id='precioS-$selectNumero' style='width:100%; text-align:center;font-family: Arial,Helvetica,sans-serif;'><b>$".$subtotal."</b></p>
                                            </div>
                                        </div>
                                </div>                                          
                </div>
            ";

            $selectNumero++;
        }

        $carrito .= "<div class='contenedor-botones'>
                        <div class= 'botones'>
                            <div class='totales' style='height:50px;'>
                                <p class='txt-totales total' style='border-bottom-left-radius: 5px;'><b style='font-size: 1.1rem;'>Precio final:</b> </p> 
                                <p class='total txt-totales' id='total' style='border-bottom-right-radius: 5px;padding-right:10px; justify-content:center;'><b>$$total</b></p>
                            </div>
                            <div class='checkout btn-final'></div>
                        </div>
        ";

        if (isset($_GET['error_pago'])){
            $carrito .= "<div class='mensaje' style='background:#E53935;'>¡El pago no se ha procesado correctamente, reintente por favor!</div>";
        }

        $carrito .= "</div>";
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css"  href="assets/css/estilos.css" rel="stylesheet"/>
    <title>Muebles Giannis</title>
    <link rel="icon" type="image/png" href="images/logo_sitio.png">
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <style>
        main{
            display:flex;
            justify-content:center;
            padding-bottom: 30px;
            flex-wrap: wrap;
        }

        .carrito{
            width:40%;
            background-color: white;
            padding:10px;
            font-size: 1rem;
            border-radius:5px;
        }

        .contenedor{
            display: flex;
            justify-content:space-between;
            flex-wrap:wrap;
            align-items:center;
            border-bottom: 1px solid #D3D3D3;
            padding:10px 0;
            margin: 0 10px;
        }

        .productos{
            width: 20%;
            height: 130px;
            padding-right: 2%;
            object-fit: contain;
        }

        .descrip{
            width:70%;
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
            width:100%;
            display:flex;
            justify-content:center;
            flex-wrap:wrap;
        }

        .principal p{
            width:200px;
            margin: 0;
            text-align:start;
            height: auto;
        }

        .secundario{
            width:35%;
            display:flex;
            justify-content: end;
            flex-wrap:wrap;
            align-content:start;
        }

        .secundario p{
            margin: 10px 0;
            color: #000;
            font-size: 14px;
            text-align:start;
        }

        .definir{
            width:30%;
        }

        .caract{
            width:50%;
            padding-left:10px;
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
            display:flex;
            justify-content:space-around;
            align-items:center;
            width: 68%;
        }

        .contenedor-botones{
            display:flex;
            justify-content: end;
            flex-wrap: wrap;
            padding-bottom: 10px;
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
            font-size: 0.7rem;
        }

        .total{
            background-color: #E9E9E9;
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
            border-color: #D3D3D3;
            border-radius: 2px;
            color: #4a4a4a;
        }

        .contenedor-eventos{
            display:flex;
            justify-content:space-between;
            width: 90%;
            text-align:start;
            margin-top:20px;
            font-size: 0.75rem;
            align-items:center;
        }

        .evento-producto{
            color: #858585;
            display: flex;
            align-items: center;
        } 
        
        .fav-prod{
            padding-left: 2px;
            transition: all 0.5s linear;
            color: #858585;
            font-family: "Salesforce Sans", serif;  
            line-height: 1.5rem;
            background-color: white;
            border:none;
            font-size: 0.75rem;
            padding-right:0;
            padding-left:4px;
        }

        .elim-prod{
            transition: all 0.5s linear;
            color: #858585;
            font-family: "Salesforce Sans", serif;  
            line-height: 1.5rem;
            background-color: white;
            border:none;
            font-size: 0.75rem;
            padding-left: 4px;
            padding-right: 0;
        }

        .fav-prod:hover, .elim-prod:hover{
            color: #000;
            transition: all 0.5s linear;
            font-size: 0.8rem;
            cursor: pointer;
        }

        .ruta{
            margin:0;
        }

        header{
            background-color: rgba(147, 81, 22,0.5);
            padding-top:20px;
        }
    </style>
</head>
<body id="body">

    <header>
        <?= $ruta; ?>
    </header>
    
    <main>      
        <?= $carrito; ?>
    </main> 
    
    <footer id='pie'>
        <?= $pie; ?> 
    </footer>
    
    <!--MERCADO PAGO-->
    <?php
        $preference->items = $productos_mp;

        $preference->back_urls = array (
            "success" => "localhost/E-commerceMuebleria/callback.php",
            "failure" => "localhost/E-commerceMuebleria/callback.php?failure=true"
        );
    
        $preference->auto_return = "approved";
        $preference->binary_mode = true;
    
        $preference->save();
    ?>

    <script>
        const mp = new MercadoPago('TEST-b052d91d-3a4e-4b65-9804-7c2b716a0608', {
            locale: "es-AR",
        });

        // Inicializa el checkout
        mp.checkout({
            preference: {
                id: '<?php echo $preference->id; ?>'
            },
            render: {
                container: ".checkout-btn", // Indica el nombre de la clase donde se mostrará el botón de pago
                label: "Finalizar compra" 
            }
        });

        const mercadoPago = new MercadoPago('TEST-b052d91d-3a4e-4b65-9804-7c2b716a0608', {
            locale: "es-AR",
        });

        let btnMP = document.getElementsByClassName('checkout');

        if (btnMP[0] != null){
            mercadoPago.checkout({
                preference: {
                    id: '<?php echo $preference->id; ?>'
                },
                render: {
                    container: ".checkout",
                    label: "Finalizar compra"
                }
            });
        }      
    </script>  
    <!-- -->

</body>
</html>