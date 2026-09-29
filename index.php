<?php
session_start();

require 'config/db.php';

$page_title = "VEYRO | Wear Your Vision";

include 'includes/header.php';


/* =========================================================
   FETCH FEATURED PRODUCTS
   Latest 11 products
========================================================= */

$stmt = $conn->query("
    SELECT *
    FROM products
    ORDER BY created_at DESC
    LIMIT 11
");

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);


/* =========================================================
   SIDE BANNERS
   Row 1  -> Sidebar (categories + big sale)
   Row 2+ -> One image per row, on the right of the products

   TIP: Tall/vertical images (e.g. 400x600) look best here.
   Put your file names in this array.
========================================================= */

$side_banners = [
    'banner1.png',
    'banner2.png',
    'banner3.png',
    'banner4.png',
    'banner5.png',
];

// 2 products per row
$product_rows = array_chunk($products, 2);

?>

<!-- =========================================================
     BANNER CAROUSEL
========================================================= -->

<div class="veyro-banner-wrap">

    <div id="veyroCarousel"
         class="carousel slide"
         data-bs-ride="carousel"
         data-bs-interval="5000">


        <!-- Carousel Indicators -->

        <div class="carousel-indicators">

            <button
                type="button"
                data-bs-target="#veyroCarousel"
                data-bs-slide-to="0"
                class="active">
            </button>

            <button
                type="button"
                data-bs-target="#veyroCarousel"
                data-bs-slide-to="1">
            </button>

            <button
                type="button"
                data-bs-target="#veyroCarousel"
                data-bs-slide-to="2">
            </button>

            <button
                type="button"
                data-bs-target="#veyroCarousel"
                data-bs-slide-to="3">
            </button>

            <button
                type="button"
                data-bs-target="#veyroCarousel"
                data-bs-slide-to="4">
            </button>

        </div>


        <!-- Carousel Images -->

        <div class="carousel-inner">

            <div class="carousel-item active">
                <img
                    src="images/banner1.png"
                    alt="New Season, Same You, Better Style">
            </div>

            <div class="carousel-item">
                <img
                    src="images/banner2.png"
                    alt="Style For Every Journey">
            </div>

            <div class="carousel-item">
                <img
                    src="images/banner3.png"
                    alt="Big Sale Up To 50% Off">
            </div>

            <div class="carousel-item">
                <img
                    src="images/banner4.png"
                    alt="Men Women Unisex - Find Your Perfect Fit">
            </div>

            <div class="carousel-item">
                <img
                    src="images/banner5.png"
                    alt="Spring Summer Collection">
            </div>

        </div>


        <!-- Previous Button -->

        <button
            class="carousel-control-prev"
            type="button"
            data-bs-target="#veyroCarousel"
            data-bs-slide="prev">

            <span class="carousel-control-prev-icon"></span>

        </button>


        <!-- Next Button -->

        <button
            class="carousel-control-next"
            type="button"
            data-bs-target="#veyroCarousel"
            data-bs-slide="next">

            <span class="carousel-control-next-icon"></span>

        </button>

    </div>

</div>

<!-- =========================================================
     END BANNER
========================================================= -->



<!-- =========================================================
     FEATURED PRODUCTS
========================================================= -->

<div class="container veyro-featured-section">


    <!-- Section Title -->

    <h2 class="section-title">
        Featured Products
    </h2>

    <div class="section-underline"></div>



    <!-- =====================================================
         ORDER SUCCESS MESSAGE
    ====================================================== -->

    <?php if (isset($_SESSION['order_msg'])): ?>

        <div
            class="alert alert-success veyro-alert alert-dismissible fade show"
            role="alert">

            <?php
            echo htmlspecialchars($_SESSION['order_msg']);
            unset($_SESSION['order_msg']);
            ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    <?php endif; ?>



    <!-- =====================================================
         NO PRODUCTS
    ====================================================== -->

    <?php if (count($products) === 0): ?>

        <div class="no-products">
            <p>No products available yet.</p>
        </div>

    <?php endif; ?>



    <!-- =====================================================
         PRODUCT ROWS

         Every row:  [ Product ] [ Product ] [ Side cell ]

         Row 1  -> side cell = Sidebar
         Row 2+ -> side cell = Banner image
                   (same height as the product cards)
    ====================================================== -->

    <div class="veyro-rows">

        <?php foreach ($product_rows as $row_index => $row_products): ?>

            <div class="veyro-row">


                <!-- ===========================
                     PRODUCTS (max 2 per row)
                ============================ -->

                <?php foreach ($row_products as $p): ?>

                    <div class="product-card">

                        <!-- Product Image -->
                        <div class="product-img-wrap">
                            <img
                                src="images/<?php echo htmlspecialchars($p['image']); ?>"
                                alt="<?php echo htmlspecialchars($p['product_name']); ?>"
                                loading="lazy">
                        </div>

                        <!-- Product Details -->
                        <div class="product-body">

                            <div class="product-category">
                                <?php echo htmlspecialchars($p['category']); ?>
                            </div>

                            <div class="product-name">
                                <?php echo htmlspecialchars($p['product_name']); ?>
                            </div>

                            <div class="product-price">
                                Rs. <?php echo number_format($p['price'], 2); ?>
                            </div>

                            <a
                                href="order.php?id=<?php echo (int)$p['id']; ?>"
                                class="btn btn-veyro w-100 mt-3">
                                ORDER NOW
                            </a>

                        </div>

                    </div>

                <?php endforeach; ?>



                <!-- ===========================
                     SIDE CELL (3rd column)
                ============================ -->

                <?php if ($row_index === 0): ?>

                    <!-- Row 1: SIDEBAR -->
                    <aside class="side-cell veyro-sidebar">
                        <?php include 'includes/sidebar.php'; ?>
                    </aside>

                <?php else: ?>

                    <!-- Row 2+: BANNER IMAGE -->
                    <div class="side-cell side-banner">
                        <img
                            src="images/<?php echo htmlspecialchars($side_banners[($row_index - 1) % count($side_banners)]); ?>"
                            alt="VEYRO Banner"
                            loading="lazy">
                    </div>

                <?php endif; ?>


            </div>

        <?php endforeach; ?>

    </div>



    <!-- =====================================================
         VIEW ALL PRODUCTS BUTTON
    ====================================================== -->

    <div class="text-center view-all-wrapper">

        <a
            href="products.php"
            class="btn btn-veyro-outline">

            VIEW ALL PRODUCTS

        </a>

    </div>


