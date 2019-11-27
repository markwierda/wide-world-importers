<?php
require_once './functions/validate_user.php';
require_once './functions/redirect.php';
require_once './functions/sessions.php'; ?>
<?php

if (isset($_SESSION['user_id']))
    redirect('index.php');

$errormsg = "";
if (isset($_POST['email']) && isset($_POST['password'])) {
    if (check_User_Combination($_POST['email'], $_POST['password'])) {
        $uid = get_uid($_POST['email']);
        if ($uid !== False) {
            createSession($uid);
            redirect('index.php');
        }
    } else {
        //Handle error message?
        $errormsg = "Invalid combination";
    }
}

require_once './resources/layouts/header.php';
?>

<main id="login">
    <div class="container">
        <?php if (!empty($errormsg)): ?>
            <div class="alert alert-danger" role="alert">
                <span><?php echo $errormsg; ?></span>
            </div>
        <?php endif; ?>

        <div class="row justify-content-center">
            <div id="formContent" class="col-lg-12">
                <div class="fadeIn first">
                    <h1>Login</h1>
                </div>

                <form action="<?=$_SERVER['PHP_SELF'];?>" method="POST">
                    <input type="text" id="email" class="fadeIn second" name="email" placeholder="Email">
                    <input type="password" id="password" class="fadeIn third" name="password" placeholder="Password">
                    <input type="submit" class="fadeIn fourth" value="Log In">
                </form>

                <div id="formFooter">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <a class="underlineHover" href="#">Forgot Password?</a>
                        </div>
                        <div class="col-12 col-md-6">
                            <a class="underlineHover" href="register.php">Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<!--
<div class="wrapper fadeInDown">
    <div id="formContent">
        <div class="fadeIn first">
            <h1>Login</h1>
        </div>

        <form action="<?=$_SERVER['PHP_SELF'];?>" method="POST">
            <input type="text" id="email" class="fadeIn second" name="email" placeholder="Email">
            <input type="password" id="password" class="fadeIn third" name="password" placeholder="Password">
            <input type="submit" class="fadeIn fourth" value="Log In">
        </form>

        <div id="formFooter">
            <div class="row">
                <div class="col-12 col-md-6">
                    <a class="underlineHover" href="#">Forgot Password?</a>
                </div>
                <div class="col-12 col-md-6">
                    <a class="underlineHover" href="register.php">Register</a>
                </div>
            </div>
        </div>

    </div>
</div>
-->





<?php require_once './resources/layouts/footer.php'; ?>
