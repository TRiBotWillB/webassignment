<?php

$servername = "localhost";
$database = "imger";
$username = "root";
$password = "root";


$conn = new mysqli($servername, $username, $password, $database);

if($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}