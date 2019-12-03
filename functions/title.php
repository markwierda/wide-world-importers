<?php

function getTitle($product = null) {
    $uri = str_replace('/wide-world-importers/', '', $_SERVER['REQUEST_URI']);
    $uri = explode('?', $uri)[0];

    switch ($uri) {
        case 'category.php':
            $title = $_GET['name'] . ' - ' . 'Wide World Importers';
            break;
        case 'product.php':
            $title = $product['StockItemName'] . ' - ' . 'Wide World Importers';
            break;
        case 'results.php':
            $title = 'Search Results - Wide World Importers';
            break;
        case 'login.php':
            $title = 'Login - Wide World Importers';
            break;
        case 'register.php':
            $title = 'Register - Wide World Importers';
            break;
        case 'cart.php':
            $title = 'Shopping Cart - Wide World Importers';
            break;
        default:
            $title = 'Wide World Importers';
            break;
    }

    return $title;
}