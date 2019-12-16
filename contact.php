<?php

require_once './functions/contact.php';

$suppliers = getSuppliers();

?>
<?php require_once './resources/layouts/header.php'; ?>
<main>
    <div class="container">

        <div class="row justify-content-center">

            <div class="col-lg-8">

                <h1 class="display-4 my-4">Contact</h1>

                <?php if (!isset($_SESSION['user_id'])): ?>
                <h5>Login to ask a question</h5>
                <form action="login.php?redirect=contact.php" method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" class="form-control" required>
                    </div>
                    <?php require_once 'resources/layouts/recaptcha.php'; ?>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                <?php else: ?>
                <div method="POST" action="contact.php">
                    <div class="dropdown">
                        <label for="supplier">Supplier</label>
                        <select id="supplier" class="form-control">
                            <option selected>-</option>
                            <?php foreach ($suppliers as $supplier): ?>
                            <option value="<?php echo $supplier['SupplierID']; ?>"><?php echo $supplier['SupplierName']; ?></option>
                            <?php endforeach; ?>
                        </select>
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
                <?php endif; ?>
            </div>
        </div>
</main>

<?php require_once './resources/layouts/footer.php'; ?>