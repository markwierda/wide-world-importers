<?php require_once './functions/forum.php';

$messageResult = getMessages();

?>



<?php require_once './resources/layouts/header.php'; ?>
<main>
        <div class="container">

            <div class="row justify-content-center">

                <div class="col-lg-8">

                    <h1 class="display-4 my-4">Forum</h1>

                    <?php while($row = $messageResult->fetch_assoc()): ?>
                    <div class="card card-outline-secondary my-4">
                        <div class="card-header">
                            <?php print $row['name']; ?>
                        </div>
                        <?php if (!empty($row['foto'])):?>
                        <img class="card-img-top" src="<?php print $row['foto']; ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <?php print $row['message']; ?>
                        </div>
                    </div>
                    <?php endwhile; ?>
                    <?php if (!isset($_SESSION['user_id'])): ?>


                        <h5>Login to leave a message</h5>
                        <form action="login.php?redirect=forum.php" method="POST">
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
                    <form method="post" action="forum.php" enctype="multipart/form-data">
                    <div class="card card-outline-secondary my-4">
                        <div class="card-header">
                            Username
                        </div>
                            <div class="form-group">
                                <textarea rows= "5" class="form-control" id="message" name="message" placeholder="Enter your message" required maxlength="400"></textarea>
                            </div>
                            <?php require_once 'resources/layouts/recaptcha.php'; ?>
                            <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
</main>



<?php require_once './resources/layouts/footer.php'; ?>