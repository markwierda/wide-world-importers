<?php

function isValidRecaptchaResponse($response) {
	if(isset($response) && !empty($response)) {
		$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?&response=' . $response);
		$responseData = json_decode($verifyResponse);

		return true;
	}

	return false;
}
