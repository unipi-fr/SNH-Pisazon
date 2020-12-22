<?php
require "sessionManager.php";
require "dbManager.php";

$action = $_POST['action'];

switch ($action) {
    case 'setItem':
        $id = $_POST['id'];
        setItem($id);
        break;
    case 'payItem':
        $month = $_POST['expireMonth'];
        $year = $_POST['expireYear'];
        if (!checkCreditCard($month, $year)) {
            setErrorMessage("Credit card EXPIRED :(");
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
    $_SESSION['buyingItem'] = $id;
}

function checkCreditCard($month, $year)
{
    date_default_timezone_set('Europe/Rome');
    $currentYear =  date("Y");
    $currentMonth =  date("m");

    if (($year < $currentYear) || ($year == $currentYear && $month <= $currentMonth)) {
        return false;
    }

    return true;
}

function payItem()
{
    global $db;
    $conn = $db->getConn();

    date_default_timezone_set('Europe/Rome');
    $buyDate =  date("Y-m-d");

    $price = '60';

    $buymentStatement = $conn->prepare("INSERT INTO orders (id_buyer, id_ebook, date, price) VALUES (?, ?, ?, ?)");
    $buymentStatement->bind_param("ssss", $_SESSION['idUser'], $_SESSION['buyingItem'], $buyDate, $price);

    if ($buymentStatement->execute()) {
        $buymentStatement->close();
        setSuccessMessage("successful purchase, you can download the book from the profile section ;-)");
        header('location: index.php');
    } else {
        setErrorMessage($buymentStatement->error);
        $buymentStatement->close();
        header('location: paymentPage.php');
    }
}
