<?php
// Include database connection
require 'components/connect.php';

// Check if the user is logged in
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    // Redirect to login if the user is not logged in
    header('location:login.php');
    exit();
}

// Check if an order ID is provided in the URL
if (isset($_GET['get_id'])) {
    $order_id = intval($_GET['get_id']); // Ensure the ID is an integer
} else {
    // Redirect to the orders page if no order ID is given
    header('location:order.php');
    exit();
}

// Fetch order details from the database using the provided order ID
$query_order = $con->prepare("SELECT * FROM `orders` WHERE id = ? AND user_id = ? LIMIT 1");
$query_order->bind_param("ii", $order_id, $user_id);
$query_order->execute();
$order_result = $query_order->get_result();

if ($order_result->num_rows > 0) {
    // If order found, fetch order details
    $order = $order_result->fetch_assoc();
    $product_id = $order['product_id'];

    // Fetch product details associated with the order
    $query_product = $con->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
    $query_product->bind_param("i", $product_id);
    $query_product->execute();
    $product_result = $query_product->get_result();

    if ($product_result->num_rows > 0) {
        // If product found, fetch product details
        $product = $product_result->fetch_assoc();
    } else {
        $product = null; // Handle case where product is not found
    }
} else {
    // Redirect back if no matching order is found
    header('location:order.php');
    exit();
}

// Handle cancel order request
if (isset($_POST['cancel'])) {
    // Update the order status to 'cancelled' in the database
    $query_cancel = $con->prepare("UPDATE `orders` SET `status` = 'cancelled' WHERE `id` = ? AND `user_id` = ?");
    $query_cancel->bind_param("ii", $order_id, $user_id);
    $query_cancel->execute();
    header('location:order.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Detail Page</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <style>
        /* Basic styling for the order details */
        .order-detail {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem;
        }
        .box {
            width: 80%;
            padding: 2rem;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        .box img {
            width: 100%;
            max-width: 300px;
            margin-bottom: 1rem;
        }
        .box .title {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        .box .price, .box .total-price, .box .quantity, .box .status, .box .date {
            font-size: 1.3rem;
            margin-top: 1rem;
        }
        .box .btn {
            margin-top: 1rem;
            padding: 10px 20px;
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .box .btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>

<body>

<?php include 'components/user_header.php'; ?>

<div class="order-detail">
    <h1>Order Detail</h1>

    <?php if (!empty($product)) { ?>
    <div class="box">
        <!-- Display product details -->
        <h3 class="title"><?= htmlspecialchars($product['name']); ?></h3>
        <img src="uploaded_files/<?= htmlspecialchars($product['image']); ?>" alt="Product Image">
        <p class="price">Price: <?= htmlspecialchars($product['price']); ?>/-</p>
        <p class="quantity">Quantity: <?= htmlspecialchars($order['qty']); ?></p>
        <p class="total-price">Total: <?= htmlspecialchars($product['price'] * $order['qty']); ?>/-</p>
        <p class="date"><i class="bx bxs-calendar-alt"></i> Order Date: <?= htmlspecialchars($order['date']); ?></p>

        <!-- Display order status with color indication -->
        <p class="status" style="color: <?php
            if ($order['status'] == 'delivered') {
                echo 'green';
            } elseif ($order['status'] == 'cancelled') {
                echo 'red';
            } else {
                echo 'orange';
            }
        ?>"><?= ucfirst($order['status']); ?></p>

        <!-- Display billing address and user info -->
        <p class="billing-address">Billing Address: <?= htmlspecialchars($order['address']); ?></p>
        <p class="user-phone">Phone: <?= htmlspecialchars($order['number']); ?></p>
        <p class="user-email">Email: <?= htmlspecialchars($order['email']); ?></p>

        <!-- Cancel Order button -->
        <?php if ($order['status'] != 'cancelled' && $order['status'] != 'delivered') { ?>
            <form action="" method="post">
                <button type="submit" name="cancel" class="btn" onclick="return confirm('Do you want to cancel this order?');">Cancel Order</button>
            </form>
        <?php } else { ?>
            <p class="status-message">Order cannot be cancelled as it is already <?= htmlspecialchars($order['status']); ?>.</p>
        <?php } ?>
    </div>
    <?php } else { ?>
        <p class="error">Product details not found!</p>
    <?php } ?>
</div>

<?php include 'components/footer.php'; ?>

</body>
</html>
