<?php
require_once "sessionManager.php"; // for isUserLogged()
require_once "dbManager.php"; // for getConn()
require_once "loginLib.php"; // for authenticateByUserId()
require_once "passwordResetLib.php"; // for password update function

if (!isUserLogged()) {
    header('location: ./index.php');
}


function updatePasswordFailed($reason, $updateStatement, $db)
{ // to be called in all other occations
    setErrorMessage($reason);
    if ($updateStatement !== null) $updateStatement->close();
    $db->closeConnection();
    header('location: profilePage.php');
}

global $db;
global $loginMessage;

$debugMessages = true;

$userId = getSessionUserId();
$oldPass = $_POST['oldPassword'];
$newPass = $_POST['newPassword'];

$user = authenticateByUsername($username, $oldPass);
if ($user === false) {
    updatePasswordFailed($loginMessage, null,  $db);
} else {
    changePassword($idUser, $newPass);
    header('location: profilePage.php');
}
