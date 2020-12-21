<?php 
require_once "dbManager.php";

$loginMessage = null;

function login($email, $password)
{
	if ($email != null && $password != null) {
		$ret = authenticate($email, $password);
		if ($ret != 0) {
			$_SESSION['username'] = $ret['username'];
			$_SESSION['email'] = $ret['email'];
			$_SESSION['idUser'] = $ret['id'];
			return null;
		}
	} else
		return 'You should insert something';

	return 'Invalid username or password';
}

// TODO: DA CAMBIAREEEEEE!!!!!
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

function loginFailed($message, $loginStatement, $db, $activateDebug){
	$loginMessage = $message;
	if($activateDebug){
        $message = $message."<br><br>[DEBUG]<br>Code: ".$loginStatement->errno."<br>message: ".htmlspecialchars($loginStatement->error);
	}
    $loginStatement->close();
	$conn->closeConnection();
	return false;    
}

function authenticateByUsername($username, $password, $activateDebug = false){
	global $loginMessage;
	global $db;
	$conn = $db->getConn();

	$loginStatement = $conn->prepare("SELECT * FROM user WHERE username=?;");
	if($loginStatement === false){
		return loginFailed("We can't elaborate your request. try later.", $loginStatement, $db, $activateDebug);
	}
	$result = $loginStatement->bind_param("s", $username);
	if($result === false){
		return loginFailed("We can't elaborate your request. try later.", $loginStatement, $db, $activateDebug);
	}

	$result = $loginStatement->execute();
	if($result === false){
		return loginFailed("We can't elaborate your request. try later.", $loginStatement, $db, $activateDebug);
	}
	$result = $loginStatement->get_result();
	$loginStatement->close();
	$db->closeConnection();
    
	
    if($result->num_rows != 1){ // user not found
        $loginMessage = "Invalid username or password.";
		return false;
	}
	$row = $result->fetch_assoc();

	$hash_pass = $row['hash_pass'];

	if(password_verify($password, $hash_pass)){
		return $row;
	}
	else{
		$loginMessage = "Invalid username or password.";
		return false;
	}
}

?>