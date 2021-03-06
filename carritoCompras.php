<?php 
    include ("pie.php"); 
    include ("inc/conn.php");
    require_once 'config.php';
    require_once 'vendor/autoload.php';
    include("encabezado.php"); 

    define ('TOKENMERCADOPAGO','TEST-5976931908635341-011902-66f238a2e8fba7fb50819cd40a6ecef9-172145106');
    define ('CREDENCIALPRUEBAMP', 'TEST-b052d91d-3a4e-4b65-9804-7c2b716a0608');
  
    if (perfil_valido(3) && (!isset($_GET['code']) || !isset($_SESSION['user_first_name'])) && (!isset($_SESSION['nombre_tw']))) {
        header("location:login.php"); 
        //TODO: cambiarlo por abrir una ventana emergente que pregunte si se quiere registrar o iniciar sesion
    }
    else if (perfil_valido(1)) {
        header("location:veABMProducto.php");
    }

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
                                 WHERE id=?
            ");

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
                    <h1 style='font-family: museosans500,arial,sans-serif; margin:0; font-size:1rem;'>
                    CARRITO DE COMPRAS - PRODUCTOS AÑADIDOS
                    </h1>
                    <p style='font-size: 0.9rem; font-weight:700; color: #858585; font-family: museosans500,arial,sans-serif; margin:0;'>  
                        $productos_agregados PRODUCTO";
                    
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

            $carrito .= "<div class='contenedor'>
                            <div class='descrip'> 
                                <div class='principal'>                                                                                          
                                    <img src='images/$id/$codigo.png' class='productos img-cat' alt='$codigo' style='border:none;'>
                                        <div class='titulo'>
                                            <div class='cont-enlaces' style='display:flex; flex-wrap:wrap;'>
                                                <p class='enlace' style='color:#000; margin-top:10px; width:100%;'> $descripcion</p>
                                                <p class='enlace' style='font-size:16px; color: #858585;'> $marca</p>
                                            </div> 
                                            <div class='contenedor-eventos'>
                                                <div class='evento-producto' style='padding-right: 3%; text-aling: end; border-right: 1px solid #D3D3D3;'>
                                                    <img src='images/eliminar.png' style='width:20px; height:20px; margin-right:1px;' alt='Eliminar producto'>
                                                    <button class='elim-prod' value='$id'> Eliminar producto</button>
                                                </div>
                                                <div class='evento-producto' style='text-align:start; padding-left: 3%'>
                                                    <img src='images/fav-carr.png' style='width:20px; height:20px; margin-right:1px;' alt='Agregar a favoritos'>
                                                    <button class='fav-prod' value='$id'> Agregar a favoritos</button>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class='secundario'>
                                        <table id='vertical-1'>
                                            <tr>
                                                <th class='definir'><b>Color:</b></th>
                                                <td class='caract'> $color </td>
                                            </tr>
                                            <tr>
                                                <th class='definir'><b>Material:</b></th>
                                                <td class='caract'>$material</td>
                                            </tr>
                                            <tr>
                                                <th class='definir'><label for='cant-$selectNumero' class='labelSelect' id='$id'><b>Cantidad:</b></label></th>
                                                <td class='caract'>
                                                    <select class='cant-compra' id='cant-$selectNumero' name='cant-$selectNumero' title='Cantidad'>";
                                                        for ($j=1; $j<=$stock; $j++){
                                                            if ($j == $cantidad){
                                                                $carrito .= "<option value='$j' selected>$j</option>";
                                                            }
                                                            else{
                                                                $carrito .= "<option value='$j'>$j</option>";
                                                            }
                                                        }
                $carrito .="                    </select>
                                            </td>
                                        </tr>
                                        </table>
                        </div>                                            
                    </div>

                    <div class='precio'>
                        <p style='border-bottom: 0.5px solid #D3D3D3; padding:0 0 1% 1%; margin-left:4%;'>Precio unitario </p> 
                        <div id='precioU-$selectNumero' style='display:flex; border-bottom: 0.5px solid #D3D3D3; padding:0 0 1% 1%; font-family: Arial,Helvetica,sans-serif;'>";
                            if($precio != $precio_desc){
                                $carrito .= "<p style='text-decoration:line-through; font-size:0.85rem;'>$$precio</p>";
                            }
                                $carrito .= "<p>$$precio_desc</p>
                        </div>
                        <p style='padding: 1% 0 0 1%; margin-left:4%'>Precio </p> 
                        <p id='precioS-$selectNumero' style='padding: 1% 0 0 1%; font-family: Arial,Helvetica,sans-serif;'>
                            <b>$".$subtotal."</b>
                        </p>
                    </div>
                </div>
            ";

            $selectNumero++;
        }

        $carrito .= "<div class='contenedor-botones'>
                        <div class= 'botones'>
                            <div class='totales' style='height:40px;'>
                                <p class='subtotal txt-totales'>Subtotal:</p> 
                                <p class='subtotal txt-totales' id='subtotal' style='justify-content:end;'> $$total </p>
                            </div>
                            <div class='totales' style='height:50px;'>
                                <p class='txt-totales total' style='border-bottom-left-radius: 5px;'>
                                    <b style='font-size: 1.1rem;'>Total</b> 
                                </p> 
                                <p class='total txt-totales' id='total'>
                                    <b>$$total</b>
                                </p>
                            </div>
                            <div class='btnRedirigir'>
                                <button type='button' class='btn-final' id='procederCompra'>Proceder a la compra</button>
                            </div>
                            <div class='continuar'>
                                <button type='button' class='btn-final' id='continuar'>Continúa comprando</button>
                            </div>
                        </div>
                    </div>
        ";

        if (isset($_GET['elim'])){
            $carrito .= "<div class='mensaje' id='mensaje'>¡El producto se ha eliminado correctamente!</div>";
        }
        else if (isset($_GET['fav'])){
            $fav = $_GET['fav'];
            if ($fav == 'ok'){
                $carrito .= "<div class='mensaje' id='mensaje' style='background-color: #099;'>
                                ¡El producto se ha agregado a <a href='favoritos.php'>favoritos</a> correctamente!
                            </div>
                ";
            }
            else{
                $carrito .= "<div class='mensaje' id='mensaje' style='background: rgb(241, 196, 15); color:#000;'>
                                ¡El producto ya pertenece a <a href='favoritos.php' style='color:#000;'>favoritos</a>!
                            </div>
                ";
            }
        }
        $carrito .= "
        </div>
        <a href='carritoXLS.php' title='Excel de compras' style='margin: 10px 0 0 10px; height:40px;'>
            <img src='images/logo_excel.png' title='Exportar a Excel' alt='icono Excel' > 
        </a>"; 
    }  
