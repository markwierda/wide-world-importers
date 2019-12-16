<?php
function validateContact($form)
{
    if (!filter_var($form['email'], FILTER_VALIDATE_EMAIL))
        $errors['email'] = 'The specified <b>e-mail address</b> is not a valid e-mail address, please try again.';
}
?>