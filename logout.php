<?php

require_once './functions/sessions.php';
require_once './functions/redirect.php';

logout();
$_SESSION['ALERT_SUCCESS'] = 'You have been successfully logged out.';
redirect('index.php');
?>