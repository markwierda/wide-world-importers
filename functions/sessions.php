<?php
if(!isset($_SESSION)) {
    session_start();
}

function createSession($uid) {
    $_SESSION['user_id'] = $uid;
}

function logout() {
    unset($_SESSION['user_id']);
}

function validateSession() {
    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
        return true;
    }
    return false;
}
?>