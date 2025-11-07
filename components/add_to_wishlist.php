<?php
// Include database connection
require_once 'connect.php';

// Check if the user ID is set (user logged in)
$user_id = isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : '';

// Check if the "add to wishlist" form is submitted
if (isset($_POST['add_to_wishlist'])) {
    if ($user_id != '') { // Check if the user is logged in
        $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_STRING);

        // Fetch product price from the database based on the product_id
        $fetch_price = $con->prepare("SELECT price FROM `products` WHERE id = ?");
        $fetch_price->bind_param("i", $product_id);
        $fetch_price->execute();
        $fetch_price_result = $fetch_price->get_result();

        // If product exists, get its price
        if ($fetch_price_result->num_rows > 0) {
            $product_data = $fetch_price_result->fetch_assoc();
            $price = $product_data['price'];
            
            // Check if the product is already in the wishlist
            $verify_wishlist = $con->prepare("SELECT * FROM `whitelist` WHERE user_id = ? AND product_id = ?");
            $verify_wishlist->bind_param("ss", $user_id, $product_id);
            $verify_wishlist->execute();
            $result = $verify_wishlist->get_result();

            if ($result->num_rows > 0) {
                $message = "Product is already in your wishlist!";
            } else {
                // Generate a unique ID for the wishlist entry
                $id = unique_id();

                // Add the product to the wishlist
                $insert_wishlist = $con->prepare("INSERT INTO `whitelist` (id, user_id, product_id, price) VALUES (?, ?, ?, ?)");
                $insert_wishlist->bind_param("sssi", $id, $user_id, $product_id, $price);

                if ($insert_wishlist->execute()) {
                    $message = "Product added to your wishlist!";
                } else {
                    $message = "Failed to add product to your wishlist. Please try again!";
                }
            }
        } else {
            $message = "Product not found!";
        }
    } else {
        // If user is not logged in, redirect to login page
        $message = "Please login to add products to your wishlist!";
        header("Location: login.php");
        exit;
    }

    // Display a message as an alert if set
    if (isset($message)) {
        echo "<script>alert('$message');</script>";
        echo "<script>window.history.back();</script>"; // Redirect back to the previous page
    }
}
?>

