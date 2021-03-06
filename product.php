<?php

require_once './functions/product.php';
require_once './functions/review.php';
require_once './functions/discount.php';

if (isset($_POST['add'])) {
    require_once './functions/cart.php';
    addToCart($_POST['productID']);
}

if (isset($_POST['review'])) {
    $response = validateReview($_POST);

    if ($response && is_array($response)) {
        $errors = $response;
    } else {
        $_SESSION['ALERT_SUCCESS'] = 'Your review has been placed.';
        header('Location: product.php?id=' . $_GET['id']);
    }
}

$product = getProductByID($_GET['id']);
$reviews = getReviewByProductID($_GET['id']);

$userAlreadyHasReview = false;
if (isset($_SESSION['user_id']))
    $userAlreadyHasReview = userAlreadyHasReview($_GET['id'], $_SESSION['user_id']);

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

            <?php if (isset($errors) && is_array($errors)): ?>
                <div class="alert alert-danger my-4" role="alert">
                    <?php foreach ($errors as $error): ?>
                        <span><?php echo $error; ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif?>

            <div class="card mt-4">
                <img class="card-img-top img-fluid" src="https://placehold.it/900x400" alt="<?php echo $product['StockItemName']; ?>">
                <div class="card-body row">
                    <div class="col-lg-9 col-md">
                        <h3 class="card-title"><?php echo $product['StockItemName']; ?></h3>
                        <h4>
                            <?php
                            $retailprice = $product['RecommendedRetailPrice'];
                            $discount = getDiscount($product['StockItemID']);
                            if (!is_null($discount['DiscountPercentage']) || !is_null($discount['DiscountAmount'])) {
                                $price = $retailprice;
                                print("FROM <s class='text-danger'>&euro;" . number_format($price , 2, ',', '.') . "</s> FOR ");
                                if (!is_null($discount['DiscountPercentage'])) {
                                    $price = ($price * ((100 - $discount['DiscountPercentage']) / 100));
                                }
                                if (!is_null($discount['DiscountAmount'])) {
                                    $price = $price - $discount['DiscountAmount'];
                                }
                                $retailprice = $price;
                            }

                            echo "&euro;" . number_format($retailprice, 2, ',', '.');
                            ?>
                        </h4>
                        <p class="card-text"><?php echo !empty($product['MarketingComments']) ? $product['MarketingComments'] : '<i>This product has no description</i>'; ?></p>
                        <p class="card-text"><?php echo ($product['QuantityOnHand'] > 25) ? "<a class='text-success'>In stock</a>" : "<a class='text-danger'>{$product['QuantityOnHand']} Left</a>"?></p>
                        <?php if (!empty($reviews)): ?>
                        <span class="text-warning"><?php echo getAverageStars($_GET['id']); ?></span>
                        <?php echo count($reviews) > 1 ?  count($reviews) . ' reviews' :  count($reviews). ' review' ?>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-3 col-md">
                        <form action="product.php" method="POST">
                            <input type="hidden" name="productID" value="<?php echo $product['StockItemID']; ?>">
                            <button id="addToCart" type="submit" name="add" class="btn btn-success float-md-right">Add to cart</button>
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
                    <?php if (!empty($reviews)): ?>
                    <div id="edit" class="d-none">
                        <textarea class="form-control" data-description="<?php echo $_SESSION['user_id']; ?>"></textarea>
                        <div class="reviewActions">
                            <button id="saveReview" class="btn btn-primary" data-user_id="<?php echo $_SESSION['user_id']; ?>">Save</button>
                            <button id="cancelReview" class="btn btn-danger">Cancel</button>
                        </div>
                    </div>
                    <?php foreach ($reviews as $review): ?>
                    <div class="review">
                        <p data-description="<?php echo $review['user_id']; ?>"><?php echo $review['description']; ?></p>
                        <small class="text-muted">Posted by <?php echo $review['name']; ?> on <?php echo isset($review['updated_at']) ? date('d-m-Y H:i:s', strtotime($review['updated_at'])) : date('d-m-Y H:i:s', strtotime($review['created_at'])); ?></small><br>
                        <span class="text-warning"><?php echo getStars($review['stars']); ?></span>
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $review['user_id']): ?>
                        <div class="reviewActions">
                            <button id="editReview" class="btn btn-primary" data-review='<?php echo json_encode($review); ?>'>Edit</button>
                            <button id="deleteReview" class="btn btn-danger" data-review='<?php echo json_encode($review); ?>'>Delete</button>
                        </div>
                        <?php endif; ?>
                    <hr>
                    </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <p>There are no reviews for this product yet.</p>
                    <hr>
                    <?php endif; ?>

                    <?php if (!$userAlreadyHasReview): ?>
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <h5>Leave a review</h5>
                    <form action="product.php?id=<?php echo $_GET['id']; ?>" method="POST">
                        <div class="form-group">
                            <i class="fa fa-star fa-2x" data-index="1" style="border: 1px"></i>
                            <i class="fa fa-star fa-2x" data-index="2"></i>
                            <i class="fa fa-star fa-2x" data-index="3"></i>
                            <i class="fa fa-star fa-2x" data-index="4"></i>
                            <i class="fa fa-star fa-2x" data-index="5"></i>
                            <input id="stars" type="hidden" name="stars" value="0">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" class="form-control" maxlength="200" required></textarea>
                        </div>
                        <?php require_once 'resources/layouts/recaptcha.php'; ?>
                        <button type="submit" name="review" class="btn btn-primary">Submit</button>
                    </form>
                    <?php else: ?>
                    <h5>Login to leave a review</h5>
                    <form action="login.php?redirect=product.php?id=<?php echo $_GET['id']; ?>" method="POST">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input id="password" type="password" name="password" class="form-control" required>
                        </div>
                        <?php require_once 'resources/layouts/recaptcha.php'; ?>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            <!-- /.card -->

        </div>
        <!-- /.col-lg-9 -->

    </div>

</div>
<!-- /.container -->

<?php require_once './resources/layouts/footer.php'; ?>