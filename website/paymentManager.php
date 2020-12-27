<?php
require "sessionManager.php";
require "dbManager.php";


if (!isset($_POST['action'])) { // someone tried to skip a step
    resetBook();
    header("location: BrowseBook.php");
}

$action = $_POST['action'];

switch ($action) {
    case 'setItem':
        if (!isset($_POST['id'])) {
            resetBook();
            header("location: BrowseBook.php");
        }

        $id = $_POST['id'];
        setItem($id);
        break;
    case 'payItem':
        if (!isset($_POST['expireMonth']) && !isset($_POST['expireYear']) && !isset($_POST['cvv']) && !isset($_POST['cardNumber'])) {
            resetBook();
            header("location: BrowseBook.php");
        }

        $month = $_POST['expireMonth'];
        $year = $_POST['expireYear'];
        $cvv = $_POST['cvv'];
        $cardNumber = $_POST['cardNumber'];

        if (!checkCreditCard($month, $year, $cvv, $cardNumber)) {
            setErrorMessage("invalid Credit card :(");
            header('location: paymentPage.php');
        } else {
            payItem();
        }
        break;
    default:
        die('Access denied for this function!');
}

function setItem($id)
{
    setSessionBook($id);
}

function checkCreditCard($month, $year, $cvv, $cardNumber)
{
    date_default_timezone_set('Europe/Rome');
    $currentYear =  date("Y");
    $currentMonth =  date("m");

    //check year and month
    if (($year < $currentYear) || ($year == $currentYear && $month <= $currentMonth)) {
        return false;
    }

    //check cvv
    if (!preg_match("/^(\d\d\d)$/", $cvv)) {
        return false;
    }

    //check card number
    if (!preg_match("/^(\d\d\d\d \d\d\d\d \d\d\d\d \d\d\d\d)$/", $cardNumber)) {
        return false;
    }

    // all good
    return true;
}

function payItem()
{
    global $db;
    $conn = $db->getConn();

    date_default_timezone_set('Europe/Rome');
    $buyDate =  date("Y-m-d");

    $id_Buyer = getSessionUserId();
    $buyingItem = getSessionBook();

    $buymentStatement = $conn->prepare("INSERT INTO orders (id_buyer, id_ebook, date) VALUES (?, ?, ?)");
    $buymentStatement->bind_param("iis", $id_Buyer, $buyingItem, $buyDate);

    if ($buymentStatement->execute()) {
        $buymentStatement->close();
        resetSessionBook();
        setSuccessMessage("successful purchase, you can download the book from the profile section ;-)");
        header('location: index.php');
    } else {
        setErrorMessage($buymentStatement->error);
        $buymentStatement->close();
        header('location: paymentPage.php');
    }
}
