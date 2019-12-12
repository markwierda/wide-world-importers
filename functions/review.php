<?php

session_start();

require_once './database/connection.php';
require_once 'recaptcha.php';
require_once 'redirect.php';

function validateReview($form) {
    if (isset($_SESSION['user_id'])) {
        $errors = [];

        if (userAlreadyHasReview($_GET['id'], $_SESSION['user_id'])) {
            $errors['review'] = 'You\'ve already posted a review form this product.';
            return $errors;
        }

        if (isValidRecaptchaResponse($form['g-recaptcha-response'])) {

            // Check if stars are not empty
            if (empty($form['stars']))
                $errors['stars'] = 'You cannot leave a review without selecting <b>stars</b>, please try again.';

            // Check if stars are between 1 and 5
            if ($form['stars'] < 1 || $form['stars'] > 5)
                return false;

            if (empty($form['stars']))
                $errors['stars'] = 'You cannot leave a review without selecting <b>stars</b>, please try again.';

            // Check if description is not empty
            if (empty($form['description']))
                $errors['description'] = 'The <b>description</b> field cannot be empty, please try again.';

            // Check if description is not longer than 200 characters
            if (strlen($form['description']) > 200) {
                $errors['description'] = 'The <b>description</b> field cannot be longer than 200 characters, please try again.';
            }

            // Return all errors
            if (!empty($errors))
                return $errors;

            saveReview($_GET['id'], $_SESSION['user_id'], $form);
            $_SESSION['ALERT_SUCCESS'] = 'Your review has been posted.';
            redirect('product.php?id=' . $_GET['id']);
        }

        $errors['recaptcha'] = '<b>ReCAPTCHA</b> verification failed, please try again.';

        return $errors;
    }

    return false;
}

// Check if user already has a review on the given product
function userAlreadyHasReview($pid, $uid) {
    $conn = connection();

    $stmt = $conn->prepare('SELECT * FROM wwi_reviews WHERE product_id = ? AND user_id = ?;');
    $stmt->bind_param('ii', $pid, $uid);
    $stmt->execute();

    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    if (empty($result))
        return false;

    return true;
}

// Insert review in database
function saveReview($pid, $uid, $review) {
    // XSS prevention
    foreach ($review as $key => $value) {
        $review[$key] = htmlentities($value);
    }

    $conn = connection();

    $stmt = $conn->prepare('INSERT INTO wwi_reviews(product_id, user_id, stars, description, created_at) VALUES (?, ?, ?, ?, now());');
    $stmt->bind_param('iiis', $pid, $uid, $review['stars'], $review['description']);
    $stmt->execute();

    if ($stmt->affected_rows < 1)
        return false;

    return true;
}

// Get reviews by product
function getReviewByProductID($pid) {
    $conn = connection();

    $stmt = $conn->prepare(
    'SELECT R.product_id, R.user_id, R.stars, R.description, R.created_at, U.name FROM wwi_reviews R
            JOIN wwi_users U ON U.id = R.user_id
            WHERE R.product_id = ?;');
    $stmt->bind_param('i', $pid);
    $stmt->execute();

    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    if (empty($result))
        return false;

    return $result;
}