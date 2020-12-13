<?php
session_start();

require "sessionManager.php";
require "dbManager.php";

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

function login($email, $password)
{
	if ($email != null && $password != null) {
		$ret = authenticate($email, $password);
		if ($ret != 0) {
			$_SESSION['username'] = $ret['username'];
			$_SESSION['idUser'] = $ret['id'];
			return null;
		}
	} else
		return 'You should insert something';

	return 'Username or password invalid.';
}

function authenticate($email, $password)
{
	global $db;
	$email = $db->sqlInjectionFilter($email);

	$queryText = "select * from user where email='" . $email ."';";

	$result = $db->performQuery($queryText);
	$numRow = mysqli_num_rows($result);
	if ($numRow != 1)
		return 0;

	$row = $result->fetch_assoc();
	$db->closeConnection();

	$hash_pass = $row['hash_pass'];

	if(password_verify($password, $hash_pass)){
		return $row;
	}
	else{
		return 0;
	}

	
}
