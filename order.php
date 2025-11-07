<?php
// Include database connection
require 'components/connect.php';

// Check if user is logged in
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
    header('location:login.php');
    exit; // Stop script after redirect
}

// Update order quantity (if needed)
if (isset($_POST['update_quantity'])) {
    $order_id = filter_var($_POST['order_id'], FILTER_SANITIZE_STRING);
    $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_STRING);
    $update_qty = filter_var($_POST['update_qty'], FILTER_SANITIZE_NUMBER_INT);

    // Update the quantity for the specific product in the order
    if ($update_qty > 0) {
        $update_qty_sql = $con->prepare("UPDATE `orders` SET qty = ? WHERE id = ? AND product_id = ? AND user_id = ?");
        $update_qty_sql->bind_param("iiii", $update_qty, $order_id, $product_id, $user_id);
        $update_qty_sql->execute();
        $success_msg[] = 'Order quantity updated successfully';
    } else {
        $warning_msg[] = 'Quantity must be greater than zero';
    }
}

// Delete specific product from the order
if (isset($_POST['delete_product'])) {
    $order_id = filter_var($_POST['order_id'], FILTER_SANITIZE_STRING);
    $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_STRING);

    // Verify if the order and product exist for the logged-in user
    $verify_delete = $con->prepare("SELECT id FROM `orders` WHERE id = ? AND product_id = ? AND user_id = ?");
    $verify_delete->bind_param("iii", $order_id, $product_id, $user_id);
    $verify_delete->execute();
    $verify_delete_result = $verify_delete->get_result();

    if ($verify_delete_result->num_rows > 0) {
        // Delete the specific product from the order
        $delete_product = $con->prepare("DELETE FROM `orders` WHERE id = ? AND product_id = ? AND user_id = ?");
        $delete_product->bind_param("iii", $order_id, $product_id, $user_id);
        $delete_product->execute();
        $success_msg[] = 'Product deleted from order successfully';
    } else {
        $warning_msg[] = 'Product not found in this order';
    }
}
?>

<!DOCTYPE html> 
<html lang="en"> 
<head>     
    <meta charset="UTF-8">     
    <meta name="viewport" content="width=device-width, initial-scale=1.0">     
    <title>User Orders</title>     
    <link rel="stylesheet" type="text/css" href="css/user_style.css">     
