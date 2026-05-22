<?php
require_once '../database/config.php';

$sql = "CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) DEFAULT NULL,
    image_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'gallery' created successfully or already exists.<br>";
} else {
    die("Error creating table: " . $conn->error);
}

$conn->close();
?>
