<?php

require_once './functions/sessions.php';
require_once './functions/order.php';
require_once './functions/user.php';

if (!isset($_GET['id']))
    header('Location: index.php');

$order = getOrderByID($_GET['id']);
$user = getUserByID($order[0]['user_id']);

if (!$order)
    header('Location: index.php');

?>
<?php require_once './resources/layouts/header.php'; ?>

<main>
    <div class="container my-5">
        <?php if ($order[0]['status'] === 'paid'): ?>
        <h1>Thank you for your order</h1>
        <p class="font-italic">Order number: <?php echo $_GET['id']; ?></p>
        <p>Your order will be delivered to your address shortly.</p>
        <p>
            <b>Delivery address:</b><br />
            <?php echo $user['name']; ?><br />
            <?php echo $user['address']; ?><br />
            <?php echo $user['postal'] . ' ' . $user['city']; ?>
        </p>
        <?php else: ?>
        <h1>Order number: <?php echo $_GET['id']; ?></h1>
        <br />
        <p class="alert alert-danger">
            Your order has not been paid yet, please confirm your payment.
            <a href="https://www.mollie.com/payscreen/select-method/<?php echo $order[0]['payment_id']; ?>">
                https://www.mollie.com/payscreen/select-method/<?php echo $order[0]['payment_id']; ?>
            </a>
        </p>
        <?php endif; ?>

        <br />

        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Product</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Total</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($order as $item):?>
                <tr>
                    <td>
                        <a href="product.php?id=<?php echo $item['StockItemID']; ?>">
                            <?php echo $item['StockItemName']; ?>
                        </a>
                    </td>
                    <td>&euro;<?php echo number_format($item['price'], 2, ',', '.'); ?></td>
                    <td><?php echo number_format($item['quantity'], 0, ',', '.'); ?></td>
                    <td>&euro;<?php echo number_format($item['total'], 2, ',', '.'); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <br />
    </div>
</main>

<?php require_once 'resources/layouts/footer.php'; ?>
