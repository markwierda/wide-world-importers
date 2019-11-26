<?php

require_once './database/connection.php';
require_once './functions/recaptcha.php';

function validateRegistration($form) {
	$errors = [];

	if (isValidRecaptchaResponse($form['g-recaptcha-response'])) {
		foreach ($form as $key => $value) {
			if (empty($value)) {
				$key = ucwords(str_replace('_', ' ', $key));
				$errors[$key] = 'The <b>' . $key . '</b> field cannot be empty, please try again.';
			}
		}

		if (!empty($errors))
			return $errors;

		return true;
	}

	$errors['recaptcha'] = 'ReCAPTCHA verification failed, please try again.';

	return $errors;
}