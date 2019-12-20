<?php

$root = str_replace('functions', '', __DIR__);

require_once $root . 'database/connection.php';
require_once $root . 'functions/product.php';

function getOrderByID($id) {
    $conn = connection();

    $stmt = $conn->prepare(
        'SELECT O.id, O.user_id, O.payment_id, O.status, L.StockItemID, I.StockItemName, L.price, L.quantity FROM wwi_orders O
                JOIN wwi_orderlines L ON L.pid = O.id
                JOIN stockitems I ON I.StockItemID = L.StockItemID
                WHERE O.id = ?;');
    $stmt->bind_param('i', $id);
    $stmt->execute();

    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    if (empty($result))
        return false;

    foreach ($result as $key => $item) {
        $result[$key]['total'] = $item['price'] * $item['quantity'];
    }

    $stmt->close();
    $conn->close();

    return $result;
}

function createOrder($uid, $cart) {
    $conn = connection();

    $stmt = $conn->prepare('INSERT INTO wwi_orders(user_id, status, ordered_at) VALUES(?, \'open\', now());');
    $stmt->bind_param('i', $uid);
    $stmt->execute();

    if ($stmt->affected_rows < 1)
        return false;

    $stmt->close();

    $stmt = $conn->query('SELECT LAST_INSERT_ID()');
    $result = $stmt->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
    $conn->close();

    $id = $result[0]['LAST_INSERT_ID()'];

    createOrderlines($id, $cart);

    unset($_SESSION['CART']);

    return $id;
}

function createOrderlines($id, $cart) {
    $conn = connection();

    $stmt = $conn->prepare('INSERT INTO wwi_orderlines(pid, StockItemID, price, quantity) VALUES (?, ?, ?, ?);');

    foreach ($cart as $item) {
        $item['RecommendedRetailPrice'] = str_replace(',', '.', $item['RecommendedRetailPrice']);

        $stmt->bind_param('iiss', $id, $item['StockItemID'], $item['RecommendedRetailPrice'], $item['quantity']);
        $stmt->execute();
    }

    if ($stmt->affected_rows < 1)
        return false;

    $stmt->close();
    $conn->close();

    return true;
}

function setOrderPaymentID($payment_id, $id) {
    $conn = connection();

    $stmt = $conn->prepare('UPDATE wwi_orders SET payment_id = ? WHERE id = ?;');
    $stmt->bind_param('si', $payment_id, $id);
    $stmt->execute();

    if ($stmt->affected_rows < 1)
        return false;

    $stmt->close();
    $conn->close();

    return true;
}

function updateOrder($id, $status) {
    $conn = connection();

    $stmt = $conn->prepare('UPDATE wwi_orders SET status = ? WHERE payment_id = ?;');
    $stmt->bind_param('ss', $status, $id);
    $stmt->execute();

    if ($stmt->affected_rows < 1)
        return false;

    $stmt->close();
    $conn->close();

    return true;
}
