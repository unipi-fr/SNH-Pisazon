<?php
require_once "sessionManager.php";
require_once "dbManager.php";
require_once "passwordRecoveryLib.php";

$debugMessages = false;

if(isUserLogged()){
    header('location: index.php');
}

function registrationFailed($message, $statement, $debugMessages){
    if($debugMessages){
        $message = $message."<br><br>[DEBUG]<br>Code: ".$statement->errno."<br>message: ".htmlspecialchars($statement->error);
    }
    
    setErrorMessage($message);
    header('location: register.php');
}

function checkEmailValidity($taintedEmail){
    if (!preg_match("/^((([!#$%&'*+\-/=?^_`{|}~\w])|([!#$%&'*+\-/=?^_`{|}~\w][!#$%&'*+\-/=?^_`{|}~\.\w]{0,}[!#$%&'*+\-/=?^_`{|}~\w]))[@]\w+([-.]\w+)*\.\w+([-.]\w+)*)$/", $taintedEmail)) {
        return false;
    }
    return true;
}

global $db;

$taintedUsername = $_POST["username"];
$taintedEmail = $_POST["email"];

if(!checkEmailValidity($taintedEmail)){
    setErrorMessage("Please insert a valid email");
    header('location: register.php');
    die();
}

$conn = $db->getConn();

$username = $email = "";

$result = $registrationStatement = $conn->prepare("INSERT INTO user (username, email) VALUES (?, ?);");
if($result === false){
    registrationFailed($message, $registrationStatement, $debugMessages);
}

$result = $registrationStatement->bind_param("ss", $username, $email);
if($result === false){
    registrationFailed("We can't elaborate your request. try later.", $registrationStatement, $debugMessages);
}

$username = $taintedUsername;
$email = $taintedEmail;
$result = $registrationStatement->execute();
if ($result === false) {
    switch ($registrationStatement->errno){
        case 1062: //unique key fault
            $message = "Registration complete.<br> now you have to activate your account :-)<br><br>A mail has been sent to the email " . htmlspecialchars($email) . ".<br> Check your email for the link.";
            setSuccessMessage($successMessage);
            header('location: login.php');
            break;
        default:
            $message = "We can't elaborate your request. try later.";
            registrationFailed($message, $registrationStatement, $debugMessages);
            break;
    }
} else {
    //buon fine
    sendPasswordRecoveryEmail($taintedEmail);
    $successMessage = readSuccessMessage();
    setSuccessMessage("Registration complete.<br> now you have to activate your account :-)<br><br>".$successMessage);
    header('location: login.php');
}
$registrationStatement->close();
