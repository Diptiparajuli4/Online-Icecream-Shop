<?php
include 'auth_check.php';
include '../components/connect.php';

// Check if seller_id cookie exists
if (isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
} else {
    header('location:login.php');
    exit;
}

// Update order from the database
if (isset($_POST['update_order'])) {
    $order_id = filter_var($_POST['order_id'], FILTER_SANITIZE_STRING);
    $update_payment = filter_var($_POST['update_payment'], FILTER_SANITIZE_STRING);

    $update_pay = $con->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ? AND seller_id = ?");
    $update_pay->bind_param("sii", $update_payment, $order_id, $seller_id);
    $update_pay->execute();
    $success_msg[] = 'Order payment updated successfully';
}

// Delete order from the database
if (isset($_POST['delete_order'])) {
    $delete_id = filter_var($_POST['order_id'], FILTER_SANITIZE_STRING);

    $verify_delete = $con->prepare("SELECT id FROM `orders` WHERE id = ? AND seller_id = ?");
    $verify_delete->bind_param("ii", $delete_id, $seller_id);
    $verify_delete->execute();
    $verify_delete_result = $verify_delete->get_result();

    if ($verify_delete_result->num_rows > 0) {
        $delete_order = $con->prepare("DELETE FROM `orders` WHERE id = ? AND seller_id = ?");
        $delete_order->bind_param("ii", $delete_id, $seller_id);
        $delete_order->execute();
        $success_msg[] = 'Order deleted successfully';
    } else {
        $warning_msg[] = 'Order already deleted or not found';
    }
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
                <h1>total orders placed</h1>             
                <img src="../image/separator-img.png" alt="Separator">         
            </div>         
            
            <div class="box-container">
    <?php
    // Fetch orders for the seller
    $select_order = $con->prepare("SELECT * FROM `orders` WHERE seller_id = ?");
    $select_order->bind_param("i", $seller_id);
    $select_order->execute();
    $result = $select_order->get_result();

    if ($result->num_rows > 0) {
        while ($fetch_order = $result->fetch_assoc()) {
    ?>
            <div class="box">
                <div class="status" style="color: <?= ($fetch_order['status'] == 'in progress') ? 'limegreen' : 'red'; ?>">
                    <?= htmlspecialchars($fetch_order['status']); ?>
                </div>
                <div class="details">
                    <p>User Name: <span><?= htmlspecialchars($fetch_order['name']); ?></span></p>
                    <p>User ID: <span><?= htmlspecialchars($fetch_order['user_id']); ?></span></p>
                    <p>Placed On: <span><?= htmlspecialchars($fetch_order['dates']); ?></span></p>
                    <p>User Number: <span><?= htmlspecialchars($fetch_order['number']); ?></span></p>
                    <p>User Email: <span><?= htmlspecialchars($fetch_order['email']); ?></span></p>
                    <p>Price: <span><?= htmlspecialchars($fetch_order['price']); ?></span></p>
                    <p>Method: <span><?= htmlspecialchars($fetch_order['method']); ?></span></p>
                    <p>Address: <span><?= htmlspecialchars($fetch_order['address']); ?></span></p>
                </div>
                <form action="" method="post">
                    <input type="hidden" name="order_id" value="<?= $fetch_order['id']; ?>">
                    <select name="update_payment" class="box" style="width:90%;">
                        <option disabled selected><?= htmlspecialchars($fetch_order['payment_status']); ?></option>
                        <option value="pending">Pending</option>
                        <option value="order delivered">Order Delivered</option>
                    </select>
                    <div class="flex-btn">
                        <input type="submit" name="update_order" value="Update Payment" class="btn">
                        <input type="submit" name="delete_order" value="Delete Order" class="btn" onclick="return confirm('Delete this order?');">
                    </div>
                </form>
            </div>
    <?php
        }
    } else {
        echo '<div class="empty"><p>No orders placed yet!</p></div>';
    }
    ?>
</div>

        </section>   
    </div> <!-- Closing main-container div -->   

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>   
    <script src="../js/admin_script.js"></script>   
    <?php include '../components/alert.php'; ?> 
</body> 
</html>
