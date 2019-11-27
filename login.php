<?php require_once './resources/layouts/header.php';
require_once  './functions/login.php';?>
<?php

?>
<link href="resources/css/shop-login.css" rel="stylesheet">

<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div class="fadeIn first">
            <h1>Login</h1>
        </div>

        <!-- Login Form -->
        <form action="<?=$_SERVER['PHP_SELF'];?>" method="POST">
            <input type="text" id="email" class="fadeIn second" name="email" placeholder="Email">
            <input type="text" id="password" class="fadeIn third" name="password" placeholder="Password">
            <input type="submit" class="fadeIn fourth" value="Log In">
        </form>

        <!-- Remind Passowrd -->
        <div id="formFooter">
            <div class="row">
                <div class="col-12 col-md-6">
                    <a class="underlineHover" href="#">Forgot Password?</a>
                </div>
                <div class="col-12 col-md-6">
                    <a class="underlineHover" href="#">Register</a>
                </div>
            </div>
        </div>

    </div>
</div>






<?php require_once './resources/layouts/footer.php'; ?>
