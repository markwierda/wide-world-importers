<?php require_once './resources/layouts/header.php'; ?>


<!-- Page Content -->
<main>
	<div class="container">

    <div class="row justify-content-center">

        <div class="col-lg-10 my-4">

        	<h1 class="display-4">Register</h1>

        	<form method="POST" action="register.php">
  				<div class="form-group">
	    			<label for="name">Name</label>
				    <input type="text" class="form-control" id="name" placeholder="Enter your name" required autofocus>
			  	</div>
	  			<div class="form-group">
	    			<label for="adress">Address</label>
				    <input type="text" class="form-control" id="address" placeholder="Enter your address" required>
				</div>
			  	<div class="row">
			  		<div class="col-md-6">
					  	<div class="form-group">
			    			<label for="city">City</label>
						    <input type="text" class="form-control" id="city" placeholder="Enter your city" required>
					  	</div>
					</div>
			  		<div class="col-md-6">
					  	<div class="form-group">
			    			<label for="postal">Postal Code</label>
						    <input type="text" class="form-control" id="postal" placeholder="Enter your postal code" required>
					  	</div>
			  		</div>
			  	</div>
			  	<div class="form-group">
	    			<label for="email">E-mail address</label>
				    <input type="email" class="form-control" id="email" placeholder="Enter your e-mail address" required>
			  	</div>
			  	<div class="row">
			  		<div class="col-md-6">
				  		<div class="form-group">
			    			<label for="password">Password</label>
						    <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
					  	</div>
			  		</div>
			  		<div class="col">
	  				  	<div class="form-group">
			    			<label for="confirm_password">Confirm Password</label>
						    <input type="password" class="form-control" id="confirm_password" placeholder="Confirm your password" required>
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
