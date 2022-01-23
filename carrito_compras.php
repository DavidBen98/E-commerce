<!DOCTYPE html>
<?php 
    include ('config.php');
    include("encabezado.php"); 
    include("pie.php"); 
    include ("inc/conn.php");

    if (perfil_valido(3)) {
        header("location:login.php");
    }
    else if (perfil_valido(1)) {
        header("location:ve.php");
    }

    require 'vendor/autoload.php';

    MercadoPago\SDK::setAccessToken('TEST-5976931908635341-011902-66f238a2e8fba7fb50819cd40a6ecef9-172145106');

    $preference = new MercadoPago\Preference();

    $item = new MercadoPago\Item();
    $item->id = '0001';
    $item->title = 'Producto 1';
    $item->quantity = 1;
    $item->unit_price = 150;

    $preference->items = array($item);

    $preference->back_urls = array (
        "success" => "localhost/E-commerceMuebleria/callback.php",
        "failure" => "localhost/E-commerceMuebleria/callback.php?failure=true"
    );

    $preference->auto_return = "approved";
    $preference->binary_mode = true;

    $preference->save();
?>  
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css"  href="css/estilos.css" rel="stylesheet"/>
    <title>Catato Hogar</title>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <style>
        main{
            display:flex;
            justify-content:center;
            padding-bottom: 30px;
        }

        .carrito{
            width: 80%;
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
            padding: 10px;
            object-fit: contain;
        }

        .descripcion{
            width:70%;
            height:100%;
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
            height: 180px;
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
            flex-wrap:wrap;
            align-content:start;
        }

        .secundario p{
            height: 20px;
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

        .titulo{
            width:200px;
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

        #total{
            background-color: #D3D3D3;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
            color: #000;
            margin: 0;
            padding: 5px;
            font-family: museosans500,arial,sans-serif;
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

        .cant-compra{
            padding: 5px 10px;
        }

    </style>
    <script>
		function excel() {			
			document.getElementById("datos").method = "post";
			document.getElementById("datos").action = "carrito_xls.php";
			document.getElementById("datos").submit(); 
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
            echo"<input type='hidden' name='idUsuario' id='idUsuario' value='$idUsuario'/>";

            global $db; 
                        
            $sql= "SELECT `precio`,`producto_codigo`,p.descripcion, u.id, p.material, p.color, p.marca, p.stock
                    FROM `pedido` as c INNER JOIN `usuario` as u ON (c.usuario_id=u.id)
                                        INNER JOIN `producto` as p on(c.producto_codigo=p.codigo)
                    WHERE u.id=$idUsuario
            "; 

            $rs = $db->query($sql);
 
            $productosAgregados=0;
 
            foreach ($rs as $row){
                $productosAgregados++;
            }

            $rs = $db->query($sql);

            if ($productosAgregados == 0){
                echo "<div>Aún no hay productos agregados";
            }
            else{
                echo "<form class='carrito'>"; 
                    echo "<div class='checkout-btn cont-btn'>
                            <p style='margin:0; height:50px;'>
                                <b style='font-family: museosans500,arial,sans-serif;'>Carrito de compras - Productos añadidos</b><br>
                                ". $productosAgregados ." Productos
                            </p>
                        </div>";

                $selectNumero = 1; 

                foreach ($rs as $row) {  
                    echo "<div class='contenedor'>";
                        echo "<div class='descripcion'>";  
                            echo "<div class='principal'>";                                                                                          
                                echo "<img src='images/{$row['producto_codigo']}.png' class='productos' alt='Codigo del producto:{$row['producto_codigo']}'>";
                                    echo "<div class='titulo'>";
                                        echo "<p style='color:#000; margin-top:10px;'>".ucfirst($row['descripcion'])."</p>"; 
                                        echo "<p style='font-size:16px;'>".ucfirst($row['marca'])."</p>"; 
                                    echo "</div>";
                            echo "</div>";
                            echo "<div class='secundario'>
                                        <p class='definir'> 
                                            <b>Color:</b>
                                        </p> 
                                        <p class='caract'> ".ucfirst($row['color']) . "</p>
                                        <p class='definir'> 
                                            <b>Material:</b>
                                        </p> 
                                        <p class='caract'> ".ucfirst($row['material']) . "</p>
                                        <p class='definir'>
                                            <b>Cantidad:</b>
                                        </p> 
                                        <p class='caract'>
                                            <select class='cant-compra' name='cant-".$selectNumero."' title='Cantidad'>";
                                                for ($i=1; $i<=$row['stock']; $i++){
                                                    echo "<option value=".$i.">". $i . "</option>";
                                                }
                        echo"               </select>
                                        </p>";
                            echo "</div>";                                            
                        echo "</div>";

                        echo "<div class='precio'>
                                <p style='border-bottom: 0.5px solid #D3D3D3; padding:0 0 5px 5px; margin-left:15px;'>Precio unitario </p> 
                                <p style='border-bottom: 0.5px solid #D3D3D3; padding:0 0 5px 5px; font-family: Arial,Helvetica,sans-serif;'> $ ". $row['precio'] . "</p>
                                <p style='padding: 5px 0 0 5px; margin-left:15px'>Precio </p> 
                                <p style='padding: 5px 0 0 5px; font-family: Arial,Helvetica,sans-serif;'><b>$&nbsp; </b></p>";
                                // echo "$subTot";
                                // $totSubTotal += $row['precio_unidad'] * $row['cantidad'];
                        echo "</div>";
                    echo "</div>";

                    $selectNumero++;
                }                             

                $redirigir = "window.location.href='productos.php?productos=todos'"; //NO FUNCIONA
                echo "<div class='contenedor-botones'>
                        <div class= 'botones'>
                            <p id='total'><b>Total </b> </p>
                            <div class='checkout btn-final'></div>
                            <div class='continuar'>
                                <button class='btn-final' onclick=".$redirigir.">Continúa comprando</button>
                            </div>
                        </div>
                    </div>
                </form>"; 
            }                                  
            ?>

            <a href="carrito_xls.php" title='Excel de compras' style='margin:10px;'>
                <img src='images/logo_excel.jpeg' title='Excel de compra.' alt="icono Excel." > 
            </a>
        
        
        <script>
            const mp = new MercadoPago("TEST-b052d91d-3a4e-4b65-9804-7c2b716a0608", {
                locale: "es-AR",
            });

            // Inicializa el checkout
            mp.checkout({
                preference: {
                    id: '<?php echo $preference->id; ?>'
                },
                render: {
                    container: ".checkout-btn", // Indica el nombre de la clase donde se mostrará el botón de pago
                    label: "Proceder a la compra", // Cambia el texto del botón de pago (opcional)
                },
            });

            mp.checkout({
                preference: {
                    id: '<?php echo $preference->id; ?>'
                },
                render: {
                    container: ".checkout", // Indica el nombre de la clase donde se mostrará el botón de pago
                    label: "Proceder a la compra", // Cambia el texto del botón de pago (opcional)
                },
            });

        </script>    
    </main>   

    <?php
        echo $pie;
    ?> 
</body>
</html>