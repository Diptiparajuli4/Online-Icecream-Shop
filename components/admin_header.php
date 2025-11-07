<?php
// Include database connection
require_once '../components/connect.php'; // Adjusted path to point to components/connect.php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet"> <!-- Include Boxicons -->
    <title>Admin Panel</title>
</head>
<body>
    <header>
        <div class="logo">
            <img src="../image/logo.png" width="100" height="80">
        </div>
        <div class="right">
            <div class="bx bxs-user" id="user-btn"></div>
            <div class="toggle-btn"><i class="bx bxs-menu"></i></div>
        </div>
        <div class="profile">
            <?php
            $select_profile = $con->prepare("SELECT * FROM sellers WHERE id = ?");
            $select_profile->bind_param("s", $seller_id); 
            $select_profile->execute();
            $result = $select_profile->get_result();

            if ($result->num_rows > 0) { 
                $fetch_profile = $result->fetch_assoc();
                ?>
                <div class="profile-detail">
                    <img src="../uploaded_files/<?=$fetch_profile['image'];?>" class="logo-img" width="200">
                    <p><?=$fetch_profile['name'];?></p>
                    <div class="flex-btn">
                        <a href="profile.php" class="btn">Profile</a>
                    </div>
                    <a href="../components/admin_logout.php" onclick="return confirm('Logout from this website?');" class="btn">Logout</a>
                </div>
            <?php } ?>
        </div>
    </header>

    <div class="sidebar-container">
        <div class="sidebar">
            <?php
            $select_profile = $con->prepare("SELECT * FROM sellers WHERE id = ?");
            $select_profile->bind_param("s", $seller_id); 
            $select_profile->execute();
            $result = $select_profile->get_result();

            if ($result->num_rows > 0) { 
                $fetch_profile = $result->fetch_assoc();
                ?>
                <div class="profile">
                    <img src="../uploaded_files/<?=$fetch_profile['image'];?>" class="logo-img" width="200">
                    <p><?=$fetch_profile['name'];?></p>
                </div>
            <?php } ?>
            
            <h4>Menu</h4>
            <div class="navbar">
                <ul>
                    <li><a href="dashboard.php"><i class="bx bxs-home"></i> Dashboard</a></li>
                    <li><a href="add_products.php"><i class="bx bxs-cart-add"></i> Add Products</a></li>
                    <li><a href="view_product.php"><i class="bx bxs-package"></i> View Products</a></li>
                    <li><a href="users_accounts.php"><i class="bx bxs-user-account"></i> Accounts</a></li>
                    <li><a href="../components/admin_logout.php" onclick="return confirm('Logout from the website?');"><i class="bx bxs-log-out"></i> Logout</a></li>
                </ul>
            </div>

            <h5>Find Us</h5>
            <div class="social-links">
                <a href="#"><i class="bx bxl-facebook"></i></a>
                <a href="#"><i class="bx bxl-instagram"></i></a>
                <a href="#"><i class="bx bxl-linkedin"></i></a>
                <a href="#"><i class="bx bxl-twitter"></i></a>
                <a href="#"><i class="bx bxl-pinterest"></i></a>
            </div>
        </div>
    </div>
    
</body>
</html>
