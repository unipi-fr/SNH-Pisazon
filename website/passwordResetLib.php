<?php
require_once "sessionManager.php";
require_once "dbManager.php";

$activateDebug = false;

function checkValidToken($taintedToken)
{
  global $db;
  global $activateDebug;

  $conn = $db->getConn();
  $hashToken =  hash("sha512", $taintedToken);

  $checkTokenStatement = $conn->prepare("SELECT * from tokens WHERE expiration_date > CURRENT_TIMESTAMP() AND hash_token = ?;");
  if ($checkTokenStatement === false) {
    return passwordResetFailed("We can't elaborate your request, please try later.", $checkTokenStatement, $db, $activateDebug);
  }

  $result = $checkTokenStatement->bind_param("s", $hashToken);
  if ($result === false) {
    return passwordResetFailed("We can't elaborate your request, please try later.", $checkTokenStatement, $db, $activateDebug);
  }

  $result = $checkTokenStatement->execute();
  if ($result === false) {
    return passwordResetFailed("We can't elaborate your request. try later.", $checkTokenStatement, $db, $activateDebug);
  }

  $result = $checkTokenStatement->get_result();
  $checkTokenStatement->close();
  $db->closeConnection();

  if ($result->num_rows != 1) { // user not found
    resetSessionTokenUserId();
    setErrorMessage("Token invalid or expired.");
    return false;
  }

  $row = $result->fetch_assoc();
  $userId = $row['id_user'];

  #setSuccessMessage("you have inserted a beautifull token for user:<br>$userId");
  setSessionTokenUserId($userId);
}

function deleteUserToken($idUser)
{
  global $db;
  global $activateDebug;

  $conn = $db->getConn();

  $deleteTokenStatement = $conn->prepare("DELETE from tokens WHERE id_user = ?;");
  if ($deleteTokenStatement === false) {
    return passwordResetFailed("We can't elaborate your request, please try later.", $deleteTokenStatement, $db, $activateDebug);
  }

  $result = $deleteTokenStatement->bind_param("i", $idUser);
  if ($result === false) {
    return passwordResetFailed("We can't elaborate your request, please try later.", $deleteTokenStatement, $db, $activateDebug);
  }

  $result = $deleteTokenStatement->execute();
  if ($result === false) {
    return passwordResetFailed("We can't elaborate your request. try later.", $deleteTokenStatement, $db, $activateDebug);
  }

  $deleteTokenStatement->close();
  $db->closeConnection();
}


function passwordResetFailed($reason, $statement, $db, $activateDebug = false)
{
  if ($activateDebug && $statement !== null) {
    $reason = $reason . "<br><br>[DEBUG]<br>Code: " . $statement->errno . "<br>message: " . htmlspecialchars($statement->error);
  }

  setErrorMessage($reason);

  if ($statement !== null)
    $statement->close();

  $db->closeConnection();
  resetSessionTokenUserId();
  return false;
}

function changePassword($idUser, $newPass)
{
  global $db;
  global $activateDebug;

  $conn = $db->getConn();

  $updateStatement = $conn->prepare("UPDATE user SET hash_pass = ?, attempts = 0, locked_until = CURRENT_TIMESTAMP() WHERE id = ?;");

  if ($updateStatement === false) {
    return passwordRecoveryFailed("We can't elaborate your request. try later.", $updateStatement, $db, $activateDebug);
  }

  $hashNewPass = password_hash($newPass, PASSWORD_DEFAULT);
  $result = $updateStatement->bind_param("si", $hashNewPass, $idUser);
  if ($result === false) {
    return passwordRecoveryFailed("We can't elaborate your request. try later.", $updateStatement, $db, $activateDebug);
  }

  $result = $updateStatement->execute();

  $updateStatement->close();

  $db->closeConnection();

  if ($result === false) {
    return passwordRecoveryFailed("We can't elaborate your request. try later.", $updateStatement, $db, $activateDebug);
  }

  setSuccessMessage("Password changed.");
  return true;
}

function changePasswordAndResetToken($taintedPassword)
{
  $userId = getSessionTokenUserId();
  resetSessionTokenUserId();
  $ret = changePassword($userId, $taintedPassword);
  deleteUserToken($userId);
  return $ret;
}
