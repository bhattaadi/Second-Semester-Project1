<?php
session_start();
require 'config/db.php';
$page_title = "Shop | VEYRO";
include 'includes/header.php';

// ---- Filter by category (comes from sidebar / footer links) ----
$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$search   = isset($_GET['search']) ? trim($_GET['search']) : '';

$sql = "SELECT * FROM products WHERE 1=1";
$params = [];

if ($category !== '') {
    $sql .= " AND category = :category";
    $params[':category'] = $category;
}
if ($search !== '') {
    $sql .= " AND product_name LIKE :search";
    $params[':search'] = "%$search%";
}

$sql .= " ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="page-banner">
    <?php echo $category !== '' ? htmlspecialchars($category) : 'Shop All Products'; ?>
</div>

<div class="container my-5">

    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
            <form method="GET" class="d-flex">
                <input type="text" name="search" class="form-control" placeholder="Search products..."
                       value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-veyro ms-2" type="submit"><i class="bi bi-search"></i></button>
            </form>
        </div>
    </div>

    <?php if (isset($_SESSION['order_msg'])): ?>
        <div class="alert alert-success veyro-alert alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['order_msg']; unset($_SESSION['order_msg']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-9 order-2 order-lg-1">
            <div class="row g-4">
                <?php if (count($products) === 0): ?>
                    <p class="text-center text-muted">No products found.</p>
                <?php endif; ?>

                <?php foreach ($products as $p): ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-img-wrap">
                                <img src="images/<?php echo htmlspecialchars($p['image']); ?>" alt="<?php echo htmlspecialchars($p['product_name']); ?>">
                            </div>
                            <div class="product-body">
                                <div class="product-category"><?php echo htmlspecialchars($p['category']); ?></div>
                                <div class="product-name"><?php echo htmlspecialchars($p['product_name']); ?></div>
                                <p class="small text-muted mb-2" style="min-height:40px;">
                                    <?php echo htmlspecialchars(mb_strimwidth($p['description'], 0, 60, '...')); ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="product-price">Rs. <?php echo number_format($p['price'], 2); ?></span>
                                    <?php if ($p['stock'] <= 0): ?>
                                        <span class="badge bg-danger">Out of stock</span>
                                    <?php else: ?>
                                        <span class="badge bg-light text-dark"><?php echo $p['stock']; ?> left</span>
                                    <?php endif; ?>
                                </div>
                                <?php if ($p['stock'] > 0): ?>
                                    <a href="order.php?id=<?php echo $p['id']; ?>" class="btn btn-veyro w-100 mt-3">Order Now</a>
                                <?php else: ?>
                                    <button class="btn btn-veyro w-100 mt-3" disabled>Out of Stock</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-lg-3 order-1 order-lg-2 mb-4 mb-lg-0">
            <?php include 'includes/sidebar.php'; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
