<?php
require "sessionManager.php";
require "dbManager.php";

$pageSize = 8;

function getHowManyPages()
{
    global $db;
    global $pageSize;

    $queryText = 'SELECT count(*) as count FROM ebook';
    $result = $db->performQuery($queryText);
    if ($result->num_rows < 0) {
        return 0;
    }

    $row = $result->fetch_assoc();
    return ceil($row['count']/$pageSize);
}

function getBooks($page){
    global $pageSize;
    global $db;

    $books = array();

    $offset = $pageSize * ($page - 1);

    $queryText = 'SELECT * FROM pisazon.ebook limit ' . $pageSize . ' offset ' . $offset;

    $result = $db->performQuery($queryText);
    if ($result->num_rows < 0) {
        return $books;
    }

    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }

    return $books;
}
