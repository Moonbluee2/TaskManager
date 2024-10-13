<?php
$conn = new mysqli("localhost", "root", "GOmita02", "TaskManager");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Conexión exitosa!";
?>