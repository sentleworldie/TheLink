<?php

include '../includes/admin-auth.php';
include '../config/database.php';

$id = $_GET['id'];

$conn->query("DELETE FROM products WHERE id='$id'");

header("Location: products.php");

?>