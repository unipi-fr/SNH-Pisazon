<?php
session_start();

$action = $_POST['action'];

switch ($action) {
    case 'addItem':
        $id = $_POST['id'];
        addItem($id);
        break;
    case 'deleteItem':
        $id = $_POST['id'];
        deleteItem($id);
        break;
    default:
        die('Access denied for this function!');
}

function addItem($id)
{
    $_SESSION['cart'][] = $id;
    echo "Added to the cart";
}

function deleteItem($id){
    if (($key = array_search($id, $_SESSION['cart'])) !== false) {
        unset($_SESSION['cart'][$key]);
        echo "Removed from the cart";
    }
}

?>
