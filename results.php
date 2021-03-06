<?php

require_once './functions/search.php';
require_once './functions/redirect.php';
require_once './functions/review.php';

try {
    $searchquery = isset($_GET['s']) ? strval($_GET['s']) : '';
    $page = isset($_GET['p']) ? intval($_GET['p']) : '';
    $amount = isset($_GET['a']) ? intval($_GET['a']) : 24;
} catch (Exception $e) {redirect("index.php");}

if ($searchquery === '' || $page === '') {
    //redirect naar homepage
    redirect("index.php", 303);
}

$results = search_products($searchquery, $page, $amount);

$itemCount = search_products_itemCount($searchquery);
if ($itemCount === null) {
    redirect("index.php");
}

$itemCount = $itemCount->fetch_assoc()['itemCount'];

if ($results === null || $itemCount === 0) {
    //Print error?
    redirect("index.php");
}

if (intval($page)*$amount-($amount-1) > $itemCount) {
    redirect("results.php?s={$searchquery}&p=1");
}
?>
<?php require_once './resources/layouts/header.php'; ?>
<main>
    <!-- Page Content -->
    <div class="container my-5">
        <?php require_once './resources/layouts/search.php';?>
        <h1>Showing items <?php if ($itemCount <= $amount) {print("{$page} - {$itemCount}");} else {if ($page*$amount < $itemCount) {print(intval($page)*$amount-($amount-1) . " - " . intval($page)*$amount);} else {print(intval($page)*$amount-($amount-1) . " - {$itemCount}");}}?> of <?=$itemCount?></h1>
        <div class="row">
            <?php ?>
            <?php while ($row = $results->fetch_assoc()): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <a href="#"><img class="card-img-top" src="https://placehold.it/700x400" alt=""></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="product.php?id=<?=$row['StockItemID']?>"><?=$row['StockItemName'];?></a>
                            </h4>
                            <h5><?php
                                $discount = getDiscount($row['StockItemID']);
                                if (!is_null($discount['DiscountPercentage']) || !is_null($discount['DiscountAmount'])) {
                                    $price = $row['RecommendedRetailPrice'];
                                    print("FROM <s class='text-danger'>&euro;" . number_format($price , 2, ',', '.') . "</s> FOR ");

                                    if (!is_null($discount['DiscountPercentage'])) {
                                        $price = ($price * ((100 - $discount['DiscountPercentage']) / 100));
                                    }
                                    if (!is_null($discount['DiscountAmount'])) {
                                        $price = $price - $discount['DiscountAmount'];
                                    }
                                    $price = number_format($price, 2, ',', '.');
                                    print("&euro;" . $price);

                                } else {
                                    print("&euro;" . number_format($row['RecommendedRetailPrice'], 2, ',', '.'));
                                }
                                ?></h5>
                            <p class="card-text"><?=(!isset($row['MarketingComments']) || trim($row['MarketingComments'] === '')) ? "No description available for this product" : $row['MarketingComments'];?></p>
                        </div>
                        <div class="card-footer">
                            <span class="text-muted"><?php echo getAverageStars($row['StockItemID']); ?></span>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="row">
            <?php if ($page > 1): ?>
                <div class="col-lg-6 col-sm-6 text-center">
                    <a href="<?="results.php?s={$searchquery}&a={$amount}&p=".($page-1)?>"><button type="button" class="btn btn-primary w-75 my-4 mb-3 p-3" id="productNav">Previous page</button></a>
                </div>
            <?php else:?>
                <div class="col-lg-6 col-sm-6 text-center">
                    <a href=""><button type="button" class="btn btn-danger w-75 my-4 mb-3 p-3" id="productNav" onclick="alert('You are on the first page.')">Previous page</button></a>
                </div>
            <?php endif;?>


            <?php if ($itemCount > $amount*$page): ?>
                <div class="col-lg-6 col-sm-6 text-center">
                    <a href="<?="results.php?s={$searchquery}&a={$amount}&p=".($page+1)?>"><button type="button" class="btn btn-primary w-75 my-4 mb-4 p-3" id="productNav">Next page</button></a>
                </div>
            <?php else: ?>
                <div class="col-lg-6 col-sm-6 text-center">
                    <a href=""><button type="button" class="btn btn-danger w-75 my-4 mb-4 p-3" id="productNav" onclick="alert('You are on the last page.')">Next page</button></a>
                </div>
            <?php endif;?>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</main>
<?php require_once './resources/layouts/footer.php'; ?>

