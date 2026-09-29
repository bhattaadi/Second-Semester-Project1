<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $delete = $conn->prepare("DELETE FROM products WHERE id = :id");
    $delete->execute([':id' => $id]);
    $_SESSION['admin_msg'] = "Product deleted successfully.";
}

header("Location: products.php");
exit;
?>
