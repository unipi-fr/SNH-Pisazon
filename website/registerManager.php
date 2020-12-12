<?php 
session_start();
require "dbManager.php";
require "sessionManager.php";

if(isUserLogged()){
    header('location: index.php');
}

$conn = $db->getConn();

$username = $email = $hash_pass = "";

$registrationStatement = $conn->prepare("INSERT INTO user (username, email, hash_pass) VALUES (?, ?, ?)");
$registrationStatement->bind_param("sss", $username, $email, $hash_pass);

$taintedUsername = $_POST["username"];
$taintedPassword = $_POST["password"];
$taintedEmail = $_POST["email"];

$username = $taintedUsername;
$email = $taintedEmail;
$hash_pass = password_hash($taintedPassword, PASSWORD_DEFAULT);
if($registrationStatement->execute()){
    //buon fine
    header('location: index.php');
}else{
    header('location: register.php');
}

$registrationStatement->close();
?>