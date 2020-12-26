<?php

include "accessControlManager.php";
include "sessionManager.php";

$userId = getSessionUserId();

if (!isset($_GET['book'])) {
    setErrorMessage("The resource could not exist or you can't access it");
    header('location: ./browseBook.php');
}

$book = $_GET['book'];

if (!isAuthorizedToDownloadThisBook($userId, $book)) {
    setErrorMessage("The resource could not exist or you can't access it");
    header('location: ./browseBook.php');
}

$fullPath = 'C:/Users/nella/Documents/GitHub/SNH-Pisazon/ebook/ebook2.pdf'; // this should be $filename = "ebook/ebook$book.pdf";
$filename = '../ebook/ebook2.pdf';

if (file_exists($fullPath)) {
    header('Content-Length: ' . filesize($file));
    header("Content-type: application/pdf");
    header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
    header("X-Sendfile: " . $filename);
    
} else {
    setErrorMessage("The resource could not exist or you can't access it");
    header('location: ./browseBook.php');
}
