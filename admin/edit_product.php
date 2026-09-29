<?php
session_start();
require '../config/db.php';
$page_title = "Edit Product | Admin";
include 'includes/admin_header.php';

if (!isset($_GET['id'])) {
    header("Location: products.php");
    exit;
}

$id = (int) $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
$stmt->execute([':id' => $id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header("Location: products.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = trim($_POST['product_name']);
    $category     = trim($_POST['category']);
    $price        = $_POST['price'];
    $stock        = $_POST['stock'];
    $description  = trim($_POST['description']);
    $image_name   = $product['image']; // keep old image by default

    // Replace image only if a new one was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            $image_name = "product_" . time() . "." . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], "../images/" . $image_name);
        } else {
            $error = "Only JPG, JPEG, PNG or WEBP images are allowed.";
        }
    }

    if ($error === "") {
        $update = $conn->prepare("UPDATE products SET
            product_name = :product_name,
            category = :category,
            price = :price,
            stock = :stock,
            description = :description,
            image = :image
            WHERE id = :id");
        $update->execute([
            ':product_name' => $product_name,
            ':category'     => $category,
            ':price'        => $price,
            ':stock'        => $stock,
            ':description'  => $description,
            ':image'        => $image_name,
            ':id'           => $id
        ]);

        $_SESSION['admin_msg'] = "Product updated successfully.";
        header("Location: products.php");
        exit;
    }
}
?>

<div class="admin-topbar">
    <h4 class="fw-bold mb-0">Edit Product</h4>
    <a href="products.php" class="btn btn-veyro-outline btn-sm">Back to Products</a>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger veyro-alert"><?php echo $error; ?></div>
<?php endif; ?>

<div class="table-card">
    <form method="POST" enctype="multipart/form-data" class="row g-3">
        <div class="col-md-3">
            <img src="../images/<?php echo htmlspecialchars($product['image']); ?>" class="img-fluid rounded">
        </div>
        <div class="col-md-9">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="product_name" class="form-control" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Category</label>
                    <input type="text" name="category" class="form-control" value="<?php echo htmlspecialchars($product['category']); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Price (Rs.)</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="<?php echo $product['price']; ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Stock Quantity</label>
                    <input type="number" name="stock" class="form-control" value="<?php echo $product['stock']; ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Replace Image (optional)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                </div>
            </div>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-veyro">Update Product</button>
        </div>
    </form>
</div>

<?php include 'includes/admin_footer.php'; ?>
