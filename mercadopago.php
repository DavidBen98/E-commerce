<?php
    require 'vendor/autoload.php';

    MercadoPago\SDK::setAccessToken('TEST-5976931908635341-011902-66f238a2e8fba7fb50819cd40a6ecef9-172145106');

    $preference = new MercadoPago\Preference();

    $item = new MercadoPago\Item();
    $item->id = '0001';
    $item->title = 'Producto 1';
    $item->quantity = 1;
    $item->unit_price = 150;

    $preference->items = array($item);
    $preference->save();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="https://sdk.mercadopago.com/js/v2"></script>
</head>
<body>

    <h3>Mercado Pago</h3>
    <div class="checkout-btn"></div>

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
            label: "Comprar", // Cambia el texto del botón de pago (opcional)
        },
    });
    </script>
    
</body>
</html>