<?php
session_start();
require 'config/db.php';

// Must be logged in to place an order
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = "order.php?id=" . (isset($_GET['id']) ? $_GET['id'] : '');
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: products.php");
    exit;
}

$product_id = (int) $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
$stmt->execute([':id' => $product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header("Location: products.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = trim($_POST['customer_name']);
    $phone         = trim($_POST['phone']);
    $address       = trim($_POST['address']);
    $quantity      = (int) $_POST['quantity'];

    if ($quantity < 1) $quantity = 1;

    if ($quantity > $product['stock']) {
        $error = "Only " . $product['stock'] . " item(s) left in stock.";
    } else {
        $total_price = $quantity * $product['price'];

        // Insert order (Create - part of CRUD)
        $insert = $conn->prepare("INSERT INTO orders
            (user_id, product_id, quantity, total_price, customer_name, phone, address)
            VALUES (:user_id, :product_id, :quantity, :total_price, :customer_name, :phone, :address)");
        $insert->execute([
            ':user_id'       => $_SESSION['user_id'],
            ':product_id'    => $product['id'],
            ':quantity'      => $quantity,
            ':total_price'   => $total_price,
            ':customer_name' => $customer_name,
            ':phone'         => $phone,
            ':address'       => $address
        ]);

        // Reduce stock (Update - part of CRUD)
        $update = $conn->prepare("UPDATE products SET stock = stock - :qty WHERE id = :id");
        $update->execute([':qty' => $quantity, ':id' => $product['id']]);

        $_SESSION['order_msg'] = "Your order for " . htmlspecialchars($product['product_name']) . " has been placed successfully!";
        header("Location: myorders.php");
        exit;
    }
}

$page_title = "Order Now | VEYRO";
include 'includes/header.php';
?>

<div class="page-banner">Order Now</div>

<div class="container my-5">
    <div class="row g-5 justify-content-center">
        <div class="col-lg-5">
            <img src="images/<?php echo htmlspecialchars($product['image']); ?>" class="img-fluid rounded" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
        </div>
        <div class="col-lg-6">
            <div class="product-category"><?php echo htmlspecialchars($product['category']); ?></div>
            <h3 class="fw-bold"><?php echo htmlspecialchars($product['product_name']); ?></h3>
            <p class="text-muted"><?php echo htmlspecialchars($product['description']); ?></p>
            <h4 id="unitPrice" data-price="<?php echo $product['price']; ?>" class="fw-bold mb-4">
                Rs. <?php echo number_format($product['price'], 2); ?>
            </h4>

            <?php if ($error): ?>
                <div class="alert alert-danger veyro-alert"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="customer_name" class="form-control"
                           value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Delivery Address</label>
                    <textarea name="address" class="form-control" rows="2" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Quantity</label>
                    <div class="input-group" style="max-width:160px;">
                        <button type="button" class="btn btn-outline-dark" id="qtyMinus">-</button>
                        <input type="number" name="quantity" id="qtyInput" class="form-control text-center" value="1" min="1" max="<?php echo $product['stock']; ?>">
                        <button type="button" class="btn btn-outline-dark" id="qtyPlus">+</button>
                    </div>
                </div>

                <h5>Total: <span id="totalPrice" class="fw-bold"></span></h5>

                <button type="submit" class="btn btn-veyro w-100 mt-3">Confirm Order</button>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
