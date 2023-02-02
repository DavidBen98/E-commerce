<?php
	require_once 'vendor/autoload.php';
    require_once 'config.php';
    require_once 'inc/conn.php';

	$auth = new TwitterAuth($cliente);

    global $db;
    
    //Si se realizó un pago con mercado pago
    if (isset($_GET['failure'])){ //Si falló
        header('location: pago.php?error_pago=fallo');
    }
    else if(isset($_GET['payment_id'])){
        $paymentId = $_GET['payment_id'];   
        $response = file_get_contents("https://api.mercadopago.com/v1/payments/$paymentId" . "?access_token=TEST-5976931908635341-011902-66f238a2e8fba7fb50819cd40a6ecef9-172145106");
        $response = json_decode($response);

        if ($response->status == "approved"){
            $productos = isset ($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
            $listaCarrito = array();

            foreach ($productos as $key => $cantidad){
                $sql = $db->prepare("SELECT id
                                     FROM producto
                                     WHERE id=?");
                $sql -> execute ([$key]);
                $listaCarrito[] = $sql->fetch(PDO::FETCH_ASSOC);
            }

            $idUsuario = "";

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
                        FROM usuarios as u
                        INNER JOIN usuarios_rs as rs ON rs.id = u.id
                        WHERE rs.id_social = $idUsuario
                ";

                $rs = $db->execute($sql);

                foreach ($rs as $row){
                    $idUsuario = $row['id'];
                }
            }

            $monto = $response->transaction_amount;
            $email = $response->payer->email;
            $fecha = $response->date_approved;

            $sql = "INSERT INTO `compra`(`id_usuario`,`total`, `id_transaccion`, `fecha`, `estado`, `email`) 
                    VALUES ('$idUsuario','$monto','$paymentId','$fecha','RECIBIDO', '$email')
            ";

            $rs = $db->query($sql);

            $idCompra = $db->lastInsertId();

            $items = $response->additional_info->items;

            for ($i=0;$i<count($items);$i++){
                $idProducto = $listaCarrito[$i]['id'];
                $nombre = $items[$i]->title;
                $precioUnitario = $items[$i]->unit_price;
                $cantidad = $items[$i]->quantity;

                $sql = "INSERT INTO detalle_compra (id_compra, id_producto, nombre, precio, cantidad) VALUES
                            ('$idCompra','$idProducto','$nombre','$precioUnitario','$cantidad')
                ";
                
                $rs = $db->query($sql);
            }

            unset($_SESSION['carrito']);

            header('location:index.php');
        }
    }
    else if($auth->login()){
        header ('location: index.php');
    }
    else{
        die('Error al inicio de sesion');
    }
?>