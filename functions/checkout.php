<?php

require_once './vendor/autoload.php';

function makePayment($cart) {
    $root = str_replace('functions', '', __DIR__);

    $settings = parse_ini_file($root . 'credentials.ini' , true);

    $mollie = new \Mollie\Api\MollieApiClient();
    $mollie->setApiKey($settings['mollieApiKey']);

    $payment = $mollie->payments->create([
        "amount" => [
            "currency" => "EUR",
            "value" => "10.00"
        ],
        "description" => "My first API payment",
        "redirectUrl" => "http://localhost/checkout?id=1"
    ]);

    var_dump($payment);
}