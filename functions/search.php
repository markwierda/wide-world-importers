<?php
require_once 'database/connection.php';
require_once 'discount.php';

function search_products_itemCount($search) {
    if (!empty($search)) {
        $conn = connection();
        if (is_numeric($search)) {
            //suppose its a product ID
            //Prepare query
            $query = "SELECT COUNT(*) as itemCount FROM stockitems WHERE StockItemID = ?;";

            //Bind parameters to query
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $search);

            //execute statement
            $stmt->execute();

            //Get query results
            $results = $stmt->get_result();

            //Close connections
            $stmt->close();
            $conn->close();

            //Return results
            return $results;
        }
        else {
            $query = "SELECT COUNT(*) as itemCount FROM stockitems WHERE StockItemName LIKE ? OR MarketingComments LIKE ?;";
            $search = "%{$search}%";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $search, $search);
            $stmt->execute();

            $results = $stmt->get_result();
            $stmt->close();
            $conn->close();

            return $results;
        }
    }
    return null;
}

function search_products($search, $page, $amount=24, $filter_array = null) {
    if (!empty($search) && isset($page)) {
        if ($filter_array !== null) {
            $size = $filter_array['size'];
            $brand = $filter_array['brand'];
            $colour = $filter_array['colour'];
            $price = $filter_array['price'];
            
        }

        if(!is_numeric($amount)) {
            return null;
        }

        $conn = connection();
        $page = (intval($page)-1) * $amount;

        if (is_numeric($search)) {
            //suppose its a product ID
            //Prepare query

            $query = "SELECT * FROM stockitems WHERE StockItemID = ? LIMIT ? OFFSET ?;";

            //Bind parameters to query
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iii", $search,$amount, $page);

            //execute statement
            $stmt->execute();

            //Get query results
            $results = $stmt->get_result();

            //Close connections
            $stmt->close();
            $conn->close();

            //Return results
            return $results;
        }
        else {
            $query = "SELECT * FROM stockitems WHERE StockItemName LIKE ? OR MarketingComments LIKE ? LIMIT ? OFFSET ?;";
            //$query = "SELECT * FROM stockitems LEFT JOIN specialdeals ON specialdeals.StockItemID = stockitems.StockItemID WHERE StockItemName LIKE ? OR MarketingComments LIKE ? LIMIT ? OFFSET ?;";
            $search = "%{$search}%";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssii", $search, $search, $amount, $page);
            $stmt->execute();

            $results = $stmt->get_result();
            $stmt->close();
            $conn->close();

            return $results;
        }
    }
    return null;
}
?>