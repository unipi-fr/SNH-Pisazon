<?php
require_once "sessionManager.php"; // for isUserLogged()
require_once "dbManager.php"; // for getConn()
require_once "loginLib.php"; // for authenticateByUserId()
//require_once "registerManager.php"; // for password update function

if (!isUserLogged()){
    header('location: ./index.php');
}

global $db;
global $loginMessage;

$conn = $db->getConn();

$username = getSessionUsername();
$oldPass = $_POST['oldPassword'];
$newPass = $_POST['newPassword'];

$user = authenticateByUsername($username, $oldPass);
if($user === false){ // autenticazione fallita
    // mando messaggio di errore e ricarico la pagina con il bunner dell'errore sotto al pulsante del change password
    setErrorMessage($loginMessage);
    header('location: profilePage.php');
}
else{
    // se corretta eseguo la modifica della password sul db
    
    setSuccessMessage("Password changed.");
    header('location: profilePage.php');
}



?>