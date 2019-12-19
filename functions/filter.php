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
