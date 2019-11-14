<?php

function connection() {
    // Get database credentials
    $settings = parse_ini_file('credentials.ini' , true);

    // Create connection
    $connection = mysqli_connect($settings['db_host'], $settings['db_user'], $settings['db_pass'], $settings['db_name']);

    // Check connection
    if (!$connection) {
        die('Database connection failed');
    }

    // Return connection
    return $connection;
}
