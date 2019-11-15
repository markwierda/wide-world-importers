<?php

require_once './database/connection.php';

// Get categories
function getCategories() {
    $conn = connection();

    $result = $conn->query('SELECT StockGroupName FROM stockgroups ORDER BY StockGroupName;');
    $result = $result->fetch_all(MYSQLI_ASSOC);

    $conn->close();

    return $result;
}
