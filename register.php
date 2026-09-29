<?php
session_start();
require 'config/db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email     = trim($_POST['email']);
    $password  = $_POST['password'];
    $confirm   = $_POST['confirm_password'];

    if ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        // check if email already used
        $check = $conn->prepare("SELECT id FROM users WHERE email = :email");
        $check->execute([':email' => $email]);

        if ($check->rowCount() > 0) {
            $error = "This email is already registered.";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $insert = $conn->prepare("INSERT INTO users (full_name, email, password) VALUES (:full_name, :email, :password)");
            $insert->execute([
                ':full_name' => $full_name,
                ':email'     => $email,
                ':password'  => $hashed
            ]);
            $success = "Account created successfully. You can login now.";
        }
    }
}

$page_title = "Register | VEYRO";
include 'includes/header.php';
?>

<div class="container">
    <div class="auth-card">
        <h3>Create Account</h3>

        <?php if ($error): ?>
            <div class="alert alert-danger veyro-alert"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success veyro-alert"><?php echo $success; ?> <a href="login.php">Login</a></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="full_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" minlength="6" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" minlength="6" required>
            </div>
            <button type="submit" class="btn btn-veyro w-100">Register</button>
        </form>

        <p class="text-center small mt-3 mb-0">
            Already have an account? <a href="login.php">Login here</a>
        </p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
