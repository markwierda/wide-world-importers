<?php

require_once './functions/sessions.php';
require_once './functions/cart.php';

$cart = getCart();
$endPrice = calculateEndPrice($cart);

if (isset($_GET['delete'])) {
    removeFromCart($_GET['delete']);
    exit;
}

?>
<?php require_once './resources/layouts/header.php'; ?>

<main>
    <div class="container my-5">

        <h1>Shopping Cart</h1>
        <br />

        <?php if(isset($_SESSION['ALERT_SUCCESS'])): ?>
            <div class="alert alert-success alert-dismissible my-4" role="alert">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $_SESSION['ALERT_SUCCESS']; ?>
            </div>
            <?php unset($_SESSION['ALERT_SUCCESS']); ?>
        <?php endif; ?>

        <?php if(isset($errors)): ?>
            <div class="alert alert-danger alert-dismissible my-4" role="alert">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php foreach ($errors as $error): ?>
                <span><?php echo $error; ?></span>
                <?php endforeach; ?>
            </div>
            <?php unset($_SESSION['ALERT_SUCCESS']); ?>
        <?php endif; ?>

        <?php if(!empty($cart)): ?>
        <div id="cartAlert">

        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">&nbsp;</th>
                    <th scope="col">Product</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($cart as $item):?>
                <?php $discount = getDiscount($item['StockItemID']); ?>
                <tr>
                    <td scope="row">
                        <a href="cart.php?delete=<?php echo $item['StockItemID']; ?>">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </a>
                    </td>
                    <td>
                        <a href="product.php?id=<?php echo $item['StockItemID']; ?>">
                            <?php echo $item['StockItemName']; ?>
                        </a>
                    </td>
                    <td>&euro;<?php echo $item['RecommendedRetailPrice']; ?></td>
                    <td>
                        <input id="<?php echo $item['StockItemID']; ?>" type="number" min="1" max="<?php echo $item['QuantityOnHand']; ?>" data-title="<?php echo htmlspecialchars($item['StockItemName']); ?>" class="cartQuantity form-control" value="<?php echo $item['quantity']; ?>">
                    </td>
                    <td id="total<?php echo $item['StockItemID']; ?>">&euro;<?php echo $item['total']; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <hr />

        <div class="row">
            <div class="col-md-2" id="endPrice">
                <b>Total price excl</b><br />&euro;<?php echo $endPrice['EXCL']; ?><br />
                <b>Tax</b><br />&euro;<?php echo $endPrice['TAX']; ?><br />
                <b>Total price incl</b><br />&euro;<?php echo $endPrice['INCL']; ?><br /><br />
                <a href="checkout.php" class="btn btn-success<?php echo !isset($_SESSION['user_id']) ? ' disabled' : ''; ?>">Checkout</a>
            </div>
            <?php if(!isset($_SESSION['user_id'])): ?>
            <div class="col-md-6 offset-md-4">
                <h5>Login to checkout</h5>
                <form action="login.php?redirect=cart.php" method="POST">
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
            </div>
            <?php endif; ?>
        </div>

        <?php else: ?>
        <div class="alert alert-danger alert" role="alert">
            There are no products found in the shopping cart. Click <a href="index.php">here</a> to go back to the homepage.
        </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once 'resources/layouts/footer.php'; ?>
