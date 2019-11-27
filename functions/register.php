<?php
require_once './functions/sessions.php';
require_once './database/connection.php';
require_once './functions/recaptcha.php';
require_once './functions/validate_user.php';

// Validate user input from registration form and create user when no error
function validateRegistration($form) {
	$errors = [];

	if (isValidRecaptchaResponse($form['g-recaptcha-response'])) {
		foreach ($form as $key => $value) {
			if (empty($value)) {
				$key = ucwords(str_replace('_', ' ', $key));
				$errors[$key] = 'The <b>' . $key . '</b> field cannot be empty, please try again.';
			}
		}

        if (!filter_var($form['email'], FILTER_VALIDATE_EMAIL))
            $errors['email'] = 'The specified <b>e-mail address</b> is not a valid e-mail address, please try again.';

        if (checkIfUserAlreadyExist($form['email']))
            $errors['email'] = 'The specified <b>e-mail address</b> is already registered, try a different e-mail address.';

        if ($form['password'] !== $form['confirm_password'])
            $errors['password'] = 'The specified <b>passwords</b> do not match, please try again.';

        if (!empty($errors))
			return $errors;

        create_User($form);
        if (get_uid($form['email']) !== False) {
            createSession(get_uid($form['email']));
        }
        return true;
	}

	$errors['recaptcha'] = '<b>ReCAPTCHA</b> verification failed, please try again.';

	return $errors;
}

// Check if there is already an user with the given email
function checkIfUserAlreadyExist($email) {
    if (empty($email))
        return false;

    $conn = connection();

    $stmt = $conn->prepare(
        'SELECT id FROM wwi_users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();

    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
    $conn->close();

    if (!$result)
        return false;

    return true;
}
