<?php
session_start();
require 'config/db.php';

// If already logged in, no need to see login page again
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Login success - start session
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}

$page_title = "Login | VEYRO";
include 'includes/header.php';
?>

<div class="container">
    <div class="auth-card">
        <h3>Login</h3>

        <?php if ($error): ?>
            <div class="alert alert-danger veyro-alert"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-veyro w-100">Login</button>
        </form>

        <p class="text-center small mt-3 mb-0">
            Don't have an account? <a href="register.php">Register here</a>
        </p>
        <p class="text-center small mt-2 mb-0">
            <a href="admin/login.php">Admin Login</a>
        </p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
