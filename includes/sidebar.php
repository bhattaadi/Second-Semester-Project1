<?php
// sidebar.php needs $conn (from config/db.php) to load categories
$catStmt = $conn->query("SELECT category, COUNT(*) as total FROM products GROUP BY category ORDER BY category ASC");
$categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);

$activeCategory = isset($_GET['category']) ? $_GET['category'] : '';
?>
<div class="veyro-sidebar">
    <h5>Categories</h5>
    <div class="list-group">
        <a href="products.php" class="list-group-item sidebar-category-link <?php echo $activeCategory === '' ? 'active-category' : ''; ?>">
            All Products
        </a>
        <?php foreach ($categories as $cat): ?>
            <a href="products.php?category=<?php echo urlencode($cat['category']); ?>"
               class="list-group-item sidebar-category-link <?php echo $activeCategory === $cat['category'] ? 'active-category' : ''; ?>">
                <?php echo htmlspecialchars($cat['category']); ?>
                <span class="badge bg-light text-dark"><?php echo $cat['total']; ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<div class="sidebar-promo">
    <h6>Big Sale</h6>
    <p class="small mb-2">Up to 50% off on your favourite styles. For less.</p>
    <a href="products.php" class="btn btn-veyro-outline btn-sm" style="border-color:#fff;color:#fff;">Shop Now</a>
</div>
