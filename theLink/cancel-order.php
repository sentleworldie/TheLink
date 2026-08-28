<?php

include 'includes/auth.php';
include 'config/database.php';

$order_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

/* Only allow buyer to cancel their own order */
$order = $conn->query("
    SELECT * FROM orders
    WHERE id='$order_id'
    AND buyer_id='$user_id'
");

if($order->num_rows == 0)
{
    die("Unauthorized action.");
}

$data = $order->fetch_assoc();

/* Only pending orders can be cancelled */
if($data['status'] != 'pending')
{
    die("You can only cancel pending orders.");
}

/* Update order */
$conn->query("
    UPDATE orders
    SET status='cancelled'
    WHERE id='$order_id'
");

/* Return product to marketplace */
$conn->query("
    UPDATE products
    SET status='available'
    WHERE id='{$data['product_id']}'
");

header("Location: my-orders.php");
exit();

?>