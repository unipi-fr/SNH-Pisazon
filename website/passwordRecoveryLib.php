<?php
require_once "sessionManager.php";
require_once "dbManager.php";
require_once "mailSender.php";

$activateDebug = true;
$minutesOfValidity = 10;

function sendPasswordRecoveryEmail($taintedEmail, $type)
{
    global $activateDebug;
    $user = getUserForRecovery($taintedEmail);

    setSuccessMessage("A mail has been sent to the email " . htmlspecialchars($taintedEmail) . ".<br> Check your email for the link.");
    if ($user === false) {
        return;
    }

    $token = generateToken(64);
    $userId = $user["id"];
    $result = storeTokenForUser($token, $userId);
    if ($result === false) {
        return;
    }

    if(sendEmail($user["email"], $token, $type) === false){
        global $mailSenderMessage;
        setErrorMessage($mailSenderMessage);
        return;
    }
    if($activateDebug){
        $message = readSuccessMessage()."<br><br> Shhhhh.... don't tell to anyone but here is your link:<br> <a href='http://localhost/passwordReset.php?token=$token'>Password reset link!</a>";
        setSuccessMessage($message);
    }
}

function storeTokenForUser($token, $userId)
{ // controllare che non ci sia già un altro token
    global $db;
    global $activateDebug;
    global $minutesOfValidity;

    $conn = $db->getConn();

    $tokenValidity = "(CURRENT_TIMESTAMP() + INTERVAL ($minutesOfValidity) MINUTE)";
    $hashToken =  hash("sha512", $token);

    $insertUserTokenStatement = $conn->prepare("INSERT INTO tokens (id_user, expiration_date, hash_token) VALUES (?, $tokenValidity, ?) ON DUPLICATE KEY UPDATE expiration_date = $tokenValidity, hash_token = ?;");

    if ($insertUserTokenStatement === false) {
        return passwordRecoveryFailed("We can't elaborate your request, please try later.", $insertUserTokenStatement, $db, $activateDebug);
    }

    $result = $insertUserTokenStatement->bind_param("iss", $userId, $hashToken, $hashToken);
    if ($result === false) {
        return passwordRecoveryFailed("We can't elaborate your request, please try later.", $insertUserTokenStatement, $db, $activateDebug);
    }

    $result = $insertUserTokenStatement->execute();

    if ($result === false) {
        return passwordRecoveryFailed("We can't elaborate your request. try later.", $insertUserTokenStatement, $db, $activateDebug);
    }

    $insertUserTokenStatement->close();
    $db->closeConnection();

    return true;
}

function generateToken($charLenght)
{
    //Generate a random string.
    $token = openssl_random_pseudo_bytes($charLenght);

    //Convert the binary data into hexadecimal representation.
    $token = bin2hex($token);
    return $token;
}

function passwordRecoveryFailed($reason, $statement, $db, $activateDebug = false)
{
    if ($activateDebug && $statement !== null) {
        $reason = $reason . "<br><br>[DEBUG]<br>Code: " . $statement->errno . "<br>message: " . htmlspecialchars($statement->error);
    }

    setErrorMessage($reason);

    if ($statement !== null)
        $statement->close();

    $db->closeConnection();

    return false;
}


function getUserForRecovery($taintedEmail)
{     // prepared statement che controlla se l'email dell'utente di sessione corrisponde con quella inserita nel form
    global $db;
    global $activateDebug;

    $conn = $db->getConn();

    $getUserStatement = $conn->prepare("SELECT * FROM user WHERE email=?;");
    if ($getUserStatement === false) {
        return passwordRecoveryFailed("We can't elaborate your request, please try later.", $getUserStatement, $db, $activateDebug);
    }

    $result = $getUserStatement->bind_param("s", $taintedEmail);
    if ($result === false) {
        return passwordRecoveryFailed("We can't elaborate your request, please try later.", $getUserStatement, $db, $activateDebug);
    }

    $result = $getUserStatement->execute();
    if ($result === false) {
        return passwordRecoveryFailed("We can't elaborate your request. try later.", $getUserStatement, $db, $activateDebug);
    }

    $result = $getUserStatement->get_result();
    $getUserStatement->close();
    $db->closeConnection();

    if ($result->num_rows != 1) { // user not found
        return false;
    }

    $row = $result->fetch_assoc();
    return $row;
}
