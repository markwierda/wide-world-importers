<?php require_once './functions/filter.php'; ?>
<?php
$uri = str_replace('/wide-world-importers/', '', $_SERVER['REQUEST_URI']);
$uri = explode('?', $uri)[0];
if (isset($uri) && $uri[0] === '/') {
    $uri = substr_replace($uri, '', 0, 1);
}

$getParams =  ($uri === 'category.php') ? $uri . '?name=' . $_GET['name'] : $uri;
$getParams .= ($uri === 'results.php') ? "?search=".$_GET['search'] : '';
$getParams .= (isset($_GET['page'])) ? "&page=".$_GET['page'] : '';
$getParams .= (isset($_GET['price'])) ? "&price=".$_GET['price'] : '';
$getParams .= (isset($_GET['amount'])) ? "&amount=".$_GET['amount'] : '';
$getParams .= (isset($_GET['brand'])) ? "&brand=".$_GET['brand'] : '';
$getParams .= (isset($_GET['size'])) ? "&size=".$_GET['size'] : '';
$getParams .= (isset($_GET['colour'])) ? "&colour=".$_GET['colour'] : '';
print($getParams);
?>
<div class="col-6">
    <h4>Filter</h4>
</div>
<div class="col-6">
    <div class="dropdown">
        <a class="nav-link dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Amount
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a href="<?php echo $getParams . '&amount=25';?>"  class="d-block">25</a>
            <a href="<?php echo $getParams . '&amount=50';?>"  class="d-block">50</a>
            <a href="<?php echo $getParams . '&amount=100';?>" class="d-block">100</a>
        </div>
    </div>
</div>
<div class="col-12"><hr class="text-black-50"></div>

<div class="col-3 col-xs-6 col-sm-3">
    <div class="dropdown">
        <a class="nav-link dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Price
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a href="<?php echo $getParams . '&price=low-high';?>" class="d-block">Lowest - Highest</a>
            <a href="<?php echo $getParams . '&price=high-low';?>" class="d-block">Highest - Lowest</a>
        </div>
    </div>
</div>
<div class="col-3 col-xs-6 col-sm-3">
    <div class="dropdown">
        <a class="nav-link dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Brand
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <?php $brands = getBrands();
            while ($row = $brands->fetch_assoc()):?>
                <a href="<?php echo $getParams . '&brand=' . $row['Brand'];?>" class="d-block"><?=$row['Brand'];?></a>
            <?php endwhile;?>
        </div>
    </div>
</div>
<div class="col-3 col-xs-6 col-sm-3">
    <div class="dropdown">
        <a class="nav-link dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Size
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <?php $sizes = getSizes();
            while($row = $sizes->fetch_assoc()):?>
                <a href="<?php echo $getParams . '&size=' . $row['Size'];?>" class="d-block"><?=$row['Size'];?></a>
            <?php endwhile;?>
        </div>
    </div>
</div>
<div class="col-3 col-xs-6 col-sm-3">
    <div class="dropdown">
        <a class="nav-link dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Colour
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <?php $colour = getColours();
            while($row = $colour->fetch_assoc()):?>
                <a href="<?php echo $getParams . '&colour=' . $row['ColorName'];?>" class="d-block"><?=$row['ColorName'];?></a>
            <?php endwhile;?>
        </div>
    </div>
</div>