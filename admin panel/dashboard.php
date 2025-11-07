<?php 
include 'auth_check.php'; 
?>

<?php 
include '../components/connect.php'; 

// Check if seller_id cookie exists
if (isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
} else {
    header('location:login.php');
    exit; // Ensure the script stops after the redirect
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body>
  <div class="main-container">
    <?php include '../components/admin_header.php'; ?>
    <section class="dashboard">
        <div class="heading">
            <h1>Dashboard</h1>
            <img src="../image/separator-img.png" alt="Separator">
        </div>
        <div class="box-container">

            <!-- Welcome Box -->
            <div class="box">
                <h3>Welcome!</h3>
                <?php 
                // Fetch seller's name
                $profile_stmt = $con->prepare("SELECT name FROM `sellers` WHERE id = ?");
                if ($profile_stmt === false) {
                    die('MySQL prepare error: ' . $con->error);
                }
                $profile_stmt->bind_param("i", $seller_id);
                $profile_stmt->execute();
                $fetch_profile = $profile_stmt->get_result()->fetch_assoc();
                ?>
                <p><?= isset($fetch_profile['name']) ? htmlspecialchars($fetch_profile['name']) : 'Seller'; ?></p>
                <button class="btn" onclick="location.href='../update.php'">Edit Profile</button>
            </div>

            <!-- Total Messages Box -->
            <div class="box">
                <?php 
                // Count total messages
                $select_message = $con->prepare("SELECT COUNT(*) AS total_messages FROM `message`"); 
                if ($select_message === false) {
                    die('MySQL prepare error: ' . $con->error);
                }
                $select_message->execute();
                $result_message = $select_message->get_result()->fetch_assoc();
                $number_of_messages = $result_message['total_messages'] ?? 0; // Default to 0 if no data
                ?>
                <h3><?= $number_of_messages; ?></h3>
                <p>Total Messages</p>
                <button class="btn" onclick="location.href='admin_message.php'">View Messages</button>
            </div>

            <!-- Total Products Added Box -->
            <div class="box">
                <?php 
                // Count total products added by the seller
                $select_products_added = $con->prepare("SELECT COUNT(*) AS total_products_added FROM `products` WHERE seller_id = ?");
                if ($select_products_added === false) {
                    die('MySQL prepare error: ' . $con->error);
                }
                $select_products_added->bind_param("i", $seller_id);
                $select_products_added->execute();
                $result_products_added = $select_products_added->get_result()->fetch_assoc();
                $total_products_added = $result_products_added['total_products_added'] ?? 0; // Default to 0 if no data
                ?>
                <h3><?= $total_products_added; ?></h3>
                <p>Total Products Added</p>
                <button class="btn" onclick="location.href='add_products.php'">Add New Product</button>
            </div>

            <!-- Total Active Products Box -->
            <div class="box">
                <?php 
                // Count active products
                $select_active_products = $con->prepare("SELECT COUNT(*) AS total_active_products FROM `products` WHERE seller_id = ? AND status = ?");
                $status_active = 'active';
                if ($select_active_products === false) {
                    die('MySQL prepare error: ' . $con->error);
                }
                $select_active_products->bind_param("is", $seller_id, $status_active);
                $select_active_products->execute();
                $result_active_products = $select_active_products->get_result()->fetch_assoc();
                $total_active_products = $result_active_products['total_active_products'] ?? 0; // Default to 0 if no data
                ?>
                <h3><?= $total_active_products; ?></h3>
                <p>Total Active Products</p>
                <button class="btn" onclick="location.href='view_product.php'">View Active Products</button>
            </div>
 <!-- Total Inactive Products Box (Corrected for deactive status) -->
 <div class="box">
                <?php 
                // Count inactive products (status = 'deactive')
                $select_inactive_products = $con->prepare("SELECT COUNT(*) AS total_inactive_products FROM `products` WHERE seller_id = ? AND status = ?");
                $status_deactive = 'deactive'; // Ensure the status is 'deactive'
                if ($select_inactive_products === false) {
                    die('MySQL prepare error: ' . $con->error);
                }
                $select_inactive_products->bind_param("is", $seller_id, $status_deactive);  // Bind status as 'deactive'
                $select_inactive_products->execute();
                $result_inactive_products = $select_inactive_products->get_result()->fetch_assoc();
                $total_inactive_products = $result_inactive_products['total_inactive_products'] ?? 0; // Default to 0 if no data
                ?>
                <h3><?= $total_inactive_products; ?></h3>
                <p>Total Inactive Products</p>
                <button class="btn" onclick="location.href='view_product.php'">View Inactive Products</button>
            </div>
            <!-- Users Account Box -->
            <div class="box">
                <?php 
                // Count total users
                $select_users = $con->prepare("SELECT COUNT(*) AS total_users FROM `users`"); 
                if ($select_users === false) {
                    die('MySQL prepare error: ' . $con->error);
                }
                $select_users->execute();
                $result_users = $select_users->get_result()->fetch_assoc();
                $number_of_users = $result_users['total_users'] ?? 0; // Default to 0 if no data
                ?>
                <h3><?= $number_of_users; ?></h3>
                <p>User Accounts</p>
                <button class="btn" onclick="location.href='users_accounts.php'">See Users</button>
            </div>

            <!-- Sellers Account Box -->
            <div class="box">
                <?php 
                // Count total sellers
                $select_sellers = $con->prepare("SELECT COUNT(*) AS total_sellers FROM `sellers`"); 
                if ($select_sellers === false) {
                    die('MySQL prepare error: ' . $con->error);
                }
                $select_sellers->execute();
                $result_sellers = $select_sellers->get_result()->fetch_assoc();
                $number_of_sellers = $result_sellers['total_sellers'] ?? 0; // Default to 0 if no data
                ?>
                <h3><?= $number_of_sellers; ?></h3>
                <p>Seller Accounts</p>
                <button class="btn" onclick="location.href='sellers_accounts.php'">See Sellers</button>
            </div>

            <!-- Total Orders Placed Box -->
            <div class="box">
                <?php 
                // Count total orders placed by the seller
                $select_orders = $con->prepare("SELECT COUNT(*) AS total_orders FROM `orders` WHERE seller_id = ?");
                if ($select_orders === false) {
                    die('MySQL prepare error: ' . $con->error);
                }
                $select_orders->bind_param("i", $seller_id);
                $select_orders->execute();
                $result_orders = $select_orders->get_result()->fetch_assoc();
                $number_of_orders = $result_orders['total_orders'] ?? 0; // Default to 0 if no data
                ?>
                <h3><?= $number_of_orders; ?></h3>
                <p>Orders Placed</p>
                <button class="btn" onclick="location.href='admin_order.php'">See Orders</button>
            </div>

            <!-- Confirmed Orders Box -->
            <div class="box">
                <?php 
                // Count confirmed orders
                $select_confirm_orders = $con->prepare("SELECT COUNT(*) AS total_confirmed_orders FROM `orders` WHERE seller_id = ? AND status = ?");
                $status_confirmed = 'in progress';
                if ($select_confirm_orders === false) {
                    die('MySQL prepare error: ' . $con->error);
                }
                $select_confirm_orders->bind_param("is", $seller_id, $status_confirmed);
                $select_confirm_orders->execute();
                $result_confirm_orders = $select_confirm_orders->get_result()->fetch_assoc();
                $number_of_confirm_orders = $result_confirm_orders['total_confirmed_orders'] ?? 0; // Default to 0 if no data
                ?>
                <h3><?= $number_of_confirm_orders; ?></h3>
                <p>Confirmed Orders</p>
                <button class="btn" onclick="location.href='admin_order.php'">Confirm Orders</button>
            </div>

            <!-- Cancelled Orders Box -->
            <div class="box">
                <?php 
                // Count cancelled orders
                $select_cancelled_orders = $con->prepare("SELECT COUNT(*) AS total_cancelled_orders FROM `orders` WHERE seller_id = ? AND status = ?");
                $status_cancelled = 'cancelled';
                if ($select_cancelled_orders === false) {
                    die('MySQL prepare error: ' . $con->error);
                }
                $select_cancelled_orders->bind_param("is", $seller_id, $status_cancelled);
                $select_cancelled_orders->execute();
                $result_cancelled_orders = $select_cancelled_orders->get_result()->fetch_assoc();
                $number_of_cancelled_orders = $result_cancelled_orders['total_cancelled_orders'] ?? 0; // Default to 0 if no data
                ?>
                <h3><?= $number_of_cancelled_orders; ?></h3>
                <p>Cancelled Orders</p>
                <button class="btn" onclick="location.href='admin_order.php'">Cancelled Orders</button>
            </div>

        </div> <!-- Closing box-container div -->
    </section>

  </div> <!-- Closing main-container div -->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <script src="../js/admin_script.js"></script>
  <?php include '../components/alert.php'; ?>
</body>
</html>
