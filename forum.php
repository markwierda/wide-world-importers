<?php require_once './functions/forum.php';
$messageResult = getMessages();
?>



<?php require_once './resources/layouts/header.php'; ?>

<main>
        <div class="container">

            <div class="row justify-content-center">

                <div class="col-lg-8">

                    <h1 class="display-4 my-4">Forum</h1>
                    <?php
                    if (!isset($_GET["edit"])) {
                    }
                    // Each message in result will be shown
                    while($row = $messageResult->fetch_assoc()): ?>
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
                        // Only the forum that belongs to the user_id can be edited
                        <?php if($row ["user_id"]==$_SESSION ["user_id"]): ?>
                        <div class="card-footer">
                            <a href="edit-forum.php?edit=<?php print $row["id"]; ?>" class="btn btn-primary">edit</a>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endwhile; ?>
                    <?php if (!isset($_SESSION['user_id'])): ?>

                        // if not logged in, gets a form to log in
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

                    // a message and picture can be uploaded by the following form
                    <?php else: ?>
                    <form method="post" action="uploadForum.php" enctype="multipart/form-data">
                        <div class="card card-outline-secondary my-4">
                            <div class="card-header">
                                Your message
                            </div>
                                <div class="form-group">
                                    <textarea rows= "5" class="form-control" id="message" name="message" placeholder="Enter your message" required maxlength="254"></textarea>
                                </div>
                                <input type="file" name="imageToUpload">
                                <?php require_once 'resources/layouts/recaptcha.php'; ?>
                            <button type="submit" class="btn btn-primary">Upload message</button>
                        </div>

                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
</main>



<?php require_once './resources/layouts/footer.php'; ?>