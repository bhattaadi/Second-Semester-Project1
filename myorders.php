<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $conn->prepare("SELECT o.*, p.product_name, p.image
                         FROM orders o
                         JOIN products p ON o.product_id = p.id
                         WHERE o.user_id = :user_id
                         ORDER BY o.order_date DESC");
$stmt->execute([':user_id' => $_SESSION['user_id']]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

$page_title = "My Orders | VEYRO";
include 'includes/header.php';
?>

<div class="page-banner">My Orders</div>

<div class="container my-5">

    <?php if (isset($_SESSION['order_msg'])): ?>
        <div class="alert alert-success veyro-alert alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['order_msg']; unset($_SESSION['order_msg']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (count($orders) === 0): ?>
        <div class="text-center py-5">
            <p class="text-muted">You haven't placed any orders yet.</p>
            <a href="products.php" class="btn btn-veyro">Start Shopping</a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Delivery Address</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $o): ?>
                        <tr>
                            <td class="d-flex align-items-center gap-2">
                                <img src="images/<?php echo htmlspecialchars($o['image']); ?>" width="45" height="55" style="object-fit:cover;border-radius:3px;">
                                <?php echo htmlspecialchars($o['product_name']); ?>
                            </td>
                            <td><?php echo $o['quantity']; ?></td>
                            <td>Rs. <?php echo number_format($o['total_price'], 2); ?></td>
                            <td class="small"><?php echo htmlspecialchars($o['address']); ?></td>
                            <td>
                                <?php
                                $badge = "secondary";
                                if ($o['order_status'] === "Pending") $badge = "warning";
                                if ($o['order_status'] === "Confirmed") $badge = "info";
                                if ($o['order_status'] === "Delivered") $badge = "success";
                                if ($o['order_status'] === "Cancelled") $badge = "danger";
                                ?>
                                <span class="badge bg-<?php echo $badge; ?>"><?php echo $o['order_status']; ?></span>
                            </td>
                            <td class="small"><?php echo date("d M Y", strtotime($o['order_date'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
