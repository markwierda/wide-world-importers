<?php

header('Content-Type: application/json');

require_once '../functions/review.php';

if (!$_POST) {
    die('Access forbidden!');
}

if ($_POST['user_id'] == $_SESSION['user_id']) {
    if (!empty($_POST['description'] && strlen($_POST['description']) <= 200)) {
        updateReview($_POST['product_id'], $_SESSION['user_id'], $_POST);
        echo json_encode(['success' => true]);
        exit;
    }
}

echo json_encode(['success' => false]);
