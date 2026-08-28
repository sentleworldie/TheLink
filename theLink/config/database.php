<?php

$host = "sql112.infinityfree.com";
$username = "if0_42077883";
$password = "fks3zlqrkLC60J";
$database = "if0_42077883_thelink";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

?>