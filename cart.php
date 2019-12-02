<?php
require_once './functions/sessions.php';
require_once './functions/cart.php';
require_once './resources/layouts/header.php';

$card = getCart();
$productIDs = [];

?>

<div class="container">
    <div class="cart_section">
        <link href="resources/css/cart.css" rel="stylesheet">
        <?php if ($card !== False):?>
        <div class="row">
            <div class="col-3">Product name</div>
            <div class="col-3">Price</div>
            <div class="col-3">Amount</div>
            <div class="col-3">Total</div>
            <?php foreach ($card as $item):?>
                <?php for ($i = 0; $i < $item['quantity']; $i++) { array_push($productIDs, $item['StockItemID']); }?>
                <div class="col-3"><?=$item['StockItemName'];?></div>
                <div class="col-3">&euro; <?=str_replace('.', ',', $item['RecommendedRetailPrice']);?></div>
                <div class="col-3"><?=$item['quantity'];?></div>
                <div class="col-3">&euro; <?=str_replace('.', ',', $item['total']);?></div>
            <?php endforeach;?>
            <?php $end = calculateEndPrice($productIDs);?>
        </div>
        <hr />
        <div class="row">
            <div class="col-3"></div>
            <div class="col-3"></div>
            <div class="col-3"></div>
            <div class="col-3">
                TAX<br />&euro; <?=str_replace('.', ',', $end['BTW']);?><hr/>
                Total price excl<br />&euro; <?=str_replace('.', ',', $end['EXCL']);?><hr />
                Total price incl<br/>&euro; <?=str_replace('.', ',', $end['INCL']);?>
            </div>
        </div>
        <?php else:?>
        <div>
            There are 0 products in your shopping cart
        </div>
        <?php endif;?>



        <a href="http://localhost">  <button type="submit" class="btn btn-primary float-left">Homepage</button>
            <button type="submit" class="btn btn-primary float-right">Checkout</button> </a>
    </div>
</div>

