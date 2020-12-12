<?php
session_start();

require "dbManager.php";

if (isset($_GET['logout'])) {
	logout();
} else {

	$username = $_POST['email'];
	$password = $_POST['password'];

	$errorMessage = login($username, $password);
	if ($errorMessage === null) {
		$_SESSION['cart'] = array();
		header('location: ./index.php');
	} else {
		$_SESSION['errorMessage'] = $errorMessage;
		header('location: ./login.php');
	}
}

function login($username, $password)
{
	if ($username != null && $password != null) {
		$ret = authenticate($username, $password);
		if ($ret != 0) {
			$_SESSION['username'] = $ret;
			return null;
		}
	} else
		return 'You should insert something';

	return 'Username or password invalid.';
}

function authenticate($username, $password)
{
	global $db;
	$username = $db->sqlInjectionFilter($username);
	$password = $db->sqlInjectionFilter($password);

	$queryText = "select * from User where email='" . $username . "' AND password='" . $password . "'";

	$result = $db->performQuery($queryText);
	$numRow = mysqli_num_rows($result);
	if ($numRow != 1)
		return 0;

	$row = $result->fetch_assoc();
	$db->closeConnection();

	return $row['username'];
}

function logout()
{
	session_unset();
	header('location: ./index.php');
}
