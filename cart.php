<?php
require_once './functions/sessions.php';


require_once './resources/layouts/header.php';

$card = [];
?>

<main>
    <div class="cart_section">
        <link href="resources/css/cart.css" rel="stylesheet">
        <div class="row">
            <div class="col-3">Productnaam</div>
            <div class="col-3">Prijs</div>
            <div class="col-3">Aantal</div>
            <div class="col-3">Totaal</div>

            <?php foreach ($card as $item):?>
                <div class="col-3"><?=$item['itemname']?></div>
                <div class="col-3">29.99</div>
                <div class="col-3">4</div>
                <div class="col-3">119.96</div>
            <?php endforeach;?>
        </div>


        <div class="row">
            <div class="col-3"> <a href="http://localhost">  <button class="homepage" type="button">Homepage</button> </div> </a>
            <div class="col-3"></div>
            <div class="col-3"></div>
           <div class="col-3"> <button class="checkout" type="button">Checkout</button> </div>
        </div>
    </div>
</main>e

