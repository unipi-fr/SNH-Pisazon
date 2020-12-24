<?php
require_once "sessionManager.php";
require_once "dbManager.php";

$activateDebug = true;

function checkValidToken($taintedToken){
    global $db;
    global $activateDebug;

    $conn = $db->getConn();
    $hashToken =  hash("sha512", $taintedToken);
    
    $checkTokenStatement = $conn->prepare("SELECT * from tokens WHERE expiration_date > CURRENT_TIMESTAMP() AND hash_token = ?;");
    if($checkTokenStatement === false){
		return passwordResetFailed("We can't elaborate your request, please try later.", $checkTokenStatement, $db, $activateDebug);
    }

    $result = $checkTokenStatement->bind_param("s", $hashToken);
    if($result === false){
		return passwordRecoveryFailed("We can't elaborate your request, please try later.",$checkTokenStatement,$db,$activateDebug);
    }

    $result = $checkTokenStatement->execute();
    if($result === false){
		return passwordRecoveryFailed("We can't elaborate your request. try later.", $checkTokenStatement, $db, $activateDebug);
    }
    
    $result = $checkTokenStatement->get_result();
	$checkTokenStatement->close();
    $db->closeConnection();

    if($result->num_rows != 1){ // user not found
        setErrorMessage("Token invalid or expired.");
		return false;
    }

    $row = $result->fetch_assoc();
    $userId = $row['id_user'];

    #setSuccessMessage("you have inserted a beautifull token for user:<br>$userId");
    setSessionTokenUserId($userId);
}

function passwordResetFailed($reason, $statement, $db, $activateDebug = false){ 
    if($activateDebug && $statement !== null){
        $reason = $reason."<br><br>[DEBUG]<br>Code: ".$statement->errno."<br>message: ".htmlspecialchars($statement->error);
    }
    
    setErrorMessage($reason);

    if($statement !== null) 
        $statement->close();

    $db->closeConnection();

    return false;
}

?>