<?php
include_once 'connect.php';

// Check if the user is logged in by checking for a session or cookie
$user_id = '';
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delightful Creamery- Header</title>
    
    <!-- Boxicons CSS for icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/user_style.css">
    
    <style>
        .profile img {
            width: 220px;
            height: 220px;
            border-radius: 20%;
            object-fit: cover;
            margin-bottom: 1rem;
            border: 3px solid #ddd;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: -250px;
            width: 250px;
            height: 100%;
            background-color: #f8f8f8;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
            padding-top: 2rem;
            transition: left 0.3s ease;
            z-index: 9999;
        }
        .sidebar.active {
            left: 0;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            padding: 1rem;
            border-bottom: 1px solid #ddd;
        }
        .sidebar ul li a {
            color: #333;
            text-decoration: none;
            font-size: 1rem;
        }
        .profile {
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease, visibility 0.3s ease;
            position: absolute;
            top: 125%;
            right: 2rem;
            background-color: rgba(255, 255, 255, 0.85);
            border: 2px solid rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(5px);
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.4);
            border-radius: 0.5rem;
            width: 20rem;
            padding: 1.5rem 0.5rem;
            text-align: center;
            z-index: 10;
        }
        .profile.active {
            display: block;
            opacity: 1;
        }
    </style>
</head>
<body>

<header class="header">
    <section class="flex">
        <a href="home.php" class="logo">
            <img src="image/logo.png" width="130px" alt="Delightful Creamery Logo">
        </a>
        <nav class="navbar">
            <a href="home.php">Home</a>
            <a href="about_us.php">About Us</a>
            <a href="menu.php">Shop</a>
            <a href="order.php">Order</a>
            <a href="contact.php">Contact Us</a>
        </nav>
        <form action="search-product.php" method="post" class="search-form">
            <input type="text" name="search_product" placeholder="Search product..." required maxlength="100">
            <button type="submit" class="bx bx-search-alt-2" id="search_product_btn"></button>
        </form>
        <div class="icons">
    <div class="bx bx-list-plus" id="menu-btn" onclick="toggleSidebar()"></div>
    <div class="bx bx-search-alt-2" id="search-btn"></div>
    <?php
    // Fetch the total wishlist items
    $count_wishlist_items = $con->prepare("SELECT COUNT(*) AS total FROM `whitelist` WHERE user_id = ?");
    $count_wishlist_items->bind_param("s", $user_id);
    $count_wishlist_items->execute();
    $result = $count_wishlist_items->get_result();
    $total_wishlist_items = 0;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $total_wishlist_items = $row['total'];
    }
    ?>
    <a href="whishlist.php"><i class="bx bx-heart"></i><sup><?= $total_wishlist_items; ?></sup></a>
    <?php
    // Fetch the total quantity of cart items
    $count_cart_items = $con->prepare("SELECT SUM(qty) AS total_qty FROM `cart` WHERE user_id = ?");
    $count_cart_items->bind_param("s", $user_id);
    $count_cart_items->execute();
    $result = $count_cart_items->get_result();
    $total_cart_items = 0;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $total_cart_items = $row['total_qty'] ?? 0;
    }
    ?>
    <a href="cart.php"><i class="bx bx-cart"></i><sup><?= $total_cart_items; ?></sup></a>
    <div class="bx bxs-user" id="user-btn" onclick="toggleProfile()"></div>
</div>

        <div class="profile" id="profileSection">
            <?php 
            if (!empty($user_id)) {
                $stmt = $con->prepare("SELECT * FROM `users` WHERE `id` = ?");
                $stmt->bind_param("s", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $fetch_profile = $result->fetch_assoc();
                    ?>
                    <img src="uploaded_files/<?= htmlspecialchars($fetch_profile['image']); ?>" alt="User Image">
                    <h3 style="margin-bottom: 1rem;"><?= htmlspecialchars($fetch_profile['name']); ?></h3>
                    <div class="flex-btn">
                        <a href="profile.php" class="btn">View Profile</a>
                        <a href="components/user_logout.php" onclick="return confirm('Logout from this website?');" class="btn">Logout</a>
                    </div>
                    <?php
                }
                $stmt->close();
            } else {
                ?>
                <h3 style="margin-bottom:1rem;">Please login or register</h3>
                <div class="flex-btn">
                    <a href="login.php" class="btn">Login</a>
                    <a href="register.php" class="btn">Register</a>
                </div>
                <?php
            }
            ?>
        </div>
    </section>
</header>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="about-us.php">About Us</a></li>
        <li><a href="menu.php">Shop</a></li>
        <li><a href="order.php">Order</a></li>
        <li><a href="contact.php">Contact Us</a></li>
    </ul>
</div>

<script>
    function toggleProfile() {
        const profileSection = document.getElementById('profileSection');
        profileSection.classList.toggle('active');
    }

    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('active');
    }
</script>

</body>
</html>
