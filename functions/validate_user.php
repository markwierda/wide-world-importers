<?php
require_once './database/connection.php';
$db_table = "users";

function check_User_Combination($email, $password) {
    global $db_table;

    //hash password
    $password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $conn = connection();
        $query = "SELECT COUNT(*) as user_found FROM $db_table WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->fetch_assoc()['user_found'] == 1) {
            return true;
        } else {
            return false;
        }
    }
    catch (Exception $e){
        return false;
    }
}

function create_User($email, $password) {
    global $db_table;

    $password = password_hash($password, PASSWORD_DEFAULT);
    try {
        $conn = connection();
        $query = "INSERT INTO $db_table (email, password) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $email, $password);
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
    //$result = $stmt->get_result()->fetch_assoc();
    //$result = $stmt->get_result
}
?>