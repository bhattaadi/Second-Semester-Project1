<?php
session_start();
require '../config/db.php';
$page_title = "Manage Orders | Admin";

// Update order status (part of CRUD - Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $update = $conn->prepare("UPDATE orders SET order_status = :status WHERE id = :id");
    $update->execute([
        ':status' => $_POST['order_status'],
        ':id'     => $_POST['order_id']
    ]);
    $_SESSION['admin_msg'] = "Order status updated.";
    header("Location: orders.php");
    exit;
}

include 'includes/admin_header.php';

$orders = $conn->query("SELECT o.*, p.product_name, p.image
                         FROM orders o
                         JOIN products p ON o.product_id = p.id
                         ORDER BY o.order_date DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="admin-topbar">
    <h4 class="fw-bold mb-0">Manage Orders</h4>
</div>

<?php if (isset($_SESSION['admin_msg'])): ?>
    <div class="alert alert-success veyro-alert alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['admin_msg']; unset($_SESSION['admin_msg']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="table-card">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Customer</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $o): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($o['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($o['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars($o['phone']); ?></td>
                        <td class="small"><?php echo htmlspecialchars($o['address']); ?></td>
                        <td><?php echo $o['quantity']; ?></td>
                        <td>Rs. <?php echo number_format($o['total_price'], 2); ?></td>
                        <td>
                            <form method="POST" class="d-flex gap-1">
                                <input type="hidden" name="order_id" value="<?php echo $o['id']; ?>">
                                <select name="order_status" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <?php foreach (['Pending', 'Confirmed', 'Delivered', 'Cancelled'] as $status): ?>
                                        <option value="<?php echo $status; ?>" <?php echo $o['order_status'] === $status ? 'selected' : ''; ?>>
                                            <?php echo $status; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </form>
                        </td>
                        <td class="small"><?php echo date("d M Y", strtotime($o['order_date'])); ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (count($orders) === 0): ?>
                    <tr><td colspan="8" class="text-center text-muted">No orders yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>
