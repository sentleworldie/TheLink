<?php

include 'includes/auth.php';
include 'config/database.php';

$order_id = $_GET['id'];

$conn->query(
"UPDATE orders
 SET status='accepted'
 WHERE id='$order_id'"
);

$order = $conn->query(
"SELECT product_id
 FROM orders
 WHERE id='$order_id'"
);

$row = $order->fetch_assoc();

$product_id = $row['product_id'];

$conn->query(
"UPDATE products
 SET status='sold'
 WHERE id='$product_id'"
);

header("Location: my-products.php");

?>