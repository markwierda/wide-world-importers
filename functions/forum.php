<?php
require_once './database/connection.php';
require_once './functions/sessions.php';
require_once './functions/redirect.php';


// Push image to database
/* if (isset($_POST['upload'])) {
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

<<<<<<< HEAD
// Edit posts
function updateForum($foto,$post, $fid, $uid) {
    // Convert HTML characters to text
    foreach ($fid as $key => $value) {
        $fid[$key] = htmlentities($value);
    }

    $conn = connection();

    $stmt = $conn->prepare('UPDATE wwi_forum SET foto = ?, message = ? WHERE id = ? AND user_id = ?;');
    $stmt->bind_param('ssii', $foto, $post, $fid, $uid);
    $stmt->execute();

    if ($stmt->affected_rows < 1)
        return false;

    return true;


}
// get message
function getforumByID($id) {
    if (!$id)
        die('Message not found');

    $conn = connection();

    $stmt = $conn->prepare(
        'SELECT *
                FROM wwi_forum
                WhERE id = ?;');
    $stmt->bind_param('i', $id);
    $stmt->execute();

    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
    $conn->close();

    if (!$result)
        die('Message not found');

    return $result[0];
}
=======
*/
>>>>>>> f274b612c2ee3f22a42d2a2c300852dbaabf181e

// Messages from database
function getMessages(){
    $conn = connection();
    $query = 'select f.id, f.user_id, f.foto, u.name, f.message from wwi_forum f join wwi_users u on f.user_id = u.id;';
    $result = $conn->query($query);
    // $result = $query->fetch_assoc();
    $conn->close();
    return $result;

}
// 1 Message
function getMessage($id){
    $conn = connection();
    $query = 'select f.id, f.user_id, f.foto, u.name, f.message from wwi_forum f join wwi_users u on f.user_id = u.id where f.id = $id;';
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