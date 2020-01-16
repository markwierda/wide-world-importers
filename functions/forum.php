<?php
require_once './database/connection.php';
require_once './functions/sessions.php';

// Messages database
function getDatabase() {
    $conn = connection();

    $result = $conn->query(
        'select f.id, f.user_id, f.foto, u.name, f.message from wwi_forum f join wwi_users u on f.user_id = u.id;');
    $result = $result->fetch_all(MYSQLI_ASSOC);

    $conn->close();

    return $result;

}

// Push image to database
function pushImage(){
    $conn = connection();

}

// Messages from database
function getMessages(){
    $conn = connection();
    $query = 'select f.id, f.user_id, f.foto, u.name, f.message from wwi_forum f join wwi_users u on f.user_id = u.id;';
    $result = $conn->query($query);
    // $result = $query->fetch_assoc();
    $conn->close();
    return $result;

}


