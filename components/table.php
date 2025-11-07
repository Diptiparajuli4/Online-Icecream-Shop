<?php
// SQL to create the 'users' table
$sql = "
    CREATE TABLE IF NOT EXISTS `users` (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100),
        email VARCHAR(100) UNIQUE,
        password VARCHAR(255),
        image VARCHAR(255)
    );
";

// Execute query
if ($con->query($sql) === TRUE) {
    echo "Table 'users' created successfully.<br>";
} else {
    echo "Error creating table 'users': " . $con->error . "<br>";
}

// SQL to create the 'sellers' table
$sql = "
    CREATE TABLE IF NOT EXISTS `sellers` (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100),
        email VARCHAR(100) UNIQUE,
        password VARCHAR(255),
        image VARCHAR(255)
    );
";

if ($con->query($sql) === TRUE) {
    echo "Table 'sellers' created successfully.<br>";
} else {
    echo "Error creating table 'sellers': " . $con->error . "<br>";
}

// SQL to create the 'products' table
$sql = "
    CREATE TABLE IF NOT EXISTS `products` (
        id INT AUTO_INCREMENT PRIMARY KEY,
        seller_id INT,
        name VARCHAR(255),
        price DECIMAL(10,2),
        image VARCHAR(255),
        stock INT,
        product_detail TEXT,
        status VARCHAR(50) DEFAULT 'active',
        FOREIGN KEY (seller_id) REFERENCES sellers(id) ON DELETE CASCADE
    );
";

if ($con->query($sql) === TRUE) {
    echo "Table 'products' created successfully.<br>";
} else {
    echo "Error creating table 'products': " . $con->error . "<br>";
}

// SQL to create the 'cart' table
$sql = "
    CREATE TABLE IF NOT EXISTS `cart` (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        product_id INT,
        price DECIMAL(10,2),
        qty INT,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
    );
";

if ($con->query($sql) === TRUE) {
    echo "Table 'cart' created successfully.<br>";
} else {
    echo "Error creating table 'cart': " . $con->error . "<br>";
}

// SQL to create the 'message' table
$sql = "
    CREATE TABLE IF NOT EXISTS `message` (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        name VARCHAR(100),
        email VARCHAR(100),
        subject VARCHAR(255),
        message TEXT,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    );
";

if ($con->query($sql) === TRUE) {
    echo "Table 'message' created successfully.<br>";
} else {
    echo "Error creating table 'message': " . $con->error . "<br>";
}

// SQL to create the 'orders' table
$sql = "
    CREATE TABLE IF NOT EXISTS `orders` (
        id VARCHAR(50) PRIMARY KEY,
        name VARCHAR(100),
        user_id INT,
        seller_id INT,
        number VARCHAR(20),
        email VARCHAR(100),
        address TEXT,
        address_type VARCHAR(50),
        method VARCHAR(50),
        product_id INT,
        price DECIMAL(10,2),
        payment_status VARCHAR(50) DEFAULT 'pending',
        qty INT,
        dates TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        status VARCHAR(50) DEFAULT 'in progress',
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (seller_id) REFERENCES sellers(id) ON DELETE CASCADE,
        FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
    );
";

if ($con->query($sql) === TRUE) {
    echo "Table 'orders' created successfully.<br>";
} else {
    echo "Error creating table 'orders': " . $con->error . "<br>";
}

// SQL to create the 'whitelist' table
$sql = "
    CREATE TABLE IF NOT EXISTS `whitelist` (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        product_id INT,
        price DECIMAL(10,2),
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
    );
";

if ($con->query($sql) === TRUE) {
    echo "Table 'whitelist' created successfully.<br>";
} else {
    echo "Error creating table 'whitelist': " . $con->error . "<br>";
}

$con->close();
?>