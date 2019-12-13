<?php require_once './resources/layouts/header.php'; ?>
<?php require_once './functions/contact.php'; ?>
<main>
    <div class="container">

        <div class="row justify-content-center">

            <div class="col-lg-8">

                <h1 class="display-4 my-4">Contact</h1>

                <form method="POST" action="contact.php">
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required maxlength="45">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your e-mail address" required maxlength="45" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                        </div>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                            <label for="message">Message</label>
                            <textarea rows= "5" class="form-control" id="message" name="message" placeholder="Enter your message" required maxlength="450"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <?php require_once 'resources/layouts/recaptcha.php'; ?>

                <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
        </div>
</main>

<?php require_once './resources/layouts/footer.php'; ?>