<?php
require_once './database/connection.php';
require_once './functions/sessions.php';
require_once './functions/redirect.php';


// Push image to database
if (isset($_POST['upload'])) {
    //Path to save image
    $saveImage = "resources/images/" . basename($_FILES['imageToUpload']['name']);
    $text = $_POST['message'];

    if (move_uploaded_file($_FILES['imageToUpload']['tmp_name'], $saveImage)) {
        $conn = connection();

        $sql = $conn->prepare("INSERT INTO wwi_forum (user_id, foto, message) values (?,?,?)");
        $sql->bind_param('iss', $_SESSION['user_id'], $saveImage, $text);
        $sql->execute();
        // $sql = "INSERT INTO wwi_forum (user_id, foto, message) values ($_SESSION['user_id'], '$saveImage', '$text')";
        // mysqli_query($conn, $sql);

        $conn->close();
        $message = 'Message uploaded successfully';
        redirect('forum.php');
    } else {
           $message = 'There went something wrong please try again';
           print $message;
     }
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

function getUsername(){
    $conn = connection();
    $query = 'select u.name, u.id from wwi_users u;';
    $result = $conn->query($query);
    $conn->close();
    return $result;

}