</head> 
<style><style>
        /* Seller Profile Section */
        .user {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-bottom: 20px;
            width: 250px;
            margin: 0 auto;
        }

        /* Profile Image Styling */
        .user img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #ddd;
            margin-bottom: 10px;
        }

        /* Seller Name Styling */
        .user .name {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .user span {
            display: block;
            font-size: 1rem;
            color: #888;
            margin-bottom: 10px;
        }

        /* Update Profile Button Styling */
        .user .btn {
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
            margin-top: 15px;
        }

        .user .btn:hover {
            background-color: #ff5049;
        }

        /* General Section Styling */
        .details {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: #f7f7f7;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .details .user {
            text-align: center;
            margin-bottom: 30px;
        }

        .details .flex {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .details .box {
            flex: 1;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .details .box span {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
        }

        .details .box p {
            font-size: 1rem;
            color: #888;
        }

        .details .box .btn {
            margin-top: 10px;
        }
        
    .form-container {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    padding: 4% 0;
    position: relative;
    background-image:url('image/bg1.webp');
    background-position:center;
}

.form-container form {
    background-color: var(--white-alpha-25);
    border: 2px solid var(--white-alpha-40);
    backdrop-filter: var(--backdrop-filter);
    box-shadow: var(--box-shadow);
    border-radius: .5rem;
    padding: 2rem;
    width: 500px;
    font-size: 25px;
}

.form-container .login {
    width: 150rem;
}
.form-container .box {
    font-size: 25px;
    width:400px;
}
.form-container .register {
    width: 180rem;
}

.form-container form h3 {
    text-align: center;
    font-size: 3rem;
    margin-bottom: 5rem;
    color: var(--main-color);
    text-transform: capitalize;
    font-weight: bolder;
}

.form-container form .btn {
    width: 100%;
    font-size: 1.3rem;
}


        /* Styling for the banner section */
.banner {
    position: relative;
    width: 100%;
    height: 60vh; /* Adjust height as needed */
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #333;
}

.banner img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Ensures the image covers the entire banner area */
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
}

.detail {
    position: relative; /* corrected from 'position: left' to 'relative' */
    margin-left: 4rem; /* Increased left margin to move the text further left */
    z-index: 1; /* Ensures the text stays above the image */
    text-align: center;
    color: #fff;
    background: transparent; /* No background */
    padding: 20px;
    border-radius: 8px;
}


.detail h1 {
    font-size: 3rem;
    margin-bottom: 10px;
    text-align:center;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7); /* Text shadow for better readability */
}


.detail h1 :hover{
   color:var(--pink-opacity);
}


.detail p {
    font-size: 1.2em;
    line-height: 1.5;
    margin-bottom: 10px;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
}
.detail p :hover{
   color:var(--pink-opacity);
}
.detail a {
    
    text-decoration: none;
    font-weight: bold;
    padding: 10px 20px;
   
}
.detail i {
    margin-left: 10px;
}
.detail span {
    display: flex; /* Use flexbox to align items in a row */
    align-items: center; /* Vertically align items */
}


.detail i {
    margin: 0 1px; /* Adds space between the arrow and the text */
    font-size: 1.5rem; /* Adjust arrow icon size */
    color: var(--pink-color); /* White color for arrow icon */
}

.detail span:last-child {
    margin-right:2px; /* Add space between the arrow and "About Us" text */
    color: var(--pink-color);
    font-size:1.5rem;
}


/* Responsive adjustments */
@media (max-width: 768px) {
    .banner {
        height: 40vh;
    }

    .detail h1 {
        font-size: 2em;
    }

    .detail p {
        font-size: 1em;
    }
}
.dashboard .heading {
    margin-bottom: 20px;
    text-align:center;
}

.dashboard .heading h1 {
    font-size: 2.5rem;
    font-weight: bold;
    text-align:center;
    color: black; /* White text for heading on dark background */
    margin-bottom: 10px;
}/* Order section */
.order {
    padding: 2rem;
    background-color: #f9f9f9;
}

.order .heading {
    margin-bottom: 2rem;
    text-align: center;
}
/* Styling for the product images within the order box */
.order .orders .box img {
    width: 25px;
    height: 100px; /* Set a fixed height for uniformity */
    object-fit: cover; /* Ensures the image covers the assigned area without distortion */
    border-radius: 8px;
    margin-bottom: 1rem; /* Adds space below the image */
}

.order .heading h1 {
    font-size: 2.5rem;
    color: var(--main-color);
    font-weight: bold;
    margin-bottom: 1rem;
}

.order .orders {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.order .orders .box-container {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    justify-content: center;
}

.order .orders .box {
    background-color: white;
    border-radius: 8px;
    padding: 1.5rem;
    width: 300px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
    position: relative;
    transition: transform 0.3s;
}

.order .orders .box:hover {
    transform: translateY(-5px);
}

.order .orders .box img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
}

.order .orders .box .content {
    padding-top: 1rem;
}

.order .orders .box .content h3 {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.order .orders .box .content p {
    margin: 0.5rem 0;
}

.order .orders .box .content .qty,
.order .orders .box .content .price,
.order .orders .box .content .total-price {
    font-size: 1.1rem;
}

.order .orders .box .content .address,
.order .orders .box .content .method {
    font-size: 1rem;
}

.order .orders .box .content .payment-status {
    font-size: 1rem;
    font-weight: bold;
}

.order .orders .box .content .status {
    font-size: 1.2rem;
    font-weight: bold;
    margin-top: 1rem;
}

.order .orders .box .content .status[data-status="delivered"] {
    color: green;
}

.order .orders .box .content .status[data-status="cancelled"] {
    color: red;
}

.order .orders .box .content .status[data-status="pending"] {
    color: orange;
}

.order .orders .box form {
    margin-top: 1rem;
}

.order .orders .box form .flex-btn {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
}

.order .orders .box form input[type="number"] {
    padding: 0.5rem;
    font-size: 1rem;
    width: 80%;
    margin-bottom: 1rem;
    border-radius: 8px;
    border: 1px solid #ddd;
}

.order .orders .box .warning-msg,
.order .orders .box .success-msg {
    color: red;
    font-size: 1rem;
    margin-top: 1rem;
    text-align: center;
}

.order .orders .box .empty {
    font-size: 1.2rem;
    color: #555;
    text-align: center;
    margin-top: 2rem;
}



   
    </style>

</head>
<?php include 'components/user_header.php'; ?>
<div class="banner">
    <img src="image/banner.jpg" alt="Banner Image">
    <div class="detail">
        <h1>Order Page</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur, assumenda repellendus, nemo adipisci possimus <br>atque ea porro quibusdam ratione debitis delectus architecto iure fuga nam cumque. Deleniti reprehenderit nesciunt quam!</p>
        <span><a href="home.php" class="btn">Home</a><i class="bx bx-right-arrow-alt"></i>Order </span>
    </div>
</div>
<body>
    <div class="main-container">
        <?php include 'components/user_header.php'; ?>
        <section class="dashboard">
            <div class="heading">
                <h1>Order Details</h1>
                <img src="image/separator-img.png" alt="Separator">
            </div> 
            <div class="box-container">
                <?php
                // Fetch orders for the user
                $select_orders = $con->prepare("
                    SELECT 
                        o.id, 
                        o.product_id, 
                        o.qty, 
                        o.price, 
                        o.dates, 
                        o.status, 
                        o.address, 
                        o.method, 
                        o.payment_status 
                    FROM orders o
                    WHERE o.user_id = ?
                    ORDER BY o.dates DESC
                ");

                $select_orders->bind_param('i', $user_id);
                $select_orders->execute();
                $result = $select_orders->get_result();

                if ($result->num_rows > 0) {
                    while ($fetch_orders = $result->fetch_assoc()) {
                        // Fetch product details separately
                        $product_id = $fetch_orders['product_id'];
                        $select_product = $con->prepare("SELECT name, image FROM products WHERE id = ?");
                        $select_product->bind_param('i', $product_id);
                        $select_product->execute();
                        $product_result = $select_product->get_result();

                        if ($product_result->num_rows > 0) {
                            $product = $product_result->fetch_assoc();
                            ?>
                            <div class="box" <?php if ($fetch_orders['status'] == 'cancelled') { echo 'style="border:2px solid red"'; } ?>>
                                <img src="uploaded_files/<?=$product['image']?>" class="image">
                                <div class="content">
                                    <h3 class="name"><?=$product['name'];?></h3>
                                    <p class="date">Date: <?=$fetch_orders['dates'];?></p>
                                    <p class="price">Price: <?=$fetch_orders['price'];?>/-</p>
                                    <p class="qty">Quantity: <?=$fetch_orders['qty'];?></p>
                                    <p class="total-price">Total: <?=$fetch_orders['price'] * $fetch_orders['qty'];?>/-</p>
                                    <p class="address">Delivery Address: <?=$fetch_orders['address'];?></p>
                                    <p class="method">Payment Method: <?=$fetch_orders['method'];?></p>
                                    <p class="payment-status">
                                        Payment Status: 
                                        <?php
                                        if ($fetch_orders['payment_status'] == 1) {
                                            echo "<span style='color: green;'>Paid</span>";
                                        } else {
                                            echo "<span style='color: red;'>Pending</span>";
                                        }
                                        ?>
                                    </p>
                                    <p class="status" style="color:<?php 
                                        if($fetch_orders['status'] == 'delivered') {
                                            echo "green";
                                        } elseif($fetch_orders['status'] == 'cancelled') {
                                            echo "red";
                                        } else {
                                            echo "orange";
                                        }?>">
                                        <?=$fetch_orders['payment_status'];?>
                                    </p>
                                </div>
                                <form method="POST">
                                    <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                                    <input type="hidden" name="product_id" value="<?= $fetch_orders['product_id']; ?>">
                                    <label for="update_qty">Update Quantity:</label>
                                    <input type="number" name="update_qty" value="<?= $fetch_orders['qty']; ?>" min="1" required>
                                    <div class="flex-btn">
                                        <input type="submit" name="update_quantity" value="Update Quantity" class="btn">
                                        <input type="submit" name="delete_product" value="Delete Product" class="btn" onclick="return confirm('Delete this product from the order?');">
                                    </div>
                                </form>
                            </div>
                            <?php
                        }
                    }
                } else {
                    echo '<p class="empty">No orders placed yet!</p>';
                }
                ?>
            </div>
        </div>
    </div>

    <?php include 'components/footer.php'; ?>
</body>
</html>
