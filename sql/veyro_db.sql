CREATE DATABASE IF NOT EXISTS veyro_db;
USE veyro_db;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);
INSERT INTO admin (username, password) VALUES
('admin', '$2y$10$JxNJXnUUNNkUyJZTGw1t9ejYyqCbBHoBkJPjT/8XP3mQTwtBQZKHe');
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(150) NOT NULL,
    category VARCHAR(50) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    description TEXT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO products (product_name, category, price, stock, description, image) VALUES
('Oversized Hoodie', 'Hoodie', 2200.00, 25, 'Premium heavyweight cotton oversized hoodie. Everyday comfort meets street style.', 'product1.jpg'),
('Classic T-Shirt', 'T-Shirt', 900.00, 40, 'Soft breathable cotton t-shirt with the VEYRO logo. A daily essential.', 'product2.jpg'),
('Cargo Pants', 'Pants', 1800.00, 20, 'Multi-pocket cargo pants built for comfort and street-ready style.', 'product3.jpg'),
('Denim Jacket', 'Jacket', 3200.00, 12, 'Classic washed denim jacket, a timeless layering piece.', 'product4.jpg'),
('Track Jacket', 'Jacket', 2600.00, 18, 'Lightweight track jacket, perfect for active days.', 'product5.jpg'),
('Graphic Tee', 'T-Shirt', 950.00, 35, 'Bold graphic print tee made from soft cotton blend.', 'product6.jpg'),
('Joggers', 'Pants', 1600.00, 22, 'Tapered fit joggers with elastic cuffs for all-day comfort.', 'product7.jpg'),
('Puffer Vest', 'Jacket', 2900.00, 10, 'Lightweight puffer vest to keep you warm without the bulk.', 'product8.jpg');
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    total_price DECIMAL(10,2) NOT NULL,
    customer_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address VARCHAR(255) NOT NULL,
    order_status VARCHAR(20) DEFAULT 'Pending',
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);
