<?php

require_once '../vendor/autoload.php';
require_once '../functions/order.php';

try {
    $root = str_replace('webhook', '', __DIR__);
    $settings = parse_ini_file($root . 'credentials.ini' , true);
    $mollie = new \Mollie\Api\MollieApiClient();
    $mollie->setApiKey($settings['mollieApiKey']);

    $payment = $mollie->payments->get($_POST["id"]);
    $orderId = $payment->metadata->order_id;

    updateOrder($payment->id, $payment->status);
} catch (\Mollie\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . htmlspecialchars($e->getMessage());
}
