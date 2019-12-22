<?php
require_once './database/connection.php';
function lowestPrice(){
    $conn = connection();
    $query = "SELECT * from stockitems ORDER BY RecommendedRetailPrice ASC;";
}

function highestPrice(){
    $conn = connection();
    $query = "SELECT * from stockitems ORDER BY RecommendedRetailPrice DESC;";
}

// USAGE getproducts('hallo', null, null, 'Black', 'high-low');
function getProducts($search, $size, $brand, $colour, $price) {
    $conn = connection();
    if ($search === null)
        return null;
    $search = "%{$search}%";
    $query = "SELECT * FROM stockitems WHERE (StockItemName LIKE ? OR MarketingComments LIKE ?) AND
stockitems.Size = IF((SELECT IFNULL(NULLIF(?, ''), '')) IS NOT NULL, ?,  stockitems.Size) AND
stockitems.Brand = IF((SELECT IFNULL(NULLIF(?, ''), '')) IS NOT NULL, ?,  stockitems.Brand) AND
stockitems.ColorID = IF((SELECT IFNULL(NULLIF((SELECT ColorID FROM colors WHERE ColorName = ?), ''), '')) IS NOT NULL, (SELECT ColorID FROM colors WHERE ColorName = ?),  stockitems.ColorID);";
    if (isset($price) && !empty($price)) {
        if ($price === 'high-low') {
            $query .= " ORDER BY stockitems.RecommendedRetailPrice DESC";
        } else if ($price === 'low-high') {
            $query .= " ORDER BY stockitems.RecommendedRetailPrice ASC";
        }
    }
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssssss',$search, $search, $size, $size, $brand, $brand, $colour, $colour);
    $stmt->execute();

    if ($stmt->errno > 0)
        return null;
    $result = $stmt->get_result();
    $conn->close();

    return $result;

}

function getColours() {
    $conn = connection();
    $query = "SELECT DISTINCT ColorName FROM colors JOIN stockitems ON stockitems.ColorID = colors.ColorID;";
    $result = $conn->query($query);

    if ($result->num_rows > 0)
        return $result;
    return null;
}

function getBrands() {
    $conn = connection();
    $query = "SELECT DISTINCT Brand FROM wideworldimporters.stockitems WHERE NOT Brand = \"\" ORDER BY Brand ASC;";
    $result = $conn->query($query);

    $conn->close();
    if ($result->num_rows > 0)
        return $result;
    return null;
}

function getSizes() {
    $conn = connection();
    $query = "SELECT DISTINCT Size FROM wideworldimporters.stockitems WHERE NOT Size = \"\";";
    $result = $conn->query($query);

    $conn->close();
    if ($result->num_rows > 0)
        return $result;
    return null;
}
