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

// Prepare and execute the query to get total products
$select_products = $con->prepare("SELECT * FROM `products` WHERE seller_id = ?");
$select_products->bind_param("i", $seller_id);
$select_products->execute();
$product_result = $select_products->get_result();
$total_products = $product_result->num_rows;

// Prepare and execute the query to get total orders
$select_orders = $con->prepare("SELECT * FROM `orders` WHERE seller_id = ?");
$select_orders->bind_param("i", $seller_id);
$select_orders->execute();
$order_result = $select_orders->get_result();
$total_orders = $order_result->num_rows;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
<style>
   /* Seller Profile Section */
.seller {
    text-align: center;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    margin-bottom: 20px;
    width: 250px; /* Adjust width as needed */
    margin: 0 auto; /* Center the seller box */
}

/* Profile Image Styling */
.seller img {
    width: 150px; /* Set image width */
    height: 150px; /* Set image height */
    object-fit: cover; /* Ensure image covers the area */
    border-radius: 50%; /* Make the image round */
    border: 3px solid #ddd; /* Border around the image */
    margin-bottom: 10px;
}

/* Seller Name Styling */
.seller .name {
    font-size: 1.5rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 5px;
}

.seller span {
    display: block;
    font-size: 1rem;
    color: #888;
    margin-bottom: 10px;
}

/* Update Profile Button Styling */
.seller .btn {
    background-color: #ff6f61;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
    font-size: 1rem;
    transition: background-color 0.3s ease;
    display: inline-block;
    margin-top: 15px; /* Add space above the button */
}

.seller .btn:hover {
    background-color: #ff5049;
}


    </style>
</head>
<body>
  <div class="main-container">
    <?php include '../components/admin_header.php'; ?>
    <section class="dashboard">
        <div class="heading">
            <h1>Profile Details</h1>
            <img src="../image/separator-img.png" alt="Separator">
        </div>
        <div class="details">
            <div class="seller">
                <img src="../uploaded_files/<?=$fetch_profile['image'];?>">
                <h3 class="name"><?=$fetch_profile['name'];?></h3>
                <span>seller</span>
          </div>
          <a href="../update.php" class="btn">update profile</a>

          <div class="flex">
            <div class="box">
                <span><?=$total_products; ?></span>
                <p>total products</p>
                <a href="view_product.php" class="btn">view products</a>
          </div>
          <div class="box">
                <span><?=$total_orders; ?></span>
                <p>total orders placed</p>
                <a href="admin_order.php" class="btn">view orders</a>
          </div>
</div>
          
</div>
          
    </section>
  </div> <!-- Closing main-container div -->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <script src="../js/admin_script.js"></script>
  <?php include '../components/alert.php'; ?>
</body>
</html> 
