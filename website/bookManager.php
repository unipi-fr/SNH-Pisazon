<?php
require "sessionManager.php";
require "dbManager.php";

$pageSize = 8;

function getHowManyPages($filter)
{
    global $db;
    global $pageSize;

    $filter = '%' . $filter . '%';

    $conn = $db->getConn();
    $bookStatement = $conn->prepare("SELECT count(*) as count FROM ebook where title like ?");
    $bookStatement->bind_param("s", $filter);

    if (!$bookStatement->execute())
        return 0;

    $result = $bookStatement->get_result();

    $num_of_rows = $result->num_rows;

    if ($num_of_rows <= 0)
        return 0;

    $row = $result->fetch_assoc();

    $bookStatement->free_result();

    $bookStatement->close();
    return ceil($row['count'] / $pageSize);
}

function getHowManyPagesBuyed()
{
    global $db;
    global $pageSize;

    $idBuyer = getSessionUserId();

    $conn = $db->getConn();
    $bookStatement = $conn->prepare("SELECT count(*) as count FROM orders where id_buyer = ?");
    $bookStatement->bind_param("i", $idBuyer);

    if (!$bookStatement->execute())
        return 0;

    $result = $bookStatement->get_result();

    $num_of_rows = $result->num_rows;

    if ($num_of_rows <= 0)
        return 0;

    $row = $result->fetch_assoc();

    $bookStatement->free_result();

    $bookStatement->close();
    return ceil($row['count'] / $pageSize);
}

function getBooks($page, $filter)
{
    global $pageSize;
    global $db;

    $filter = '%' . $filter . '%';

    $books = array();

    if ($page < 0)
        return $books;

    $offset = $pageSize * ($page - 1);

    $conn = $db->getConn();
    $bookStatement = $conn->prepare("SELECT * FROM pisazon.ebook WHERE title like ? limit ? offset ?");
    $bookStatement->bind_param("sii", $filter, $pageSize, $offset);

    if ($bookStatement->execute()) {

        $result = $bookStatement->get_result();

        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }

        $bookStatement->free_result();

        $bookStatement->close();
    }

    return $books;
}

function getBuyedBooks($page)
{
    global $pageSize;
    global $db;

    $books = array();

    if ($page < 0)
        return $books;

    $offset = $pageSize * ($page - 1);

    $conn = $db->getConn();

    $idBuyer = getSessionUserId();
    $bookStatement = $conn->prepare("SELECT eb.* FROM orders as o JOIN ebook as eb on o.id_ebook = eb.id WHERE o.id_buyer = ? limit ? offset ?");
    $bookStatement->bind_param("sii", $idBuyer, $pageSize, $offset);

    if ($bookStatement->execute()) {

        $result = $bookStatement->get_result();

        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }

        $bookStatement->free_result();

        $bookStatement->close();
    }

    return $books;
}
