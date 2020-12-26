<?php
require_once "loginLib.php";

if (isset($_GET['logout'])) {
	logout();
} else {

	$username = $_POST['username'];
	$password = $_POST['password'];

	
	if (login($username, $password) === true) {
		header('location: ./index.php');
	} else {
		header('location: ./login.php');
	}
}








