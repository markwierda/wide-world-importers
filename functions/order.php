<?php

$root = str_replace('functions', '', __DIR__);

require_once $root . 'database/connection.php';

function getOrderByID($id) {
    return $id;
}

function createOrder($uid, $cart) {
    $uid = htmlentities($uid);

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

    var_dump($stmt);
    exit;

    $stmt->close();
    $conn->close();

    return true;
}
