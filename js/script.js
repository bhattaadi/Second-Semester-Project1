document.addEventListener("DOMContentLoaded", function () {
    var bannerEl = document.getElementById("veyroCarousel");
    if (bannerEl) {
        var veyroCarousel = new bootstrap.Carousel(bannerEl, {
            interval: 10000,   
            ride: "carousel",
            wrap: true,
            pause: false  
        });
    }
    var currentPage = window.location.pathname.split("/").pop();
    document.querySelectorAll(".veyro-nav a").forEach(function (link) {
        if (link.getAttribute("href") === currentPage) {
            link.classList.add("active");
        }
    });
    var qtyInput = document.getElementById("qtyInput");
    var qtyMinus = document.getElementById("qtyMinus");
    var qtyPlus = document.getElementById("qtyPlus");
    var unitPriceEl = document.getElementById("unitPrice");
    var totalPriceEl = document.getElementById("totalPrice");

    function updateTotal() {
        if (qtyInput && unitPriceEl && totalPriceEl) {
            var qty = parseInt(qtyInput.value) || 1;
            var price = parseFloat(unitPriceEl.dataset.price);
            totalPriceEl.textContent = "Rs. " + (qty * price).toFixed(2);
        }
    }

    if (qtyMinus && qtyPlus && qtyInput) {
        qtyMinus.addEventListener("click", function () {
            var val = parseInt(qtyInput.value) || 1;
            if (val > 1) qtyInput.value = val - 1;
            updateTotal();
        });
        qtyPlus.addEventListener("click", function () {
            var val = parseInt(qtyInput.value) || 1;
            qtyInput.value = val + 1;
            updateTotal();
        });
        qtyInput.addEventListener("input", updateTotal);
        updateTotal();
    }
    var alerts = document.querySelectorAll(".veyro-alert");
    alerts.forEach(function (alertBox) {
        setTimeout(function () {
            var bsAlert = bootstrap.Alert.getOrCreateInstance(alertBox);
            bsAlert.close();
        }, 4000);
    });
    document.querySelectorAll(".sidebar-category-link").forEach(function (link) {
        link.addEventListener("click", function () {
            document.querySelectorAll(".sidebar-category-link").forEach(function (l) {
                l.classList.remove("active-category");
            });
            link.classList.add("active-category");
        });
    });

});
