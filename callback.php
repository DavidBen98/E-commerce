<?php
    include 'config.php';
	require_once('vendor/autoload.php');
    require_once('inc/conn.php');

	$auth = new TwitterAuth($cliente);
    global $db;

    //Si se realizó un pago con mercado pago
    if (isset($_GET['failure'])){ //Si falló
        header('location: carritoCompras.php?error_pago=fallo');
    }
    else if(isset($_GET['payment_id'])){
        $payment_id = $_GET['payment_id'];   
        $response = file_get_contents("https://api.mercadopago.com/v1/payments/$payment_id" . "?access_token=TEST-5976931908635341-011902-66f238a2e8fba7fb50819cd40a6ecef9-172145106");
        $response = json_decode($response);

        if ($response->status == "approved"){
            $productos = isset ($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
            $lista_carrito = array();

            foreach ($productos as $key => $cantidad){
                $sql = $db->prepare("SELECT id
                                     FROM producto
                                     WHERE id=?");
                $sql -> execute ([$key]);
                $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
            }

            $id_usuario = "";

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
                        FROM usuarios as u
                        INNER JOIN usuarios_rs as rs ON rs.id = u.id
                        WHERE rs.id_social = $id_usuario
                ";

                $rs = $db->execute($sql);

                foreach ($rs as $row){
                    $id_usuario = $row['id'];
                }
            }

            $monto = $response->transaction_amount;
            $email = $response->payer->email;
            $fecha = $response->date_approved;

            $sql = "INSERT INTO `compra`(`id_usuario`,`total`, `id_transaccion`, `fecha`, `estado`, `email`) 
                    VALUES ('$id_usuario','$monto','$payment_id','$fecha','RECIBIDO', '$email')
            ";

            $rs = $db->query($sql);

            $id_compra = $db->lastInsertId();

            $items = $response->additional_info->items;

            for ($i=0;$i<count($items);$i++){
                $id_producto = $lista_carrito[$i]['id'];
                $nombre = $items[$i]->title;
                $precio_unitario = $items[$i]->unit_price;
                $cantidad = $items[$i]->quantity;

                $sql1 = "INSERT INTO detalle_compra (id_compra, id_producto, nombre, precio, cantidad) VALUES
                            ('$id_compra','$id_producto','$nombre','$precio_unitario','$cantidad')
                ";
                
                $rs = $db->query($sql1);
            }

            unset($_SESSION['carrito']);

            header('location:informacionPersonal.php');
        }
    }
    else if($auth->login()){
        header ('location: index.php');
    }
    else{
        die('Error al inicio de sesion');
    }
?>