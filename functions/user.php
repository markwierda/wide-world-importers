<?php

require_once './database/connection.php';

function getUserByID($id) {
    $conn = connection();

    $stmt = $conn->prepare('SELECT name, address, city, postal FROM wwi_users WHERE id = ?;');
    $stmt->bind_param('i', $id);
    $stmt->execute();

    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    if (!$result)
        return false;

    return $result[0];
}
