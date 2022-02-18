<!DOCTYPE html>
<?php 
    include ("pie.php"); 
    include ("inc/conn.php");
    include ('config.php');
    require_once 'vendor/autoload.php';
    include("encabezado.php"); 
    define ('TOKENMERCADOPAGO','TEST-5976931908635341-011902-66f238a2e8fba7fb50819cd40a6ecef9-172145106');
    define ('CREDENCIALPRUEBAMP', 'TEST-b052d91d-3a4e-4b65-9804-7c2b716a0608');
  
    if (perfil_valido(3) && (!isset($_GET['code']) || !isset($_SESSION['user_first_name'])) && (!isset($_SESSION['nombre_tw']))) {
        header("location:login.php"); 
        //TODO: cambiarlo por abrir una ventana emergente que pregunte si se quiere registrar o iniciar sesion
    }
    else if (perfil_valido(1)) {
        header("location:ve.php");
    }

    MercadoPago\SDK::setAccessToken(TOKENMERCADOPAGO);

    $preference = new MercadoPago\Preference();

    $productos_mp = array();

    $ruta = "<ol class='ruta'>
                <li style='margin-left:5px;'><a href='index.php'>Inicio</a></li>
                <li style='border:none;text-decoration: none;'>Carrito de compras</li>
            </ol>
    ";

    global $db; 

    $productos = isset ($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
    $lista_carrito = array();
    $productos_agregados = 0;

    if ($productos != null){
        foreach ($productos as $key => $cantidad){
            $sql = $db->prepare("SELECT id, precio, codigo, descripcion, material, color, marca, stock, descuento, $cantidad AS cantidad
                                 FROM producto
                                 WHERE id=?");
            $sql -> execute ([$key]);
            $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
        }
        $productos_agregados = count($lista_carrito);
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
                        <b style='font-family: museosans500,arial,sans-serif;'>CARRITO DE COMPRAS - PRODUCTOS AÑADIDOS</b><br>
                    </p>
                    <p style='font-size: 0.9rem; font-weight:700; color: #858585; font-family: museosans500,arial,sans-serif; margin:0;'>  
                        $productos_agregados PRODUCTO
    ";
                    
    if ($productos_agregados != 1){
        $carrito .= "S"; //PRODUCTOS
    }

    $carrito .= "   </p>
            </div>
        </div>
    ";

    if ($lista_carrito == null){
        $carrito .= "<div style='margin:10px;'> Aún no hay productos agregados</div>";

        $carrito .= "<div class='contenedor-botones'>
                        <div class= 'botones'>
                            <div class='continuar'>
                                <button type='button' class='btn-final' id='continuar'>Continúa comprando</button>
                            </div>
                        </div>
                    </div>
        ";

        if (isset($_GET['elim'])){
            $carrito .= "<div class='mensaje' id='msj'>¡El producto se ha eliminado correctamente!</div>";
        }

        $carrito .= "</div>";    

    }
    else{
        $selectNumero = 1; 
        $total = 0;
        $i = 1;

        foreach($lista_carrito as $producto){
            $subtotal = 0;
            $id = $producto['id'];
            $onclick = "window.location.href='agregarFavorito.php?id=$id'";
            $codigo = $producto['codigo'];
            $descripcion = ucfirst($producto['descripcion']);
            $marca = ucfirst($producto['marca']);
            $color = ucfirst($producto['color']);
            $material = ucfirst($producto['material']);
            $stock = intval($producto['stock']);
            $cantidad = intval($producto['cantidad']);
            $precio = intval($producto['precio']);
            $descuento = intval($producto['descuento']);
            $precio_desc = $precio - (($precio * $descuento) /100);
            $subtotal += $cantidad * $precio_desc; 
            $total += $subtotal; 

            if ($stock < $cantidad){
                $cantidad = $stock;
            }
            
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
                            <div class='descrip'> 
                                <div class='principal'>                                                                                          
                                    <img src='images/$codigo.png' class='productos img-cat' alt='$codigo' style='border:none;'>
                                        <div class='titulo'>
                                            <div style='display:flex; flex-wrap:wrap;'>
                                                <a href='detalleArticulo.php?art=$codigo' class='enlace' style='color:#000; margin-top:10px; width:100%;'> $descripcion</a>
                                                <a href='detalleArticulo.php?art=$codigo' class='enlace' style='font-size:16px; color: #858585;'> $marca</a>
                                            </div> 
                                            <div class='elim-fav'>
                                                <div class='elim-producto' style='width:45%; padding-right: 8px; border-right: 1px solid #D3D3D3;' >
                                                    <img src='images/eliminar.png' style='width:20px; height:20px; margin-right:1px;' alt='Eliminar producto'>
                                                    <a id='elim-prod-$selectNumero' class='elim-prod' onclick='eliminarProducto($id)'> Eliminar producto</a>
                                                </div>
                                                <div class='elim-producto' style='text-align:end;'>
                                                    <img src='images/fav-carr.png' style='width:20px; height:20px; margin-right:1px;' alt='Agregar a favoritos'>
                                                    <a id='agregar-fav-$selectNumero' class='fav-prod' onclick='agregarFav($id)'> Agregar a favoritos</a>
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
                                            <b>Cantidad:</b>
                                        </p> 
                                        <p class='caract'>
                                            <select class='cant-compra' name='cant-$selectNumero' title='Cantidad' onchange='modificarProducto($id, $selectNumero)'>";
                                                for ($j=1; $j<=$stock; $j++){
                                                    if ($j == $cantidad){
                                                        $carrito .= "<option value='$j' selected>$j</option>";
                                                    }
                                                    else{
                                                        $carrito .= "<option value='$j'>$j</option>";
                                                    }
                                                }
                $carrito .="               </select>
                                </p>
                        </div>                                            
                    </div>

                    <div class='precio'>
                        <p style='border-bottom: 0.5px solid #D3D3D3; padding:0 0 5px 5px; margin-left:15px;'>Precio unitario </p> 
                        <div id='precioU-$selectNumero' style='display:flex; border-bottom: 0.5px solid #D3D3D3; padding:0 0 5px 5px; font-family: Arial,Helvetica,sans-serif;'>";
                            if($precio != $precio_desc){
                        $carrito .= "<p style='text-decoration:line-through; font-size:0.85rem;'>$$precio</p>";
                            }
                        $carrito .=    "<p style=''>$$precio_desc</p>
                        </div>
                        <p style='padding: 5px 0 0 5px; margin-left:15px'>Precio </p> 
                        <p id='precioS-$selectNumero' style='padding: 5px 0 0 5px; font-family: Arial,Helvetica,sans-serif;'><b>$".$subtotal."</b></p>
                    </div>
                </div>
            ";

            $selectNumero++;
        }

        $carrito .= "<div class='contenedor-botones'>
                        <div class= 'botones'>
                            <div class='totales' style='height:40px;'>
                                <p class='subtotal txt-totales'>Subtotal:</p> 
                                <p class='subtotal txt-totales' id='subtotal' style='padding-right:10px; justify-content:end;'> $$total </p>
                            </div>
                            <div class='totales' style='height:50px;'>
                                <p class='txt-totales total' style='border-bottom-left-radius: 5px;'><b>Total</b> </p> 
                                <p class='total txt-totales' id='total' style='border-bottom-right-radius: 5px;padding-right:10px; justify-content:end;'><b>$$total</b></p>
                            </div>
                            <div class='checkout btn-final'></div>
                            <div class='continuar'>
                                <button type='button' class='btn-final' id='continuar'>Continúa comprando</button>
                            </div>
                        </div>
                    </div>
        ";

        if (isset($_GET['elim'])){
            $carrito .= "<div class='mensaje' id='mensaje'>¡El producto se ha eliminado correctamente!</div>";
        }
        else if (isset($_GET['error_pago'])){
            $carrito .= "<div class='mensaje' style='background:#E53935;'>¡El pago no se ha procesado correctamente, reintente por favor!</div>";
        }
        else if (isset($_GET['fav'])){
            $fav = $_GET['fav'];
            if ($fav == 'ok'){
                $carrito .= "<div class='mensaje' id='mensaje' style='background-color: #099;'>
                                ¡El producto se ha agregado a <a href='favoritos.php'>favoritos</a> correctamente!
                            </div>";
            }
            else{
                $carrito .= "<div class='mensaje' id='mensaje' style='background: rgb(241, 196, 15); color:#000;'>
                                ¡El producto ya pertenece a <a href='favoritos.php' style='color:#000;'>favoritos</a>!
                            </div>";
            }
        }
        $carrito .= "
        </div>
        <a href='carritoXLS.php' title='Excel de compras' style='margin: 10px 0 0 10px; height:40px;'>
            <img src='images/logo_excel.png' title='Exportar a Excel' alt='icono Excel' > 
        </a>"; 
    }  
?>  
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css"  href="assets/css/estilos.css" rel="stylesheet"/>
    <title>Muebles Giannis</title>
    <link rel="icon" type="image/png" href="images/logo_sitio.png">
    <script src="https://sdk.mercadopago.com/js/v2"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="js/funciones.js"></script>
    <style>
        main{
            display:flex;
            justify-content:center;
            padding-bottom: 30px;
            flex-wrap: wrap;
        }

        .carrito{
            width:90%;
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
            height:180px;
            padding:10px 0;
            margin: 0 10px;
        }

        .productos{
            width: 160px;
            height:160px;
            padding-right: 10px;
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
            width:65%;
            display:flex;
            justify-content:start;
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
            width:255px;
            height: auto;
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
            margin: 0 10px;
            text-align: center;
            background-color: #000;
            color: white;
            border-radius:5px;
            height:30px;
            padding: 10px 5px;
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
    </style>
    <script>
        //TODO: USAR QUERYSELECTORALL
        //TODO: VALIDAD CON PHP: EXISTE LA FUNCION FILTER_VAR(MI VARIABLE, TIPO(FILTER_VALIDATE_INT))

        document.addEventListener ('DOMContentLoaded', () => {
            let continuar = document.getElementById('continuar');

            continuar.addEventListener("click", () => {
                window.location = "productos.php?productos=todos";
            });     

            let ocultar = document.getElementById('ocultar');

            if (ocultar != null){
                let mp = document.getElementsByClassName('mercadopago-button');

                for (let i=0; i < mp.length;i++){
                    mp[i].style.visibility = 'hidden';
                }
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
</head>
<body id="body">

    <header>
        <?= $encab; ?>
    </header>
    
    <main>      
        <?= $ruta; ?>
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
                label: "Proceder a la compra" 
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
                    label: "Proceder a la compra"
                }
            });
        }      
    </script>  
    <!-- -->

</body>
</html>