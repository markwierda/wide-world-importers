<?php

require_once './database/connection.php';
require_once './functions/recaptcha.php';
require_once './functions/sessions.php';

function validateContact($form) {
    $errors = [];

    if (isValidRecaptchaResponse($form['g-recaptcha-response'])) {
        if (!isset($_POST['supplier'])) {
            $errors['supplier'] = 'The <b>supplier</b> field cannot be empty, please try again.';
        }

        foreach ($form as $key => $value) {
            // Check empty values
            if (empty($value)) {
                $key = ucwords(str_replace('_', ' ', $key));
                $errors[$key] = 'The <b>' . $key . '</b> field cannot be empty, please try again.';
            }

            // Check if values not longer than 45 characters
            if (strlen($value) > 400 && $key !== 'g-recaptcha-response') {
                $errors[$key] = 'The <b>' . $key . '</b> field cannot be longer than 400 characters, please try again.';
            }
        }

        // Return all errors
        if (!empty($errors))
            return $errors;

        return true;
    }

    $errors['recaptcha'] = '<b>ReCAPTCHA</b> verification failed, please try again.';

    return $errors;
}

// supplier database
function getSuppliers() {
    $conn = connection();

    $result = $conn->query('SELECT SupplierID, SupplierName from suppliers;');
    $result = $result->fetch_all(MYSQLI_ASSOC);

    $conn->close();

    return $result;
}

function pushDatabase($form){
    if (!validateSession())
        return null;
    $conn = connection();
    $stmt = $conn->prepare("INSERT INTO wwi_contact(uid, supplier_id, message) VALUES(? ,? ,?)");
    $stmt->bind_param('iis', $_SESSION['user_id'], intval($form['supplier']), $form['message']);
    $stmt->execute();

    $conn->close();
    if ($stmt->errno > 0) {
        return null;
    }
    return true;
}





?>