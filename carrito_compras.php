<!DOCTYPE html>
<?php 
    include ("pie.php"); 
    include ("inc/conn.php");
    include ('config.php');
    require_once 'vendor/autoload.php';
    include("encabezado.php"); 
    define ('TOKENMERCADOPAGO','TEST-5976931908635341-011902-66f238a2e8fba7fb50819cd40a6ecef9-172145106');
    define ('CREDENCIALPRUEBAMP', 'TEST-b052d91d-3a4e-4b65-9804-7c2b716a0608');

    
    if (perfil_valido(3)) {
        header("location:login.php"); //cambiarlo por abrir una ventana emergente que pregunte si se quiere registrar o iniciar sesion
    }
    else if (perfil_valido(1)) {
        header("location:ve.php");
    }

    MercadoPago\SDK::setAccessToken(TOKENMERCADOPAGO);

    $preference = new MercadoPago\Preference();

    $productos_mp = array();
?>  
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css"  href="css/estilos.css" rel="stylesheet"/>
    <title>Catato Hogar</title>
    <!--<link rel="icon"  type="image/png" href="icono.png"> -->
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <style>
        main{
            display:flex;
            justify-content:center;
            padding-bottom: 30px;
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

        .descripcion{
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
            background: #ededed;
            border-radius: 5px;
            border: none;
            font-weight: 700;
            cursor: pointer;
        }

        .continuar button:hover{
            background-color: #B2BABB;
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
    </style>
    <script>
		function excel() {			
			document.getElementById("datos").method = "post";
			document.getElementById("datos").action = "carrito_xls.php";
			document.getElementById("datos").submit(); 
		}	

        window.onload = function (){
            let continuar = document.getElementsByClassName('btn-final');

            for (let j=0;j<continuar.length;j++){
                continuar[1].addEventListener("click", () => {
                    window.location = "productos.php?productos=todos";
                });
            }

            let productos = document.getElementsByClassName('contenedor');
            var subtotal = document.getElementById('subtotal');
            var total = document.getElementById('total');
            var sumaTotal = 0;

            for (let i=1; i <= productos.length; i++){
                var precioProducto = document.getElementById('precioS-'+i).textContent;
                sumaTotal += parseInt(precioProducto.slice(1)); //Obtengo el total sin actualizar
            }

            for (let i=1; i <= productos.length; i++){
                let valorSeleccionado = document.getElementsByName('cant-'+i);

                valorSeleccionado[0].addEventListener ("change", () => {
                    var cantSeleccionada = valorSeleccionado[0].value;

                    var precioProd = document.getElementById('precioS-'+i).textContent;
                    precioProd = precioProd.slice(1);

                    var precioUnitario = document.getElementById('precioU-'+i).textContent;
                    precioUnitario = precioUnitario.slice(1);

                    var sumaSubtotal = parseInt(cantSeleccionada) * parseInt(precioUnitario);
                    
                    var precioSubtotal = document.getElementById('precioS-'+i);

                    precioSubtotal.innerHTML= "<b>$" + sumaSubtotal + "</b>";

                    sumaTotal = sumaTotal + sumaSubtotal - precioProd;
                    subtotal.innerHTML = "$ " + sumaTotal;
                    total.innerHTML = "<b>$ " + sumaTotal + "</b>";
                });
            }          
        }
	</script>
</head>
<body id="body">

    <header>
        <?php
		    echo $encab;     
        ?>
    </header>
    
    <main>           
        <?php 
            $idUsuario =$_SESSION['idUsuario'];

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

            echo"<input type='hidden' name='idUsuario' id='idUsuario' value='$idUsuario'/>";
            echo "<div class='carrito'>
                    <div class='checkout-btn cont-btn'>
                        <div>
                            <p style='margin:0; height:30px;'>
                                <b style='font-family: museosans500,arial,sans-serif;'>CARRITO DE COMPRAS - PRODUCTOS AÑADIDOS</b><br>
                            </p>
                            <p style='font-size: 0.9rem; font-weight:700; color: #858585; font-family: museosans500,arial,sans-serif; margin:0;'>  
                                ". $productos_agregados ." PRODUCTOS
                            </p>
                        </div>
                    </div>";

            global $db; 

            if ($lista_carrito == null){
                echo "<div> Aún no hay productos agregados</div>";
            }
            else{
                $selectNumero = 1; 
                $total = 0;

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
                    $precio = intval($producto['precio']);
                    $descuento = intval($producto['descuento']);
                    $precio_desc = $precio - (($precio * $descuento) /100);
                    $subtotal += $cantidad * $precio_desc; 
                    $total += $subtotal; 

                    if ($stock < $cantidad){
                        $cantidad = $stock;
                    }
                    
                    $i = 1;

                    $item = new MercadoPago\Item();
                    $item->id = $i;
                    $item->title = $descripcion;
                    $item->quantity = 1;
                    $item->unit_price = $precio;
                    $item->currency_id = "ARS";

                    array_push($productos_mp, $item);
                    unset ($item);

                    $i++;

                    echo "<div class='contenedor'>
                            <div class='descripcion'> 
                                <div class='principal'>                                                                                          
                                    <img src='images/$codigo.png' class='productos' alt='Codigo del producto:$codigo'>
                                        <div class='titulo'>
                                            <p style='color:#000; margin-top:10px;'>$descripcion</p> 
                                            <p style='font-size:16px;'>$marca</p> 
                                            <div class='elim-fav'>
                                                <a class='elim-producto' href='carrito_compras.php?id=$id' style='width:45%; padding-right: 8px; border-right: 1px solid #D3D3D3;' >
                                                    <img src='images/eliminar.png' style='width:20px; height:20px; margin-right:1px;' alt=''>
                                                    <span  id='elim-prod-$selectNumero'> Eliminar producto</span>
                                                </a>
                                                <a class='elim-producto' style='text-align:end;' href='carrito_compras.php?id=$id'>
                                                        <img src='images/fav-carr.png' style='width:20px; height:20px; margin-right:1px;' alt=''>
                                                        Agregar a favoritos
                                                </a>
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
                                            <select class='cant-compra' name='cant-$selectNumero' title='Cantidad'>";
                                                for ($j=1; $j<=$stock; $j++){
                                                    if ($j == $cantidad){
                                                        echo "<option value='$j' selected>$j</option>";
                                                    }
                                                    else{
                                                        echo "<option value='$j'>$j</option>";
                                                    }
                                                }
                        echo"               </select>
                                        </p>
                                </div>                                            
                            </div>

                            <div class='precio'>
                                <p style='border-bottom: 0.5px solid #D3D3D3; padding:0 0 5px 5px; margin-left:15px;'>Precio unitario </p> 
                                <p id='precioU-$selectNumero' style='border-bottom: 0.5px solid #D3D3D3; padding:0 0 5px 5px; font-family: Arial,Helvetica,sans-serif;'>$$precio_desc</p>
                                <p style='padding: 5px 0 0 5px; margin-left:15px'>Precio </p> 
                                <p id='precioS-$selectNumero' style='padding: 5px 0 0 5px; font-family: Arial,Helvetica,sans-serif;'><b>$".$subtotal."</b></p>
                            </div>
                        </div>";

                    $selectNumero++;
                }
            }                        
            
            echo "<div class='contenedor-botones'>
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
            </div>"; 
                                         
        ?>

        <a href="carrito_xls.php" title='Excel de compras' style='margin: 10px 0 10px 10px;'>
            <img src='images/logo_excel.jpeg' title='Excel de compra.' alt="icono Excel." > 
        </a>  
    </main>  
    
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
                label: "Proceder a la compra" // Cambia el texto del botón de pago (opcional)
            }
        });

        const mercadoPago = new MercadoPago('TEST-b052d91d-3a4e-4b65-9804-7c2b716a0608', {
            locale: "es-AR",
        });

        // Inicializa el checkout
        mercadoPago.checkout({
            preference: {
                id: '<?php echo $preference->id; ?>'
            },
            render: {
                container: ".checkout", // Indica el nombre de la clase donde se mostrará el botón de pago
                label: "Proceder a la compra" // Cambia el texto del botón de pago (opcional)
            }
        });
    </script>  

    <?php
        echo $pie;
    ?> 
</body>
</html>