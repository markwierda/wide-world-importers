<?php
session_start();

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