?> 
<!DOCTYPE html>
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
            width:80%;
            background-color: white;
            padding:2%;
            font-size: 1rem;
            border-radius:5px;
        }

        .contenedor{
            display: flex;
            justify-content:space-between;
            flex-wrap:wrap;
            align-items:center;
            border-bottom: 1px solid #D3D3D3;
            min-height:180px;
            padding:1% 0;
            margin: 0 1%;
        }

        .productos{
            width: 30%;
            max-height: 120px;
            padding-right: 2%;
            object-fit: contain;
        }

        .descrip{
            width:70%;
            height: 100%;
            display: flex;
            justify-content: start;
            align-items: center;
        }

        .precio{
            width:250px;
            min-height: 180px;
            display: flex;
            align-content: center;
            flex-wrap:wrap;
            justify-content:space-between;
            border-left: 1px solid #D3D3D3;
            text-align:start;
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
            margin: 0;
            border-bottom: 1px solid #D3D3D3;
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
            display:flex;
            flex-wrap:wrap;
            align-content:start;
        }

        th{
            padding: 3%;
        }
        .secundario > div{
            width: 95%;
            display: flex;
            margin-left: 5%;
        }

        .secundario p{
            color: #000;
            font-size: 14px;
            text-align:start;
        }

        .definir{
            width:30%;
            min-width: 100px;
        }

        .caract{
            padding-left:2%;
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
            width: 68%;
            height: auto;
        }

        .botones{
            height:100%;
            width:30%;
            margin: auto;

        }

        .botones .checkout {
            height: 20%;
        }

        .btnRedirigir, .continuar{
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

        #subtotal{
            padding-right: 4%;
        }

        #total{
            border-bottom-right-radius: 5px;
            padding-right:4%; 
            justify-content:end;
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

        .btnRedirigir button{
            width:250px;
            height: 40px;
            background: #009ee3;
            color: white; 
            border:none;
            border-radius: 5px;
            font-weight: 700;
            cursor: pointer;
        }

        .btnRedirigir button:hover{
            transition: all 0.3s linear;
            color: white;
            cursor:pointer;
            background: #099;
        }

        #continuar{
            width:250px;
            padding: 5%;
            background: rgba(147, 81, 22,0.5);
            color: #000;
            border-radius: 5px;
            font-weight: 700;
            cursor: pointer;
            border: none;
        }

        #continuar:hover{
            background-color: rgba(147, 81, 22,1);
            transition: all 0.3s linear;
            color: white;
            cursor:pointer;
        }

        .cant-compra{
            padding: 0.5em 0.5em;
            border-color: #D3D3D3;
            border-radius: 2px;
            color: #4a4a4a;
        }

        .contenedor-eventos{
            display:flex;
            justify-content:center;
            width:100%;
            text-align:start;
            margin-top:20px;
            font-size: 0.8rem;
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
            cursor: pointer;
        }
        
        .contenedor-botones{
            width: 99%;
            margin: 0;
            margin-right: 2%;
            display:flex;
            justify-content:end;
        }
        
        .botones{
            margin: 0;
            width: auto;
        }
        
        .precio{
            margin:0;
        }
        
        .btnRedirigir{
            height: auto;
        }
        
        .btnRedirigir button{
            height: auto;
            padding: 5%;
            margin-top: 10%;
        }

        th{
            text-align: start;
        }
        
        @media screen and (max-width: 1100px){
                .descrip{
                    width: 100%;
                }
                
                .precio{
                    margin: 5% auto;
                    border: none;
                    min-height: auto;
                }
                
                .secundario{
                    width: 50%;
                    justify-content:center;
                }
                
                .secundario > div{
                    justify-content:center;
                }
                
                .contenedor-eventos{
                    justify-content:start;
                }

                .contenedor-botones{
                    justify-content:center;
                }
                
                /*.contenedor-botones{*/
                /*    width: 55%;*/
                /*}*/
            }
    
        
        @media screen and (max-width: 860px){
            .carrito{
                width: 95%;
                margin: auto;
            }

            .descrip{
                width:100%;
                height:100%;
                display:flex;
                justify-content: space-between;
                flex-wrap:wrap;
            }
            
            .principal, .secundario{
                width: 100%;
            }
            
            main > a{
                display:none;
            }
            
            .precio{
                width:100%;
                margin:auto;
                border:none;
                min-height: auto;
            }
            
            .secundario{
                justify-content: center;
                background: #d3d3d3;
                margin: 2% 0;
                border-radius: 5px;
            }
            
            .secundario > div{
                margin: 0;
                justify-content:center;
            }
            
            .contenedor{
                padding: 4% 0;
            } 
            
            .continuar{
                margin: 0;
            }
            
            #continuar{
                width: 100%;
            }

            table{
                width: 40%;
                margin: 2% auto;
            }

            td, th{
                width: 50%;
            }

            .definir{
                width:45%;
                padding: 0 0 1% 1%;
                /* border-bottom: 1px solid #d3d3d3; */
            }

            .caract{
                /* border-bottom: 1px solid #d3d3d3; */
                margin: 0;
            }

            .precio{
                justify-content:start;
            }
        }
    </style>
</head>
<body id="body">

    <header>
        <?= $encabezado; ?>
    </header>
    
    <main>      
        <?= $ruta; ?>
        <?= $carrito; ?>
    </main> 
    
    <footer id='pie'>
        <?= $pie; ?> 
    </footer>

</body>
</html>