<?php

require_once './functions/product.php';
require_once './functions/category.php';

$products = getProductsByCategory($_GET['name']);
$categories = getCategories();

?>
<?php require_once './resources/layouts/header.php'; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-lg-12 text-center">
                <h1 class="my-4"><?php echo $_GET['name']; ?></h1>
            </div>

            <div class="col-lg-12">

                <div class="row">

                    <?php if (!empty($products['error'])): ?>
                    <div class="alert alert-danger" role="alert"><?php echo $products['error']; ?></div>
                    <?php else: ?>
                        <?php foreach ($products as $product): ?>
                            <div class="col-lg-3 col-md-4 mb-3 my-4">
                                <div class="card h-100">
                                    <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            <a href="product.php?id=<?php echo $product['StockItemID']; ?>"><?php echo $product['StockItemName']; ?></a>
                                        </h4>
                                        <h5>&euro; <?php echo $product['RecommendedRetailPrice']; ?></h5>
                                        <p class="card-text"><?php echo $product['MarketingComments']; ?></p>
                                    </div>
                                    <div class="card-footer">
                                        <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>
                <!-- /.row -->

            </div>
            <!-- /.col-lg-9 -->

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->

<?php require_once './resources/layouts/footer.php'; ?>