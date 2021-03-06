<?php
require_once './functions/product.php';
require_once './functions/review.php';
require_once './functions/discount.php';

$products = getHomepageProducts();

?>
<?php require_once './resources/layouts/header.php'; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">
        <!-- /.col-lg-3 -->
        <div class="col-lg-3 my-4">
            <div class="list-group my-4">
                <?php foreach ($categories as $category): ?>
                    <a href="category.php?name=<?php echo $category['StockGroupName']; ?>" class="list-group-item"><?php echo $category['StockGroupName']; ?></a>
                <?php endforeach; ?>
            </div>
        </div>


        <div class="col-lg-9 my-4">

            <?php if(isset($_SESSION['ALERT_SUCCESS'])): ?>
            <div class="alert alert-success alert-dismissible my-4" role="alert">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $_SESSION['ALERT_SUCCESS']; ?>
            </div>
            <?php unset($_SESSION['ALERT_SUCCESS']); ?>
            <?php endif; ?>

            <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <img class="d-block img-fluid" src="https://placehold.it/1200x450" alt="First slide"  ">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block img-fluid" src="https://placehold.it/1200x450" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block img-fluid" src="https://placehold.it/1200x450" alt="Third slide">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

            <div class="row">

            <?php foreach ($products as $product): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <a href="#"><img class="card-img-top" src="https://placehold.it/700x400" alt=""></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="product.php?id=<?php echo $product['StockItemID']; ?>"><?php echo $product['StockItemName']; ?></a>
                            </h4>
                            <h5>
                                <?php
                                $discount = getDiscount($product['StockItemID']);
                                if (!is_null($discount['DiscountPercentage']) || !is_null($discount['DiscountAmount'])) {
                                    $price = $product['RecommendedRetailPrice'];
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
                                    print("&euro;" . number_format($product['RecommendedRetailPrice'], 2, ',', '.'));
                                }
                                ?>
                            </h5>
                            <p class="card-text"><?php echo $product['MarketingComments']; ?></p>
                        </div>
                        <div class="card-footer">
                            <span class="text-muted"><?php echo getAverageStars($product['StockItemID']); ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            </div>
            <!-- /.row -->

        </div>
        <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->

</div>
<!-- /.container -->

<?php require_once './resources/layouts/footer.php'; ?>