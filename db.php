<?php
$host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'skillswap';

$conn = new mysqli($host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Database Connection Instability: " . $conn->connect_error);
}
?>