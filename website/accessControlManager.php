<?php

require_once "dbManager.php";

function isAuthorizedToDownloadThisBook($user, $book)
{
    global $db;

    $conn = $db->getConn();
    $bookStatement = $conn->prepare("SELECT * FROM orders WHERE id_buyer = ? and id_ebook = ?");
    $bookStatement->bind_param("ii", $user, $book);

    if (!$bookStatement->execute())
        return false;

    $result = $bookStatement->get_result();

    $num_of_rows = $result->num_rows;

    if ($num_of_rows <= 0)
        return false;

    $bookStatement->free_result();

    $bookStatement->close();
    return true;
}
