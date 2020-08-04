<?php


// SDK de Mercado Pago
require __DIR__ .  '/vendor/autoload.php';


MercadoPago\SDK::setClientId("1269378942734787");
MercadoPago\SDK::setClientSecret("NoUARt3j1IBRBkpeuhtkrwBHDfksCQ97");

// Agrega credenciales
MercadoPago\SDK::setAccessToken('TEST-1269378942734787-073104-e72dd62c2630fe17740e58b291a3194a-456580315');

// Crea un objeto de preferencia
$preference = new MercadoPago\Preference();

// Crea un ítem en la preferencia
$item = new MercadoPago\Item();
$item->title = 'Mi producto';
$item->quantity = 1;
$item->unit_price = 75.56;
$preference->items = array($item);
$preference->back_urls = array(
    "success" => "http://localhost/saurabh/mercadopago/success.php",
    "failure" => "http://localhost/saurabh/mercadopago/failure.php",
    "pending" => "http://localhost/saurabh/mercadopago/pending.php"
);
$preference->auto_return = "approved";
$data = $preference->save();







echo $preference->init_point; die;
echo '<pre>';
print_r($data);



?>