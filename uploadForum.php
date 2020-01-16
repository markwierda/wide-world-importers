<?php
require_once './database/connection.php';
require_once './functions/sessions.php';
require_once './functions/redirect.php';

if (isset($_POST['message'])) {
    //Path to save image
    // $saveImage = "resources/images/" . basename($_FILES['imageToUpload']['name']);

    $text = $_POST['message'];
    $saveImage = "resources/images/" . basename($_FILES['imageToUpload']['tmp_name']);


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
        }
        else {
            print 'There went something wrong please try again';
        }
}
else{
    redirect('forum.php');
}
?>