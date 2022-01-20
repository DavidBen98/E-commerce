<?php
	require_once('vendor/autoload.php');
    require_once('config.php');

	$auth = new TwitterAuth($cliente);

    //Si se realizó un pago con mercado pago
    if(isset($_GET['payment_id'])){
        $payment = $_GET['payment_id'];
        $status = $_GET['status'];
        $payment_type = $_GET['payment_type'];
        $order_id = $_GET['merchant_order_id'];
        
        echo "<h3>Pago Exitoso </h3>";
        echo $payment . '<br>';
        echo $status . '<br>';
        echo $payment_type . '<br>';
        echo $order_id . '<br>';
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