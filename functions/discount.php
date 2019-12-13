<?php
require_once 'database/connection.php';

function getDiscount($productID) {
    $gdbp = getDiscountByProductID($productID);
    $gdbg = getDiscountByGroup($productID);

    $discount = null;

    //Checkt eerst of het product individueel een discount heeft anders pakt hij de eventuele discount op de groep
    if ($gdbg->num_rows > 0 || $gdbp->num_rows > 0) {
        $discount = ($gdbp->num_rows > 0) ? $gdbp : $gdbg;
    }

    $results = null;
    if (!is_null($discount)) {
        //var_dump($discount);
        $results = $discount->fetch_assoc();
        //$results['DiscountAmount'] = $discount->fetch_assoc()['DiscountAmount'];
        //$results['DiscountPercentage'] = $discount->fetch_assoc()['DiscountPercentage'];
    }
    return $results;
}

function getDiscountByGroup($id) {
    $conn = connection();
    $query = "SELECT * FROM specialdeals JOIN stockitemstockgroups ON specialdeals.StockGroupID = stockitemstockgroups.StockGroupID WHERE stockitemstockgroups.StockItemID = ? AND '2016-04-02' BETWEEN specialdeals.StartDate AND specialdeals.EndDate;";
    //$query = "SELECT * FROM specialdeals WHERE specialdeals.StockGroupID = ? AND '2016-04-02' BETWEEN specialdeals.StartDate AND specialdeals.EndDate;";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $results = $stmt->get_result();
    $stmt->close();
    $conn->close();


    if (!is_null($results))
        return $results;
    return null;
}

function getDiscountByProductID($id) {
    $conn = connection();
    $query = "SELECT * FROM specialdeals WHERE specialdeals.StockItemID = ? AND (SELECT curdate()) BETWEEN specialdeals.StartDate AND specialdeals.EndDate;";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $results = $stmt->get_result();
    $stmt->close();
    $conn->close();

    if (!is_null($results))
        return $results;
    return null;
}

?>
