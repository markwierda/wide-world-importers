<?php

header('Content-Type: application/json');

session_start();

require_once '../functions/cart.php';

if (!$_POST) {
    die('Access forbidden!');
}

if (array_key_exists($_POST['id'], $_SESSION['CART'])) {
    $currentQuantity = $_SESSION['CART'][$_POST['id']];
    $newQuantity = $_POST['quantity'];

    if ($currentQuantity !== $newQuantity) {
        $_SESSION['CART'][$_POST['id']] = $newQuantity;
    }
}

$cart = getCart();
$endPrice = calculateEndPrice($cart);

$product = [];
foreach ($cart as $item) {
    if ($item['StockItemID'] == $_POST['id'])
        $product = $item;
}



echo json_encode(['product' => $product, 'endPrice' => $endPrice]);
