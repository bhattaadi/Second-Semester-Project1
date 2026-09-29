# VEYRO E-Commerce Website
A BCA 2nd Year Project (Tribhuvan University)
Built with HTML, CSS, Bootstrap 5, JavaScript, PHP (PDO + Sessions) and MySQL.

## How to run this project (XAMPP)

1. Install **XAMPP** and start **Apache** and **MySQL** from the control panel.
2. Copy the whole `veyro` folder into `C:\xampp\htdocs\` (Windows) or
   `/Applications/XAMPP/htdocs/` (Mac).
3. Open **phpMyAdmin** (`http://localhost/phpmyadmin`).
4. Click **Import**, choose the file `sql/veyro_db.sql` from this project,
   and click **Go**. This creates the `veyro_db` database with sample
   products and an admin account.
5. Open the site in your browser: `http://localhost/veyro/index.php`

## Login details

**Admin Panel** — `http://localhost/veyro/admin/login.php`
- Username: `admin`
- Password: `admin123`

**Customer account**
- Register a new account from `register.php`, or use it to place an order
  (orders require login through PHP sessions).

## Project structure

```
veyro/
│   index.php          -> Homepage (banner slider + featured products + sidebar)
│   about.php           -> About Us page
│   contact.php         -> Contact form
│   products.php        -> Full product listing with category filter
│   order.php           -> Order Now form (per product)
│   myorders.php        -> Logged-in user's order history
│   login.php            -> Customer login
│   register.php         -> Customer registration
│   logout.php           -> Destroys session
│   .htaccess
│
├── config/
│   └── db.php           -> PDO database connection
│
├── includes/
│   ├── header.php       -> Shared site header/navbar
│   ├── footer.php       -> Shared site footer + JS includes
│   └── sidebar.php      -> Category sidebar
│
├── css/
│   └── style.css        -> All custom styling
│
├── js/
│   └── script.js        -> Carousel init, quantity stepper, small UI logic
│
├── images/
│   ├── banner1.png ... banner5.png
│   └── product1.jpg ... product8.jpg
│
├── admin/               -> Simple admin CRUD panel for products/orders
│   ├── login.php
│   ├── dashboard.php
│   ├── products.php      (Read + list)
│   ├── add_product.php   (Create)
│   ├── edit_product.php  (Update)
│   ├── delete_product.php(Delete)
│   ├── orders.php        (Read + Update status)
│   └── includes/
│       ├── admin_header.php
│       └── admin_footer.php
│
└── sql/
    └── veyro_db.sql      -> Import this into phpMyAdmin first
```

## Notes for the report / viva

- Database access uses **PDO with prepared statements** (protects against
  SQL injection).
- Passwords are stored using PHP's `password_hash()` / verified with
  `password_verify()` — never stored as plain text.
- **Sessions** (`$_SESSION`) are used for: customer login state, admin login
  state, and one-time success/error messages shown after an action
  (order placed, product added, etc.).
- The **CRUD** operations live in the `admin/` folder for products
  (Create → add_product.php, Read → products.php, Update → edit_product.php,
  Delete → delete_product.php) and orders (Read + Update status →
  admin/orders.php).
- The banner slider on the homepage uses **Bootstrap's Carousel JavaScript
  component**, initialised manually in `js/script.js` with
  `interval: 1000` so it rotates automatically every 1 second.
