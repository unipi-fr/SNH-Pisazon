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
        payItem();
        break;
    default:
        die('Access denied for this function!');
}

function setItem($id)
{
    $_SESSION['buyingItem'] = $id;
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

    if($buymentStatement->execute()){
        $buymentStatement->close();
        header('location: index.php');
    }else{
        $_SESSION["errorMessage"] = $buymentStatement->error;
        $buymentStatement->close();
        header('location: paymentPage.php');
    }
}
