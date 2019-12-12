<?php

session_start();

require_once './functions/product.php';

if ($_POST) {
    require_once './functions/cart.php';

    addToCart($_POST['productID']);
}

$product = getProductByID($_GET['id']);

?>
<?php require_once './resources/layouts/header.php'; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <div class="col-lg-3 my-4">
            <div class="list-group my-4">
                <?php foreach ($categories as $category): ?>
                    <a href="category.php?name=<?php echo $category['StockGroupName']; ?>" class="list-group-item"><?php echo $category['StockGroupName']; ?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- /.col-lg-3 -->

        <div class="col-lg-9 my-4">

            <?php if(isset($_SESSION['ALERT_SUCCESS'])): ?>
                <div class="alert alert-success alert-dismissible my-4" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?php echo $_SESSION['ALERT_SUCCESS']; ?>
                </div>
                <?php unset($_SESSION['ALERT_SUCCESS']); ?>
            <?php endif; ?>

            <div class="card mt-4">
                <img class="card-img-top img-fluid" src="http://placehold.it/900x400" alt="<?php echo $product['StockItemName']; ?>">
                <div class="card-body row">
                    <div class="col-lg-9 col-md">
                        <h3 class="card-title"><?php echo $product['StockItemName']; ?></h3>
                        <h4>&euro;<?php echo str_replace('.', ',', $product['RecommendedRetailPrice']); ?></h4>
                        <p class="card-text"><?php echo !empty($product['MarketingComments']) ? $product['MarketingComments'] : '<i>This product has no description</i>'; ?></p>
                        <p class="card-text"><?php echo ($product['QuantityOnHand'] > 25) ? "<a class='text-success'>In stock</a>" : "<a class='text-danger'>{$product['QuantityOnHand']} Left</a>"?></p>
                        <span class="text-warning">&#9733; &#9733; &#9733; &#9733; &#9734;</span>
                        4.0 stars
                    </div>
                    <div class="col-lg-3 col-md">
                        <form action="product.php" method="POST">
                            <input type="hidden" name="productID" value="<?php echo $product['StockItemID']; ?>">
                            <button id="addToCart" type="submit" class="btn btn-success float-md-right">Add to cart</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.card -->

            <div class="card card-outline-secondary my-4">
                <div class="card-header">
                    Product Reviews
                </div>
                <div class="card-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore, similique necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat laborum. Sequi mollitia, necessitatibus quae sint natus.</p>
                    <small class="text-muted">Posted by Anonymous on 3/1/17</small>
                    <hr>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore, similique necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat laborum. Sequi mollitia, necessitatibus quae sint natus.</p>
                    <small class="text-muted">Posted by Anonymous on 3/1/17</small>
                    <hr>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore, similique necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat laborum. Sequi mollitia, necessitatibus quae sint natus.</p>
                    <small class="text-muted">Posted by Anonymous on 3/1/17</small>
                    <hr>

                    <form action="thispage.php" method="post" accept-charset="utf-8">
                        <fieldset><legend>Review This Product</legend>
                            <p><label for="rating">Rating</label>
                                <input type="radio" name="rating" value="1" /> 1
                                <input type="radio" name="rating" value="2" /> 2
                                <input type="radio" name="rating" value="3" /> 3
                                <input type="radio" name="rating" value="4" /> 4
                                <input type="radio" name="rating" value="5" /> 5</p>
                            <p><label for="review">Review</label><textarea name="review" rows="8" cols="40">
                                </textarea></p>
                            <p><input type="submit" value="Submit Review"></p>
                            <input type="hidden" name="product_type" value="actual_product_type" id="product_type">
                            <input type="hidden" name="product_id" value="actual_product_id" id="product_id">
                        </fieldset>
                    </form>
                </div>
            </div>
            <!-- /.card -->

        </div>
        <!-- /.col-lg-9 -->

    </div>

</div>
<!-- /.container -->

<?php require_once './resources/layouts/footer.php'; ?>