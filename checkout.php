<?php

require_once './functions/sessions.php';
require_once './functions/cart.php';
require_once './functions/checkout.php';
require_once './functions/redirect.php';

$cart = getCart();
$endPrice = calculateEndPrice($cart);

if (empty($cart))
    redirect('cart.php');

if (isset($_GET['order']))
    header('Location: order.php?id=' . $_GET['order']);

makePayment($cart);
