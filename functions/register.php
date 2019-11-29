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
		    // Check empty values
            if (empty($value)) {
                $key = ucwords(str_replace('_', ' ', $key));
                $errors[$key] = 'The <b>' . $key . '</b> field cannot be empty, please try again.';
            }

            // Check if values not longer than 45 characters
		    if (strlen($value) > 45 && $key !== 'g-recaptcha-response') {
                $errors[$key] = 'The <b>' . $key . '</b> field cannot longer than 45 characters, please try again.';
            }
		}

		// Validate email
        if (!filter_var($form['email'], FILTER_VALIDATE_EMAIL))
            $errors['email'] = 'The specified <b>e-mail address</b> is not a valid e-mail address, please try again.';

		// Check if user already exist
        if (checkIfUserAlreadyExist($form['email']))
            $errors['email'] = 'The specified <b>e-mail address</b> is already registered, try a different e-mail address.';

        // Check if password is confirmed
        if ($form['password'] !== $form['confirm_password'])
            $errors['confirm_password'] = 'The specified <b>passwords</b> do not match, please try again.';

        // Validate password
        if (strlen($form['password']) < 8 || preg_match('/[A-Z]/', $form['password']) < 1 || preg_match('/[A-Z]/', $form['password']) < 1 || preg_match('/[!@#$%^&*(),.?":{}|<>]/', $form['password']) < 1)
            $errors['password'] = 'The specified <b>password</b> must be at least 8 characters long, contains at least one capital letter, contains at least one number and contains at least one special character. Please try again.';

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
