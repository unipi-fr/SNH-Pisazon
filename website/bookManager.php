<?php
require_once "sessionManager.php";
require_once "dbManager.php";

$pageSize = 8;

function getHowManyPages($titleFilter = "", $userFilter = -1)
{
    global $db;
    global $pageSize;

    $idBuyer = -1;
    if(isUserLogged()){
        $idBuyer = getSessionUserId();
    }

    $titleFilter = '%' . $titleFilter . '%';

    $conn = $db->getConn();
    $bookStatement = $conn->prepare("SELECT count(*) as count
        FROM ebook AS e
        LEFT OUTER JOIN (SELECT * FROM orders where id_buyer = ?) AS o ON e.id = o.id_ebook
        WHERE title like ? 
        AND (-1 = ? OR o.id_buyer = ?)");
    $bookStatement->bind_param("isii", $idBuyer, $titleFilter, $userFilter, $idBuyer);

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

function getBooks($page, $titleFilter = "", $userFilter = -1)
{
    global $pageSize;
    global $db;

    $idBuyer = -1;
    if(isUserLogged()){
        $idBuyer = getSessionUserId();
    }

    $titleFilter = '%' . $titleFilter . '%';
    $books = array();

    if ($page < 0)
        return $books;

    $offset = $pageSize * ($page - 1);

    $conn = $db->getConn();
    $bookStatement = $conn->prepare("SELECT e.*, o.id_buyer
        FROM ebook AS e
        LEFT OUTER JOIN (SELECT * FROM orders where id_buyer = ?) AS o ON e.id = o.id_ebook
        WHERE title like ? 
        AND (-1 = ? OR o.id_buyer = ?)
        LIMIT ?
        OFFSET ?");
    $bookStatement->bind_param("isiiii", $idBuyer, $titleFilter, $userFilter ,$idBuyer, $pageSize, $offset);

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