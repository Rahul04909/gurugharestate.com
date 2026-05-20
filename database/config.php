<?php
$host = 'localhost';
$username = 'mineib_i1_mineib';
$password = 'Rd14072003@./';
$database = 'mineib_i1_gurugharestate';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>