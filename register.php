<?php

session_start();

require_once './functions/register.php';

if (isset($_SESSION['user_id']))
    header('Location: index.php');

if ($_POST) {
	$response = validateRegistration($_POST);

	if ($response && is_array($response)) {
        $errors = $response;
    } else {
        $_SESSION['ALERT_SUCCESS'] = 'Your account has been successfully registered.';
        header('Location: index.php');
    }
}

?>
<?php require_once './resources/layouts/header.php'; ?>

<!-- Page Content -->
<main>
	<div class="container">

    <div class="row justify-content-center">

        <div class="col-lg-8">

        	<h1 class="display-4 my-4">Register</h1>

        	<?php if (isset($errors) && is_array($errors)): ?>
        	<div class="alert alert-danger" role="alert">
        		<?php foreach ($errors as $error): ?>
  				<span><?php echo $error; ?></span>
  				<?php endforeach; ?>
			</div>
			<?php endif?>

        	<form method="POST" action="register.php">
  				<div class="form-group">
	    			<label for="name">Full Name</label>
				    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required maxlength="45" autofocus value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>">
			  	</div>
	  			<div class="form-group">
	    			<label for="adress">Address</label>
				    <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address" required maxlength="45" value="<?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?>">
				</div>
			  	<div class="row">
			  		<div class="col-md-6">
					  	<div class="form-group">
			    			<label for="city">City</label>
						    <input type="text" class="form-control" id="city" name="city" placeholder="Enter your city" required maxlength="45" value="<?php echo isset($_POST['city']) ? $_POST['city'] : ''; ?>">
					  	</div>
					</div>
			  		<div class="col-md-6">
					  	<div class="form-group">
			    			<label for="postal">Postal Code</label>
						    <input type="text" class="form-control" id="postal" name="postal" placeholder="Enter your postal code" required maxlength="45" value="<?php echo isset($_POST['city']) ? $_POST['city'] : ''; ?>">
					  	</div>
			  		</div>
			  	</div>
			  	<div class="form-group">
	    			<label for="email">E-mail address</label>
				    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your e-mail address" required maxlength="45" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
			  	</div>
			  	<div class="row">
			  		<div class="col-md-6">
				  		<div class="form-group">
			    			<label for="password">Password</label>
						    <input type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelp" placeholder="Enter your password" required maxlength="45">
                            <small id="passwordHelp" class="form-text text-muted">Password must be at least 8 characters long, contains at least one capital letter, contains at least one number and contains at least one special character.</small>
                        </div>
			  		</div>
			  		<div class="col">
	  				  	<div class="form-group">
			    			<label for="confirm_password">Confirm Password</label>
						    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required maxlength="45">
			  			</div>
			  		</div>
			  	</div>
				<?php require_once 'resources/layouts/recaptcha.php'; ?>
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>

        </div>
        <!-- /.col-lg-12 -->

    </div>
    <!-- /.row -->
</main>
<!-- /.container -->

<?php require_once './resources/layouts/footer.php'; ?>
