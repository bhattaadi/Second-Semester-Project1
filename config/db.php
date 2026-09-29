<?php
// Database connection - VEYRO E-commerce
// TU BCA 2nd Year Project

$db_host = "localhost";
$db_name = "veyro_db";
$db_user = "root";
$db_pass = "";

try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
