<?php

$root = str_replace('functions', '', __DIR__);

require_once $root . './database/connection.php';

// Get homepage products
function getHomepageProducts() {
    $conn = connection();

    $query = "SELECT IF(EXISTS(SELECT * FROM stockitems JOIN stockitemstockgroups ON stockitems.StockItemID = stockitemstockgroups.StockItemID JOIN specialdeals ON stockitemstockgroups.StockGroupID = specialdeals.StockGroupID WHERE '2016-04-02' BETWEEN specialdeals.StartDate AND specialdeals.EndDate), 'YES', 'NO') AS doesExist";
    $result = $conn->query($query);
    if ($result->fetch_assoc()['doesExist'] === 'YES') {
        $result = $conn->query("SELECT stockitems.StockItemID, stockitems.StockItemName, stockitems.RecommendedRetailPrice, stockitems.MarketingComments, stockitems.Photo FROM stockitems JOIN stockitemstockgroups ON stockitems.StockItemID = stockitemstockgroups.StockItemID JOIN specialdeals ON stockitemstockgroups.StockGroupID = specialdeals.StockGroupID WHERE '2016-04-02' BETWEEN specialdeals.StartDate AND specialdeals.EndDate ORDER BY RAND() LIMIT 6;");
        $result = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $result = $conn->query('SELECT StockItemID, StockItemName, RecommendedRetailPrice, MarketingComments, Photo FROM stockitems ORDER BY RAND() LIMIT 6;');
        $result = $result->fetch_all(MYSQLI_ASSOC);
    }

    $conn->close();
    return $result;
}

// Get product by id
function getProductByID($id) {
    if (!$id)
        die('Product not found');

    $conn = connection();

    $stmt = $conn->prepare(
        'SELECT I.StockItemID, I.StockItemName, I.RecommendedRetailPrice, I.MarketingComments, H.QuantityOnHand FROM stockitems I
                JOIN stockitemholdings H ON H.StockItemID = I.StockItemID
                WHERE I.StockItemID = ?;');
    $stmt->bind_param('s', $id);
    $stmt->execute();

    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
    $conn->close();

    if (!$result)
        die('Product not found');

    return $result[0];
}
