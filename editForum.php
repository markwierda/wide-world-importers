<?php
require_once './database/connection.php';
require_once './functions/sessions.php';
require_once './functions/redirect.php';

if (isset($_POST['message'])) {
    $conn = connection();

    $sql = $conn->prepare("UPDATE wwi_forum 
                                  SET message = ?
                                  WHERE id = ?");
    $sql->bind_param('si', $_POST['message'], $_GET["edit"]);
    $sql->execute();

    $conn->close();
    $message = 'Message uploaded successfully';
    redirect('forum.php');
}
else{
    redirect('forum.php');
}
