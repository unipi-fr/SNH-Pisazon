<?php 
session_start();

function isUserLogged(){
    return isset($_SESSION['username']);
}

function logout()
{
	session_unset();
	header('location: index.php');
}




?>
