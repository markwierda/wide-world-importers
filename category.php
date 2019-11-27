<?php

require_once './functions/product.php';
require_once './functions/category.php';
if (isset($_GET['amount']) && isset($_GET['page']))
    $products = getProductsByCategory($_GET['name'], $_GET['amount'], $_GET['page']);
elseif(isset($_GET['amount']) && !isset($_GET['page']))
    $products = getProductsByCategory($_GET['name'], $_GET['amount'], null);
elseif(isset($_GET['page']) && !isset($_GET['amount']))
    $products = getProductsByCategory($_GET['name'], null, $_GET['page']);
else
    $products = getProductsByCategory($_GET['name']);

$name = $_GET['name'];
$amount = 25; //default value
if (isset($_GET['amount']))
    $amount = intval($_GET['amount']);
$page = 1; //default value
if (isset($_GET['page']))
    $page = intval($_GET['page']);


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
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Amount
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a href="category.php?name=<?php echo $_GET['name'];?>&amount=25<?php echo (isset($_GET['page'])) ? "&page=".$_GET['page'] : '';?>" class="d-block">25</a>
                        <a href="category.php?name=<?php echo $_GET['name'];?>&amount=50<?php echo (isset($_GET['page'])) ? "&page=".$_GET['page'] : '';?>" class="d-block">50</a>
                        <a href="category.php?name=<?php echo $_GET['name'];?>&amount=100<?php echo (isset($_GET['page'])) ? "&page=".$_GET['page'] : '';?>" class="d-block">100</a>
                    </div>
                </div>
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
                                        <h5>&euro; <?php echo str_replace('.', ',', $product['RecommendedRetailPrice']); ?></h5>
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
                <div class="row">
                    <?php if ($page > 1): ?>
                        <div class="col-lg-6 col-sm-6 text-center">
                            <a href="<?="category.php?name={$name}&amount={$amount}&page=".($page-1)?>"><button type="button" class="btn btn-primary w-75 my-4 mb-3 p-3" id="productNav">Previous page</button></a>
                        </div>
                    <?php else:?>
                        <div class="col-lg-6 col-sm-6 text-center">
                            <a href=""><button type="button" class="btn btn-danger w-75 my-4 mb-3 p-3" id="productNav" onclick="alert('You are on the first page.')">Previous page</button></a>
                        </div>
                    <?php endif;?>


                    <?php if (getProductsByCategory_Count($_GET['name'])->fetch_assoc()['itemCount'] > $amount*$page): ?>
                        <div class="col-lg-6 col-sm-6 text-center">
                            <a href="<?="category.php?name={$name}&amount={$amount}&page=".($page+1)?>"><button type="button" class="btn btn-primary w-75 my-4 mb-4 p-3" id="productNav">Next page</button></a>
                        </div>
                    <?php else: ?>
                        <div class="col-lg-6 col-sm-6 text-center">
                            <a href=""><button type="button" class="btn btn-danger w-75 my-4 mb-4 p-3" id="productNav" onclick="alert('You are on the last page.')">Next page</button></a>
                        </div>
                    <?php endif;?>
                </div>
            </div>
            <!-- /.col-lg-9 -->

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->

<?php require_once './resources/layouts/footer.php'; ?>