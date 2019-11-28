<?php
require_once './database/connection.php';

function berekenBTW($productID) {
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