<?php
session_start();
require '../config/db.php';
$page_title = "Dashboard | Admin";
include 'includes/admin_header.php';

$totalProducts = $conn->query("SELECT COUNT(*) FROM products")->fetchColumn();
$totalOrders   = $conn->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$totalUsers    = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalRevenue  = $conn->query("SELECT SUM(total_price) FROM orders WHERE order_status != 'Cancelled'")->fetchColumn();

$recentOrders = $conn->query("SELECT o.*, p.product_name FROM orders o
                               JOIN products p ON o.product_id = p.id
                               ORDER BY o.order_date DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="admin-topbar">
    <h4 class="fw-bold mb-0">Dashboard</h4>
    <span class="text-muted">Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <p>Total Products</p>
            <h3><?php echo $totalProducts; ?></h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <p>Total Orders</p>
            <h3><?php echo $totalOrders; ?></h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <p>Registered Users</p>
            <h3><?php echo $totalUsers; ?></h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <p>Total Revenue</p>
            <h3>Rs. <?php echo number_format($totalRevenue ?: 0, 2); ?></h3>
        </div>
    </div>
</div>

<div class="table-card">
    <h5 class="fw-bold mb-3">Recent Orders</h5>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Customer</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentOrders as $o): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($o['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($o['customer_name']); ?></td>
                        <td><?php echo $o['quantity']; ?></td>
                        <td>Rs. <?php echo number_format($o['total_price'], 2); ?></td>
                        <td><span class="badge bg-secondary"><?php echo $o['order_status']; ?></span></td>
                        <td class="small"><?php echo date("d M Y", strtotime($o['order_date'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <a href="orders.php" class="btn btn-veyro-outline btn-sm">View All Orders</a>
</div>

<?php include 'includes/admin_footer.php'; ?>
