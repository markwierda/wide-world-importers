<?php

session_start();

require_once './database/connection.php';

function addToCart($product) {
    $product = intval($product);

    if (!isset($_SESSION['CART']))
        $_SESSION['CART'] = [];

    if (!isset($_SESSION['CART'][$product]))
        $_SESSION['CART'][$product] = 1;
    else
        $_SESSION['CART'][$product]++;

    $_SESSION['ALERT_SUCCESS'] = 'This product has been added to your shopping cart.';
    header('Location: product.php?id=' . $product);
}

function getCart() {
    if (!isset($_SESSION['CART']))
        return false;

    return $_SESSION['CART'];
}

function calculateEndPrice($productIDs) {
    if (!is_array($productIDs)) return null;

    $totaalBTW = 0;
    $totaalPrijs = 0;
    foreach ($productIDs as $productID) {
        $totaalBTW += calculateBTW($productID);
        $totaalPrijs += getRecommendedRetailPrice($productID);
    }
    $eindPrijs = $totaalPrijs + $totaalBTW;

    return ['BTW' => $totaalBTW, 'EXCL' => $totaalPrijs, 'INCL' => $eindPrijs];
}

function getRecommendedRetailPrice($productID) {
    try {
        $conn = connection();
        $stmt = $conn->prepare("SELECT RecommendedRetailPrice FROM stockitems WHERE StockItemID = ?;");
        $stmt->bind_param("i", $productID);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc()['RecommendedRetailPrice'];
        return $result;
    }catch (Exception $e) {
        return null;
    }
}

function calculateBTW($productID) {
    try {
        $conn = connection();
        $stmt = $conn->prepare("SELECT TaxRate, UnitPrice, RecommendedRetailPrice FROM stockitems WHERE StockItemID = ?;");
        $stmt->bind_param("i", $productID);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        $btwPercentage = doubleval($result['TaxRate']) / 100;
        //Er van uitgaan dat RecommendedRetailPrice excl BTW is
        $recommendedRetailPriceExcl = doubleval(['RecommendedRetailPrice']);

        //Er van uitgaan dat RecommendedRetailPrice Incl BTW is
        //$recommendedRetailPriceIncl = doubleval($result['RecommendedRetailPrice']);
        //$btw = $recommendedRetailPriceIncl - $recommendedRetailPriceIncl / ($btwPercentage+1);

        $btw = $recommendedRetailPriceExcl * $btwPercentage;
        return $btw;
    }
    catch (Exception $e) {
        return null;
    }
}

?>