<?php
require_once "sessionManager.php";
require_once "dbManager.php";

$debugMessages = true;

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

$result = $registrationStatement = $conn->prepare("INSERT INTO user (username, email, hash_pass) VALUES (?, ?, ?);");
if($result === false){
    $message = "We can't elaborate your request. try later.";
    if($debugMessages){
        $message = $message."<br><br>[DEBUG]<br>Code: ".$registrationStatement->errno."<br>message: ".htmlspecialchars($registrationStatement->error);
    }
    registrationFailed($message);
}
$result = $registrationStatement->bind_param("sss", $username, $email, $hash_pass);
if($result === false){
    $message = "We can't elaborate your request. try later.";
    if($debugMessages){
        $message = $message."<br><br>[DEBUG]<br>Code: ".$registrationStatement->errno."<br>message: ".htmlspecialchars($registrationStatement->error);
    }
    registrationFailed($message);
}

$taintedUsername = $_POST["username"];
$taintedPassword = $_POST["password"];
$taintedEmail = $_POST["email"];

$username = $taintedUsername;
$email = $taintedEmail;
$hash_pass = password_hash($taintedPassword, PASSWORD_DEFAULT);
$result = $registrationStatement->execute();
if($result === false){
    switch ($registrationStatement->errno){
        case 1062: //unique key fault
            $message = "An account with those informations alredy exists.";
            break;
        default:
            $message = "We can't elaborate your request. try later.";
            break;
    }
    if($debugMessages){
        $message = $message."<br><br>[DEBUG]<br>Code: ".$registrationStatement->errno."<br>message: ".htmlspecialchars($registrationStatement->error);
    }
    registrationFailed($message);
}else{
    //buon fine
    setSuccessMessage("Registration complete.<br> now you can log in :-)");
    header('location: login.php');
}
$registrationStatement->close();
?>