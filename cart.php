<?php
require_once './functions/sessions.php';
require_once './functions/cart.php';

$cart = getCart();
$productIDs = [];

$endPrice = calculateEndPrice($cart);

?>
<?php require_once './resources/layouts/header.php'; ?>

<div class="container my-5">

    <h1>Shopping Cart</h1>
    <br />

    <?php if(!empty($cart)): ?>
    <div class="row">
        <div class="col-6">
            <b>Product</b>
        </div>
        <div class="col-2">
            <b>Price</b>
        </div>
        <div class="col-2">
            <b>Quantity</b>
        </div>
        <div class="col-2">
            <b>Total</b>
        </div>
    </div>

    <hr />

    <?php foreach ($cart as $item):?>
    <div class="row">
        <div class="col-6">
            <a href="product.php?id=<?php echo $item['StockItemID']; ?>">
                <?php echo $item['StockItemName']; ?>   
            </a>
        </div>
        <div class="col-2">&euro; <?php echo $item['RecommendedRetailPrice']; ?></div>
        <div class="col-2"><?php echo $item['quantity']; ?></div>
        <div class="col-2">&euro; <?php echo $item['total']; ?></div>
    </div>

    <hr />
    <?php endforeach; ?>

    <div class="row">
        <div class="col-6">&nbsp;</div>
        <div class="col-2">&nbsp;</div>
        <div class="col-2">&nbsp;</div>
        <div class="col-2">
            <b>Total price excl</b><br />&euro; <?php echo $endPrice['EXCL']; ?><br />
            <b>Tax</b><br />&euro; <?php echo $endPrice['TAX']; ?><br />
            <b>Total price incl</b><br />&euro; <?php echo $endPrice['INCL']; ?><br /><br />
            <a href="#" class="btn btn-success">Checkout</a>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-danger alert" role="alert">
        There are no products found in the shopping cart. Click <a href="index.php">here</a> to go back to the homepage.
    </div>
<?php endif; ?>

</div>

<?php require_once './resources/layouts/footer.php'; ?>