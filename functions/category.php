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

function getProductsByCategory($category) {
    if (empty($category))
        header('Location: index.php');

    $id = getCategoryIDByName($category);

    if (!$id)
        header('Location: index.php');

    $conn = connection();

    $stmt = $conn->prepare(
        'SELECT * FROM stockitems WHERE StockItemID IN(
                  SELECT StockItemID FROM stockitemstockgroups 
                  WHERE StockGroupID = ?);');
    $stmt->bind_param('i', $id);
    $stmt->execute();

    $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
    $conn->close();

    if (!$results) {
        $results['error'] = 'No products found for this category';
    }

    return $results;
}

function getCategoryIDByName($category) {
    $conn = connection();

    $stmt = $conn->prepare('SELECT StockGroupID FROM stockgroups WHERE StockGroupName = ?;');
    $stmt->bind_param('s', $category);
    $stmt->execute();

    $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    if (!$results)
        return false;

    return $results[0]['StockGroupID'];
}