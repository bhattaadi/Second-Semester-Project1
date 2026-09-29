<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
if (!isset($page_title)) {
    $page_title = "Admin Panel | VEYRO";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body { background-color: #f4f4f2; }
        .admin-wrapper { display: flex; min-height: 100vh; }
        .admin-sidebar {
            width: 230px;
            background-color: var(--veyro-black);
            color: #fff;
            flex-shrink: 0;
        }
        .admin-sidebar .brand {
            padding: 22px 20px;
            font-weight: 700;
            letter-spacing: 4px;
            font-size: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .admin-sidebar .brand span { color: var(--veyro-gold); }
        .admin-sidebar a {
            display: block;
            padding: 13px 22px;
            color: #cfcfcf;
            font-size: 14px;
            transition: all 0.25s ease;
            border-left: 3px solid transparent;
        }
        .admin-sidebar a:hover, .admin-sidebar a.active {
            background: rgba(255,255,255,0.05);
            color: var(--veyro-gold);
            border-left: 3px solid var(--veyro-gold);
        }
        .admin-content { flex-grow: 1; padding: 30px; }
        .admin-topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        .stat-card {
            background: #fff;
            border-radius: 6px;
            padding: 22px;
            border: 1px solid #eee;
        }
        .stat-card h3 { font-weight: 700; margin-bottom: 0; }
        .stat-card p { color: #888; margin-bottom: 6px; font-size: 13px; letter-spacing: 1px; text-transform: uppercase; }
        .table-card { background: #fff; border-radius: 6px; padding: 22px; border: 1px solid #eee; }
    </style>
</head>
<body>
<div class="admin-wrapper">
    <aside class="admin-sidebar">
        <div class="brand">VE<span>Y</span>RO <small style="font-size:11px; letter-spacing:1px; display:block; color:#999;">ADMIN PANEL</small></div>
        <nav>
            <a href="dashboard.php"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
            <a href="products.php"><i class="bi bi-bag me-2"></i>Products</a>
            <a href="orders.php"><i class="bi bi-receipt me-2"></i>Orders</a>
            <a href="../index.php" target="_blank"><i class="bi bi-box-arrow-up-right me-2"></i>View Site</a>
            <a href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
        </nav>
    </aside>
    <main class="admin-content">
