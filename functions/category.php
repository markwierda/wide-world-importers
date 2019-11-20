<?php

require_once './database/connection.php';
require_once './functions/redirect.php';
// Get categories
function getCategories() {
    $conn = connection();

    $result = $conn->query('SELECT StockGroupName FROM stockgroups ORDER BY StockGroupName;');
    $result = $result->fetch_all(MYSQLI_ASSOC);

    $conn->close();

    return $result;
}

function getProductsByCategory($category, $amount = 25, $page = 1) {
    if (empty($category))
        redirect('index.php');

    $itemCount = intval(getProductsByCategory_Count($category)->fetch_assoc()['itemCount']);
    $amount = (intval($amount) < 1) ? 25 : intval($amount);
    $amount = (intval($amount) > $itemCount) ? $itemCount : $amount;
    $page = (intval($page) < 1) ? 1 : intval($page);
    $offset = intval($page*$amount)-$amount;

    $id = getCategoryIDByName($category);
    if (!$id)
        redirect('index.php');

    if ($amount > $itemCount) {
        redirect("category.php?name={$category}&amount={$itemCount}&page={$page}");
        //return getProductsByCategory($category, 25, $page);
    }
    if (intval($page)*$amount-($amount-1) > $itemCount && $amount > 0) {
        redirect("category.php?name={$category}&amount={$amount}&page=1");
        //return getProductsByCategory($category, $amount);
    }


    $conn = connection();

    $stmt = $conn->prepare(
        'SELECT * FROM stockitems WHERE StockItemID IN(
                  SELECT StockItemID FROM stockitemstockgroups 
                  WHERE StockGroupID = ?) LIMIT ? OFFSET ?;');
    $stmt->bind_param('iii', $id, $amount, $offset);
    $stmt->execute();

    $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
    $conn->close();

    if (!$results) {
        $results['error'] = 'No products found for this category';
    }

    return $results;
}

function getProductsByCategory_Count($category) {
    if (empty($category))
        redirect('index.php');

    $id = getCategoryIDByName($category);

    if (!$id)
        redirect('index.php');
    $conn = connection();

    $stmt = $conn->prepare(
        'SELECT COUNT(*) as itemCount FROM stockitems WHERE StockItemID IN(
                  SELECT StockItemID FROM stockitemstockgroups 
                  WHERE StockGroupID = ?);');
    $stmt->bind_param('i', $id);
    $stmt->execute();

    $results = $stmt->get_result();//->fetch_all(MYSQLI_ASSOC);

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