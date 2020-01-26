<?php
require_once './functions/forum.php';

// Check if isset parameter is set, if not redirect
if (!isset($_GET["edit"])) {
    header("LOCATION:forum.php");
}

// get the forum that belons to id
$forum = getforumByID($_GET["edit"]);

// check if user id matches user
if ($forum["user_id"]!=$_SESSION["user_id"]){
    header("LOCATION:forum.php");
};
?>
<?php require_once './resources/layouts/header.php'; ?>

<main>
    <div class="container">

        <div class="row justify-content-center">

            <div class="col-lg-8">

                <h1 class="display-4 my-4">Edit forum</h1>
                <form method="post" action="editForum.php?edit=<?php echo $_GET["edit"]?>" enctype="multipart/form-data">
                    <div class="card card-outline-secondary my-4">
                        <div class="card-header">
                            Edit message
                        </div>
                        <div class="form-group">
                            <textarea rows= "5" class="form-control" id="message" name="message" required maxlength="254"><?php echo $forum['message']; ?></textarea>
                        </div>
                        <?php require_once 'resources/layouts/recaptcha.php'; ?>
                        <button type="submit" class="btn btn-primary">Upload message</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</main>

<?php require_once './resources/layouts/footer.php'; ?>
