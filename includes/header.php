<?php
// header.php is included by every page AFTER session_start() and db.php
if (!isset($page_title)) {
    $page_title = "VEYRO | Wear Your Vision";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- ============================ HEADER ============================ -->
<header class="veyro-header">
    <div class="container d-flex align-items-center justify-content-between">

        <a href="index.php" class="veyro-logo">VE<span>Y</span>RO</a>

        <nav>
            <ul class="veyro-nav d-none d-lg-flex">
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="myorders.php">My Orders</a></li>
                <?php endif; ?>
            </ul>
        </nav>

        <div class="d-flex align-items-center">
            <?php if (isset($_SESSION['user_id'])): ?>
                <span class="text-white small d-none d-md-inline me-2">
                    Hi, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                </span>
                <a href="logout.php" class="icon-link" title="Logout"><i class="bi bi-box-arrow-right"></i></a>
            <?php else: ?>
                <a href="login.php" class="icon-link" title="Login / Register"><i class="bi bi-person"></i></a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Mobile nav -->
    <div class="container d-lg-none mt-2">
        <ul class="veyro-nav">
            <li><a href="index.php">Home</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="myorders.php">Orders</a></li>
            <?php endif; ?>
        </ul>
    </div>
</header>
<!-- ========================== END HEADER =========================== -->
