<?php
require_once "sessionManager.php"; // for isUserLogged()
require_once "dbManager.php"; // for getConn()
require_once "loginLib.php"; // for authenticateByUserId()
//require_once "registerManager.php"; // for password update function

if (!isUserLogged()){
    header('location: ./index.php');
}


function updatePasswordFailed($reason, $updateStatement, $db){ // to be called in all other occations
    setErrorMessage($reason);
    if($updateStatement !== null) $updateStatement->close();
    $db->closeConnection();
    header('location: profilePage.php');
}

global $db;
global $loginMessage;

$debugMessages = true;

$username = getSessionUsername();
$oldPass = $_POST['oldPassword'];
$newPass = $_POST['newPassword'];

$user = authenticateByUsername($username, $oldPass);
if($user === false){ 
    updatePasswordFailed($loginMessage, null,  $db);
}
else{
    $conn = $db->getConn();
    // se corretta eseguo la modifica della password sul db
    $updateStatement = $conn->prepare("UPDATE user SET hash_pass = ? WHERE username = ?;");

    if($updateStatement === false){
        $message = "We can't elaborate your request. try later.";
        if($debugMessages){
            $message = $message."<br><br>[DEBUG]<br>Code: ".$updateStatement->errno."<br>message: ".htmlspecialchars($updateStatement->error);
        }
        updatePasswordFailed($message, $updateStatement, $db);
    }
    $hashNewPass;
    $result = $updateStatement->bind_param("ss", $hashNewPass, $username);
    if($result === false){
        $message = "We can't elaborate your request. try later.";
        if($debugMessages){
            $message = $message."<br><br>[DEBUG]<br>Code: ".$updateStatement->errno."<br>message: ".htmlspecialchars($updateStatement->error);
        }
        updatePasswordFailed($message, $updateStatement, $db);
    }

    $hashNewPass = password_hash($newPass, PASSWORD_DEFAULT);

    $result = $updateStatement->execute();
    if($result === false){
        $message = "We can't update your password. try later.";
        if($debugMessages){
            $message = $message."<br><br>[DEBUG]<br>Code: ".$updateStatement->errno."<br>message: ".htmlspecialchars($updateStatement->error);
        }
        updatePasswordFailed($message, $updateStatement, $db);
    }

    setSuccessMessage("Password changed.");
    $updateStatement->close();
    $db->closeConnection();
    header('location: profilePage.php');
    
}



?>