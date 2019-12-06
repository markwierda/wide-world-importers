<?php
require_once './functions/sessions.php';
require_once './functions/cart.php';

$cart = getCart();
$productIDs = [];

$endPrice = calculateEndPrice($cart);

?>
<?php require_once './resources/layouts/header.php'; ?>

<main>
    <div class="container my-5">

        <h1>Shopping Cart</h1>
        <br />

        <?php if(!empty($cart)): ?>
            <table class="table table-sm">
                <thead>
                <tr>
                    <th scope="col">Product</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Total</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($cart as $item):?>
                    <tr>
                        <td scope="row">
                            <a href="product.php?id=<?php echo $item['StockItemID']; ?>">
                                <?php echo $item['StockItemName']; ?>
                            </a>
                        </td>
                        <td>&euro;<?php echo $item['RecommendedRetailPrice']; ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>&euro;<?php echo $item['total']; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <hr />

            <div class="row">
                <div class="col-md-10 d-sm-none">&nbsp;</div>
                <div class="col-md-2">
                    <b>Total price excl</b><br />&euro;<?php echo $endPrice['EXCL']; ?><br />
                    <b>Tax</b><br />&euro;<?php echo $endPrice['TAX']; ?><br />
                    <b>Total price incl</b><br />&euro;<?php echo $endPrice['INCL']; ?><br /><br />
                    <a href="#" class="btn btn-success">Checkout</a>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-danger alert" role="alert">
                There are no products found in the shopping cart. Click <a href="index.php">here</a> to go back to the homepage.
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once 'resources/layouts/footer.php'; ?>
