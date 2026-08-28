<?php

include '../includes/admin-auth.php';
include '../config/database.php';

$id = $_GET['id'];

$conn->query("DELETE FROM users WHERE id='$id'");

header("Location: users.php");

?>