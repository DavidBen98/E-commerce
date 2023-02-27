<?php
	require_once "../vendor/autoload.php";
    require_once "config.php";
    require_once "../inc/conn.php";

	// $auth = new TwitterAuth($cliente);

    global $db;
    
    //Si se realizó un pago con mercado pago
    if (isset($_GET["failure"])){ //Si falló
        header("location: ../vistas/pago.php?error_pago=fallo");
        exit;
    }
    else if(isset($_GET["payment_id"]) && ctype_alnum($_GET["payment_id"])){
        $payment_id = filter_var($_GET["payment_id"], FILTER_SANITIZE_STRING);    
        $response = file_get_contents("https://api.mercadopago.com/v1/payments/$payment_id" . "?access_token=TEST-5976931908635341-011902-66f238a2e8fba7fb50819cd40a6ecef9-172145106");
        $response = json_decode($response);

        if ($response->status == "approved"){
            $productos = isset ($_SESSION["carrito"]["productos"]) ? $_SESSION["carrito"]["productos"] : null;
            $lista_carrito = array();
            $lista_carrito[] = obtener_lista_carrito($productos);      

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
                $rs = obtener_usuario_con_rs ($id_usuario);

                foreach ($rs as $row){
                    $id_usuario = $row["id"];
                }
            }

            $monto = $response->transaction_amount;
            $email = $response->payer->email;
            $fecha = $response->date_approved;

            $id_compra = insertar_compra($id_usuario,$monto,$payment_id,$fecha,"RECIBIDO", $email);

            $items = $response->additional_info->items;

            for ($i=0;$i<count($items);$i++){
                $id_producto = $lista_carrito[$i]["id"];
                $nombre = $items[$i]->title;
                $precio_unitario = $items[$i]->unit_price;
                $cantidad = $items[$i]->quantity;

                insertar_detalle_compra($id_compra,$id_producto,$nombre,$precio_unitario,$cantidad);
            }

            unset($_SESSION["carrito"]);

            header("location:../vistas/index.php?compra=éxito");
            exit;
        }
    }
    else if($auth->login()){
        header ("location: ../vistas/index.php");
        exit;
    }
    else{
        die("Error al inicio de sesion");
    }
?>