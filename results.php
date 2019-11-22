<?php
require_once './resources/layouts/header.php';
require_once './functions/redirect.php';
require_once './functions/search.php';

$searchquery = isset($_GET['s']) ? strval($_GET['s']) : '';
$page        = isset($_GET['p']) ? $_GET['p'] : '';
if ($searchquery === '' || $page === '') {
    //redirect naar homepage
    redirect("index.php", 303);
}

$results = search_products($searchquery, $page);
$itemCount = search_products_itemCount($searchquery)->fetch_assoc()['itemCount'];

if ($results === null || $itemCount === 0) {
    //Print error?
    redirect("index.php");
}

if (intval($page)*24-23 > $itemCount) {
    redirect("results.php?s={$searchquery}&p=1");
}
?>
<!-- Page Content -->
<div class="container">
    <?php require_once './resources/layouts/search.php';?>
    <h1>Showing items <?php if ($itemCount <= 24) {print("{$page} - {$itemCount}");} else {if ($page*24 < $itemCount) {print(intval($page)*24-23 . " - " . intval($page)*24);} else {print(intval($page)*24-23 . " - {$itemCount}");}}?> of <?=$itemCount?></h1>
    <div class="row">
        <?php while ($row = $results->fetch_assoc()): ?>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
                <div class="card-body">
                    <h4 class="card-title">
                        <a href="#"><?=$row['StockItemName'];?></a>
                    </h4>
                    <h5>&euro;<?=$row['RecommendedRetailPrice']?></h5>
                    <p class="card-text"><?=(!isset($row['MarketingComments']) || trim($row['MarketingComments'] === '')) ? "No description available for this product" : $row['MarketingComments'];?></p>
                </div>
                <div class="card-footer">
                    <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small> <!-- Rating -->
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

    <!-- /.row -->
</div>
<!-- /.container -->
<?php require_once './resources/layouts/footer.php'; ?>