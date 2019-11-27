<?php
$user_logged_in = False;

if(!isset($_SESSION)) {
    session_start();
}
else {
    if (isset($_SESSION['user_id'])) {
        $user_logged_in = True;
    }
}

function createSession($uid) {
    $_SESSION['user_id'] = $uid;
}

function destroySession() {
    session_unset('user_id');
    session_unset();
    session_destroy();
}

function validateSession() {
    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
        return true;
    }
    return false;
}
?>