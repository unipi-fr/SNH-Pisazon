<?php
require_once "sessionManager.php";
require_once "dbManager.php";

if(isUserLogged()){
    header('location: index.php');
}

function registrationFailed($reason){
    setErrorMessage($reason);
    header('location: register.php');
}
global $db;

$conn = $db->getConn();

$username = $email = $hash_pass = "";

$result = $registrationStatement = $conn->prepare("INSERT INTO user (username, email, hash_pass) VALUES (?, ?, ?)");
if($result === false){
    registrationFailed($registrationStatement->error);
}
$result = $registrationStatement->bind_param("sss", $username, $email, $hash_pass);
if($result === false){
    registrationFailed($registrationStatement->error);
}

$taintedUsername = $_POST["username"];
$taintedPassword = $_POST["password"];
$taintedEmail = $_POST["email"];

$username = $taintedUsername;
$email = $taintedEmail;
$hash_pass = password_hash($taintedPassword, PASSWORD_DEFAULT);
$result = $registrationStatement->execute();
if($result === false){
    registrationFailed("Code: ".$registrationStatement->errno."<br>message: ".htmlspecialchars($registrationStatement->error));
}else{
    //buon fine
    setSuccessMessage("Registration complete successfully, now you can log in :-)");
    header('location: login.php');
}


$registrationStatement->close();
?>