<?php
	require_once('vendor/autoload.php');
    require_once('config.php');

	$auth = new TwitterAuth($cliente);
    global $db;

    //Si se realizó un pago con mercado pago
    if(isset($_GET['payment_id'])){
        $payment = $_GET['payment_id'];
        $status = $_GET['status'];
        $payment_type = $_GET['payment_type'];
        $order_id = $_GET['merchant_order_id'];
        $fecha_nueva = date('Y-m-d H:i:s', strtotime($fecha));
        
        echo "<h3>Pago Exitoso </h3>";
        echo $payment . '<br>';
        echo $status . '<br>';
        echo $payment_type . '<br>';
        echo $order_id . '<br>';

       
        $id_usuario = "";

        if (isset($_SESSION['idUsuario'])){ //si se inició sesion desde una cuenta nativa
            $id_usuario = $_SESSION['idUsuario'];
        }
        else if (isset($_SESSION['id'])){ //Si se inicio sesion desde Google
            $id_usuario = $_SESSION['id'];

            $sql = "SELECT id
            FROM usuarios as u
            INNER JOIN usuarios_rs as rs ON rs.id = u.id
            WHERE rs.id_social = $id";

            $rs = $db->execute($sql);
        }
        else if (isset($_SESSION["user_id"])){ //Si se inicio sesion desde twitter
            $id_usuario = $_SESSION["user_id"];

            $sql = "SELECT id
            FROM usuarios as u
            INNER JOIN usuarios_rs as rs ON rs.id_usuario = u.id
            WHERE rs.id_social = $id";

            $rs = $db->execute($sql);

        }

        unset($_SESSION['carrito']);
    }
    else if (isset($_GET['failure'])){
        echo "fallo el pago";
    }
    else if($auth->login()){
        header ('location: login.php');
    }
    else{
        die('Error al inicio de sesion');
    }

?>