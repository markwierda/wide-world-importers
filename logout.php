<?php
require_once './functions/sessions.php';
require_once './functions/redirect.php';

destroySession();
redirect("http://{$_SERVER['HTTP_HOST']}/index.php");
?>