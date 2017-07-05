<?php


$conn = new mysqli("localhost", "admin", "pwd", "dhub");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
