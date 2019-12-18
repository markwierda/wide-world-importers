<?php

require_once './vendor/autoload.php';
require_once 'order.php';

if (!isset($_SESSION['user_id']))
    header('Location: cart.php');

if (isset($_GET['order']))
    die(getOrderByID($_GET['order']));

function makePayment($cart) {
    try {
        $root = str_replace('functions', '', __DIR__);

        $settings = parse_ini_file($root . 'credentials.ini' , true);

        $endPrice = calculateEndPrice($cart);

        $endPrice['INCL'] = str_replace('.', '', $endPrice['INCL']);
        $endPrice['INCL'] = str_replace(',', '.', $endPrice['INCL']);

        $id = createOrder($_SESSION['user_id'], $cart);

        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey($settings['mollieApiKey']);

        $payment = $mollie->payments->create([
            'amount' => [
                'currency' => 'EUR',
                "value" => $endPrice['INCL']
            ],
            'description' => 'Payment for order: ' . $id,
            'redirectUrl' => 'https://' . $_SERVER['HTTP_HOST'] . '/checkout.php?order=' . $id,
            'webhookUrl' => 'https://' . $_SERVER['HTTP_HOST'] . '/webhook/mollie.php'
        ]);

        header('Location: ' . $payment->getCheckoutUrl(), true, 303);
    } catch (\Mollie\Api\Exceptions\ApiException $e) {
        echo "API call failed: " . htmlspecialchars($e->getMessage());
    }
}