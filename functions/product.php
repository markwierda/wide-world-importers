<?php

require_once './database/connection.php';

// Get homepage products
function getHomepageProducts() {
    $conn = connection();

    $result = $conn->query('SELECT StockItemID, StockItemName, RecommendedRetailPrice, MarketingComments, Photo FROM stockitems ORDER BY RAND() LIMIT 6;');
    $result = $result->fetch_all(MYSQLI_ASSOC);

    $conn->close();

    return $result;
}
