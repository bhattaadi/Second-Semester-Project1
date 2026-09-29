<?php
session_start();
require '../config/db.php';
$page_title = "Manage Products | Admin";
include 'includes/admin_header.php';

$products = $conn->query("SELECT * FROM products ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="admin-topbar">
    <h4 class="fw-bold mb-0">Manage Products</h4>
    <a href="add_product.php" class="btn btn-veyro"><i class="bi bi-plus-lg me-1"></i>Add New Product</a>
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
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                    <tr>
                        <td><img src="../images/<?php echo htmlspecialchars($p['image']); ?>" width="45" height="55" style="object-fit:cover;border-radius:3px;"></td>
                        <td><?php echo htmlspecialchars($p['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($p['category']); ?></td>
                        <td>Rs. <?php echo number_format($p['price'], 2); ?></td>
                        <td><?php echo $p['stock']; ?></td>
                        <td>
                            <a href="edit_product.php?id=<?php echo $p['id']; ?>" class="btn btn-sm btn-outline-dark"><i class="bi bi-pencil"></i></a>
                            <a href="delete_product.php?id=<?php echo $p['id']; ?>" class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Delete this product permanently?');"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (count($products) === 0): ?>
                    <tr><td colspan="6" class="text-center text-muted">No products found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>
