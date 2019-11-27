<?php

require_once './functions/register.php';

$success = null;

if ($_POST) {
	$response = validateRegistration($_POST);
	$success = null;

	if ($response && is_array($response)) {
        $errors = $response;
    } else {
        $success = true;
        unset($_POST);
    }
}

?>
<?php require_once './resources/layouts/header.php'; ?>

<!-- Page Content -->
<main>
	<div class="container">

    <div class="row justify-content-center">

        <div class="col-lg-10">

        	<h1 class="display-4 my-4">Register</h1>

            <?php if ($success): ?>
                <div class="alert alert-success" role="alert">
                    Your account has been successfully registered.
                </div>
        	<?php elseif (isset($errors) && is_array($errors)): ?>
        	<div class="alert alert-danger" role="alert">
        		<?php foreach ($errors as $error): ?>
  				<span><?php echo $error; ?></span>
  				<?php endforeach; ?>
			</div>
			<?php endif?>

        	<form method="POST" action="register.php">
  				<div class="form-group">
	    			<label for="name">Full Name</label>
				    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required autofocus value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>">
			  	</div>
	  			<div class="form-group">
	    			<label for="adress">Address</label>
				    <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address" required value="<?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?>">
				</div>
			  	<div class="row">
			  		<div class="col-md-6">
					  	<div class="form-group">
			    			<label for="city">City</label>
						    <input type="text" class="form-control" id="city" name="city" placeholder="Enter your city" required value="<?php echo isset($_POST['city']) ? $_POST['city'] : ''; ?>">
					  	</div>
					</div>
			  		<div class="col-md-6">
					  	<div class="form-group">
			    			<label for="postal">Postal Code</label>
						    <input type="text" class="form-control" id="postal" name="postal" placeholder="Enter your postal code" required value="<?php echo isset($_POST['city']) ? $_POST['city'] : ''; ?>">
					  	</div>
			  		</div>
			  	</div>
			  	<div class="form-group">
	    			<label for="email">E-mail address</label>
				    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your e-mail address" required value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
			  	</div>
			  	<div class="row">
			  		<div class="col-md-6">
				  		<div class="form-group">
			    			<label for="password">Password</label>
						    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
					  	</div>
			  		</div>
			  		<div class="col">
	  				  	<div class="form-group">
			    			<label for="confirm_password">Confirm Password</label>
						    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
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

</div>
<!-- /.container -->

<?php require_once './resources/layouts/footer.php'; ?>
