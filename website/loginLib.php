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
	global $db;
	$conn = $db->getConn();

	$loginStatement = $conn->prepare("SELECT *, (locked_until >= CURRENT_TIMESTAMP()) as locked FROM user WHERE username=?;");
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

	// qui siamo sicuri che l'utente esiste
	// dobbiamo controllare che l'account non sia lockato
	$locked = $row["locked"];
	if($locked){
		if($activateDebug)
			return loginFailed("Your account has been suspended for too many failed attempts.");
		else
			return loginFailed("Invalid username or password.");
	}

	// se non è lockato posso controllare la password
	$hash_pass = $row['hash_pass'];

	if (password_verify($password, $hash_pass)) {
		// se la verify va a buon fine bisogna resettare gli attemps sul db e il timestamp del blocco
		resetUserAttempts($row);
		return $row;
	} else {
		incrementUserAttempts($row);
		return loginFailed("Invalid username or password.");
	}
}

function resetUserAttempts($user, $activateDebug = false){
	$userId = $user["id"];

	global $db;
	$conn = $db->getConn();

	$updateStatement = $conn->prepare("UPDATE user SET attempts=0 WHERE id=?;");
	if ($updateStatement === false) {
		return loginFailed("We can't elaborate your request. try later.", $updateStatement, $db, $activateDebug);
	}
	$result = $updateStatement->bind_param("i", $userId);
	if ($result === false) {
		return loginFailed("We can't elaborate your request. try later.", $updateStatement, $db, $activateDebug);
	}

	$result = $updateStatement->execute();
	if ($result === false) {
		return loginFailed("We can't elaborate your request. try later.", $updateStatement, $db, $activateDebug);
	}
	$updateStatement->close();
	$db->closeConnection();
	return true;
}

function incrementUserAttempts($user, $activateDebug = false){
	$userId = $user["id"];
	$attempts = $user["attempts"]+1;
	$howManyMinutes = 0;
	if($attempts%5==0){
		$howManyMinutes = 2 ** floor($attempts/5);
	}

	global $db;
	$conn = $db->getConn();

	$updateStatement = $conn->prepare("UPDATE user SET attempts=?, locked_until = CURRENT_TIMESTAMP() + INTERVAL ? MINUTE WHERE id=?;");
	if ($updateStatement === false) {
		return loginFailed("We can't elaborate your request. try later.", $updateStatement, $db, $activateDebug);
	}

	$result = $updateStatement->bind_param("iii", $attempts, $howManyMinutes, $userId);
	if ($result === false) {
		return loginFailed("We can't elaborate your request. try later.", $updateStatement, $db, $activateDebug);
	}

	$result = $updateStatement->execute();
	if ($result === false) {
		return loginFailed("We can't elaborate your request. try later.", $updateStatement, $db, $activateDebug);
	}
	
	$updateStatement->close();
	$db->closeConnection();
	return true;
}

