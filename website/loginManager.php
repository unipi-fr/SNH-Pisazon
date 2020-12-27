<?php
require_once "loginLib.php";

if (isset($_GET['logout'])) {
	logout();
} else {

	$username = $_POST['username'];
	$password = $_POST['password'];

	$cookie_name = $username;
	if (!isset($_COOKIE[$cookie_name])) {
		$cookie_value = 1;
	} else {
		$cookie_value = $_COOKIE[$cookie_name] + 1;
	}

	if ($cookie_value > 5) {
		setErrorMessage("User $username will be blocked if it exists");
		header('location: ./login.php');
	} else {

		setcookie($cookie_name, $cookie_value, time() + (120), "/"); // 120 means 2 minutes

		if (login($username, $password) === true) {
			header('location: ./index.php');
		} else {
			header('location: ./login.php');
		}
	}
}
