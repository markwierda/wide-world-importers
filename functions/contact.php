<?php

$root = str_replace('functions', '', __DIR__);

require_once $root . './database/connection.php';

function validateContact($form)
{
    if (!filter_var($form['email'], FILTER_VALIDATE_EMAIL))
        $errors['email'] = 'The specified <b>e-mail address</b> is not a valid e-mail address, please try again.';
}

// supplier database
function getSuppliers() {
    $conn = connection();

    $result = $conn->query('SELECT SupplierID, SupplierName from suppliers;');
    $result = $result->fetch_all(MYSQLI_ASSOC);

    $conn->close();

    return $result;
}






?>