</div>

<!-- =========================================================
     END FEATURED PRODUCTS
========================================================= -->



<?php

include 'includes/footer.php';

?>



<!-- =========================================================
     PAGE-SPECIFIC CSS
========================================================= -->

<style>


/* =========================================================
   FEATURED SECTION
========================================================= */

.veyro-featured-section {
    padding-top: 40px;
    padding-bottom: 60px;
}



/* =========================================================
   ROWS + GRID
   3 equal columns: product | product | side cell
========================================================= */

.veyro-rows {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.veyro-row {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 24px;
    align-items: stretch;      /* side cell height = product card height */
}

/* Side cell always stays in the 3rd column,
   even if the last row has only 1 product */
.veyro-row .side-cell {
    grid-column: 3;
    width: 100%;
    min-width: 0;
}



/* =========================================================
   PRODUCT CARD
========================================================= */

.product-card {
    width: 100%;
    height: 100%;
    background: #ffffff;
    border: 1px solid #e4e4e4;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition:
        transform 0.25s ease,
        box-shadow 0.25s ease;
}

.product-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 22px rgba(0, 0, 0, 0.08);
}



/* =========================================================
   PRODUCT IMAGE
========================================================= */

.product-img-wrap {
    width: 100%;
    height: 260px;
    overflow: hidden;
    background: #eeeae0;
}

.product-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.35s ease;
}

.product-card:hover .product-img-wrap img {
    transform: scale(1.03);
}



/* =========================================================
   PRODUCT BODY
========================================================= */

.product-body {
    padding: 16px;
    background: #ffffff;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.product-category {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #777777;
    margin-bottom: 6px;
}

.product-name {
    font-size: 17px;
    font-weight: 600;
    line-height: 1.35;
    color: #111111;
    margin-bottom: 7px;
}

.product-price {
    font-size: 16px;
    font-weight: 700;
    color: #111111;
}



/* =========================================================
   ORDER BUTTON
========================================================= */

.btn-veyro {
    background: #111111;
    color: #ffffff;
    border: 1px solid #111111;
    border-radius: 0;
    padding: 11px 15px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: all 0.25s ease;
}

.btn-veyro:hover {
    background: #333333;
    color: #ffffff;
    border-color: #333333;
}



/* =========================================================
   SIDEBAR (Row 1, 3rd column)
========================================================= */

.veyro-sidebar {
    width: 100%;
    margin: 0;
    padding: 0;
    align-self: start;         /* sidebar keeps its own natural height */
}

.veyro-sidebar > * {
    width: 100%;
    max-width: 100%;
    margin-left: 0;
    margin-right: 0;
}



/* =========================================================
   SIDE BANNER (Row 2+, 3rd column)
   Fills the full height of the product row
========================================================= */

.side-banner {
    position: relative;
    overflow: hidden;
    background: #111111;
    border: 1px solid #e4e4e4;
    min-height: 200px;
}

.side-banner img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;         /* fills the box, crops extra */
    object-position: center;
    display: block;
}



/* =========================================================
   VIEW ALL BUTTON
========================================================= */

.view-all-wrapper {
    margin-top: 40px;
    margin-bottom: 10px;
}

.btn-veyro-outline {
    background: #ffffff;
    color: #111111;
    border: 1px solid #111111;
    border-radius: 0;
    padding: 12px 30px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0.4px;
    transition: all 0.25s ease;
}

.btn-veyro-outline:hover {
    background: #111111;
    color: #ffffff;
}



/* =========================================================
   NO PRODUCTS
========================================================= */

.no-products {
    text-align: center;
    padding: 60px 20px;
    color: #777777;
}



/* =========================================================
   ALERT
========================================================= */

.veyro-alert {
    margin-bottom: 30px;
}



/* =========================================================
   TABLET  (2 columns, side cell goes below the products)
========================================================= */

@media (max-width: 991px) {

    .veyro-row {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .veyro-row .side-cell {
        grid-column: 1 / -1;
    }

    .side-banner {
        min-height: 0;
        height: 150px;
    }

}



/* =========================================================
   MOBILE  (1 column, banners hidden)
========================================================= */

@media (max-width: 767px) {

    .veyro-row {
        grid-template-columns: 1fr;
    }

    .side-banner {
        display: none;
    }

    .product-img-wrap {
        height: 280px;
    }

}



/* =========================================================
   SMALL MOBILE
========================================================= */

@media (max-width: 575px) {

    .veyro-featured-section {
        padding-top: 25px;
    }

    .product-img-wrap {
        height: 250px;
    }

    .product-body {
        padding: 14px;
    }

    .product-name {
        font-size: 16px;
    }

}

</style>