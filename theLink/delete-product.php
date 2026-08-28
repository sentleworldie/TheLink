<?php

include 'includes/auth.php';
include 'config/database.php';

$id = $_GET['id'];

$user_id = $_SESSION['user_id'];

$sql = "DELETE FROM products
        WHERE id='$id'
        AND user_id='$user_id'";

$conn->query($sql);

header("Location: my-products.php");
exit();

?>