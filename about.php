<?php
session_start();
require 'config/db.php';
$page_title = "About Us | VEYRO";
include 'includes/header.php';
?>

<div class="page-banner">About Us</div>

<div class="container my-5">
    <div class="row align-items-center g-5">
        <div class="col-lg-6">
            <img src="images/banner5.png" class="img-fluid rounded" alt="About VEYRO">
        </div>
        <div class="col-lg-6">
            <h2 class="fw-bold mb-3">WEAR YOUR VISION</h2>
            <div class="section-underline" style="margin-left:0;"></div>
            <p>VEYRO was built on a simple idea — clothing should look good, feel good, and fit
                into every part of your life. From casual outings to active days, our pieces are
                designed with fresh looks, premium quality, and everyday comfort in mind.</p>
            <p>What started as a small streetwear idea has grown into a full collection covering
                men, women, and unisex essentials — hoodies, tees, jackets, and pants made to
                move with you, wherever your journey takes you.</p>

            <div class="row mt-4">
                <div class="col-4 text-center">
                    <h4 class="fw-bold mb-0">50K+</h4>
                    <small class="text-muted">Happy Customers</small>
                </div>
                <div class="col-4 text-center">
                    <h4 class="fw-bold mb-0">120+</h4>
                    <small class="text-muted">Products</small>
                </div>
                <div class="col-4 text-center">
                    <h4 class="fw-bold mb-0">15+</h4>
                    <small class="text-muted">Cities Served</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5 g-4 text-center">
        <div class="col-md-4">
            <i class="bi bi-gem fs-1" style="color:var(--veyro-gold);"></i>
            <h5 class="mt-3 fw-bold">Premium Quality</h5>
            <p class="text-muted small">Every fabric is chosen for durability and comfort, so your
                favourite piece lasts season after season.</p>
        </div>
        <div class="col-md-4">
            <i class="bi bi-truck fs-1" style="color:var(--veyro-gold);"></i>
            <h5 class="mt-3 fw-bold">Fast Delivery</h5>
            <p class="text-muted small">We get your order to your doorstep quickly, wherever you
                are located.</p>
        </div>
        <div class="col-md-4">
            <i class="bi bi-arrow-repeat fs-1" style="color:var(--veyro-gold);"></i>
            <h5 class="mt-3 fw-bold">Easy Exchange</h5>
            <p class="text-muted small">Not the right fit? Reach out and we'll help sort an
                exchange, no hassle.</p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
