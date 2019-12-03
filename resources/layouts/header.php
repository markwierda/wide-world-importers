<?php
require_once './functions/sessions.php'; //Contains session_start();
require_once './functions/category.php';
$categories = getCategories();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Shop Homepage - Start Bootstrap Template</title>

    <!-- Bootstrap core CSS -->
    <link href="resources/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <?php if (!strstr($_SERVER['REQUEST_URI'], 'register.php')): ?>
    <link href="resources/css/shop-login.css" rel="stylesheet">
    <?php endif; ?>
    <link href="resources/css/main.css" rel="stylesheet">
    <link href="resources/css/shop-homepage.css" rel="stylesheet">
    <link href="resources/css/shop-item.css" rel="stylesheet">
    <link href="resources/css/shop-searchbar.css" rel="stylesheet">
    <link href="resources/css/shop-header.css" rel="stylesheet">

    <!-- Font Awesome for icons-->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <style type="text/css">
        .fa_custom {
            color: #fbfcfc;
        }
    </style>
</head>
<body>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#"></a>
        <a href="http://localhost"><img src="resources\images\wide-world-importers-logo-small.png" style="max-height: 60px; padding-right: 100px" alt=""></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php require_once 'resources/layouts/search.php' ?>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <?php if (validateSession() === False):?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                <?php else:?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php endif;?>
                <li><a href="#"><span class="nav-link"></span></a></li>

                <a href="cart.php">
                    <i id="icon_shopping" class="fa fa-shopping-cart fa_custom fa-1x"></i>
                </a>
              </ul>
        </div
    </div>
</nav>