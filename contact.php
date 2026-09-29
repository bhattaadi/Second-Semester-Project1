<?php
session_start();
require 'config/db.php';
$page_title = "Contact Us | VEYRO";
include 'includes/header.php';

$sent = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sent = true;
}
?>

<div class="page-banner">Contact Us</div>

<div class="container my-5">
    <div class="row g-5">
        <div class="col-lg-5">
            <h4 class="fw-bold mb-3">Get In Touch</h4>
            <p class="text-muted">Have a question about an order or a product? Send us a message
                and our team will get back to you.</p>
            <ul class="list-unstyled mt-4">
                <li class="mb-3"><i class="bi bi-geo-alt me-2" style="color:var(--veyro-gold);"></i> Kathmandu, Nepal</li>
                <li class="mb-3"><i class="bi bi-telephone me-2" style="color:var(--veyro-gold);"></i> +977-9800000000</li>
                <li class="mb-3"><i class="bi bi-envelope me-2" style="color:var(--veyro-gold);"></i> support@veyro.com</li>
            </ul>
        </div>
        <div class="col-lg-7">
            <?php if ($sent): ?>
                <div class="alert alert-success veyro-alert">Thank you! Your message has been sent.</div>
            <?php endif; ?>
            <form method="POST" class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Full Name</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Subject</label>
                    <input type="text" class="form-control" name="subject" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Message</label>
                    <textarea class="form-control" rows="5" name="message" required></textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-veyro">Send Message</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
