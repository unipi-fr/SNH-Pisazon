<?php
require_once "dbManager.php";
require_once "sessionManager.php";

$activateDebug  = true;

function login($username, $password)
{
	global $activateDebug;

	if ($username === null || $password === null) {
		$loginMessage = 'You must provide all credentials.';
		return false;
	} 
	
	$ret = authenticateByUsername($username, $password, $activateDebug);
	if ($ret !== false) {
		setSessionUser($ret);
		return true;
	}

	return $ret; //false
}


function loginFailed($message, $loginStatement = null, $db = null, $activateDebug = false)
{
	if($loginStatement !== null){
		if ($activateDebug) {
			$message = $message . "<br><br>[DEBUG]<br>Code: " . $loginStatement->errno . "<br>message: " . htmlspecialchars($loginStatement->error);
		}
		$loginStatement->close();
	}
	if($db !== null){
		$db->closeConnection();
	}
	setErrorMessage($message);
	return false;
}

function authenticateByUsername($username, $password, $activateDebug = false)
{
	global $loginMessage;
	global $db;
	$conn = $db->getConn();

	$loginStatement = $conn->prepare("SELECT * FROM user WHERE username=?;");
	if ($loginStatement === false) {
		return loginFailed("We can't elaborate your request. try later.", $loginStatement, $db, $activateDebug);
	}
	$result = $loginStatement->bind_param("s", $username);
	if ($result === false) {
		return loginFailed("We can't elaborate your request. try later.", $loginStatement, $db, $activateDebug);
	}

	$result = $loginStatement->execute();
	if ($result === false) {
		return loginFailed("We can't elaborate your request. try later.", $loginStatement, $db, $activateDebug);
	}
	$result = $loginStatement->get_result();
	$loginStatement->close();
	$db->closeConnection();


	if ($result->num_rows != 1) { // user not found
		return loginFailed("Invalid username or password.");
	}
	$row = $result->fetch_assoc();

	$hash_pass = $row['hash_pass'];

	if (password_verify($password, $hash_pass)) {
		return $row;
	} else {
		return loginFailed("Invalid username or password.");
	}
}
