<?php

require_once './functions/sessions.php';
require_once './functions/redirect.php';

destroySession();
redirect('index.php');
?>