<?php

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
