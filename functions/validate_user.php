<?php
require_once './database/connection.php';

$db_table = "wwi_users"; #user tabel

function check_User_Combination($email, $password) {
    global $db_table;

    try {
        $conn = connection();
        $query = "SELECT password FROM $db_table WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc()['password'];

        if ($stmt->errno > 0) {
            return false;
        }
        else {
            try {
                if (password_verify($password, $result)) {
                    return true;
                }
            }
            catch (Exception $e) {
                return false;
            }
        }
    }
    catch (Exception $e){
        return false;
    }
}

function get_uid($email) {
    global $db_table;
    $conn = connection();
    $query = "SELECT id FROM $db_table WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result()->fetch_assoc()['id'];

    if ($stmt->errno > 0) {
        return false;
    } else {
        return $result;
    }
}

function create_User($user) {
    global $db_table;

    $password = password_hash($user['password'], PASSWORD_DEFAULT);

    try {
        $conn = connection();
        $query = "INSERT INTO $db_table (name, address, city, postal, email, password) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssss", $user['name'], $user['address'], $user['city'], $user['postal'], $user['email'], $password);
        $stmt->execute();

        if ($stmt->errno > 0) {
            return false;
        } else {
            return true;
        }
    }
    catch (Exception $e) {
        return false;
    }
}
