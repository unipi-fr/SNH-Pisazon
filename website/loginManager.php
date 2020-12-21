<?php
require_once "sessionManager.php";
require_once "loginLib.php";

if (isset($_GET['logout'])) {
	logout();
} else {

	$email = $_POST['email'];
	$password = $_POST['password'];

	$errorMessage = login($email, $password);
	if ($errorMessage === null) {
		$_SESSION['cart'] = array();
		header('location: ./index.php');
	} else {
		$_SESSION['errorMessage'] = $errorMessage;
		header('location: ./login.php');
	}
}








