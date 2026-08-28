<?php

include '../includes/admin-auth.php';
include '../config/database.php';
include '../includes/header.php';

$id = $_GET['id'];
$status = $_GET['status'];

$conn->query(
    "UPDATE orders
     SET status='$status'
     WHERE id='$id'"
);

if($status == 'completed')
{
    $order = $conn->query(
        "SELECT product_id
         FROM orders
         WHERE id='$id'"
    );

    $row = $order->fetch_assoc();

    $product_id = $row['product_id'];

    $conn->query(
        "UPDATE products
         SET status='sold'
         WHERE id='$product_id'"
    );
}

header("Location: orders.php");

?>