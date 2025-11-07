<?php
// Include the database connection
require 'connect.php';

// Check if the user ID is set (user logged in)
$user_id = isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : '';

// Check if the "add to cart" form is submitted
if (isset($_POST['add_to_cart'])) {
    if ($user_id != '') { // Check if the user is logged in
        // Validate that 'products' exists and is an array
        if (isset($_POST['products']) && is_array($_POST['products'])) {
            $products = $_POST['products']; // Retrieve products array

            foreach ($products as $product) {
                // Sanitize product inputs
                $product_id = filter_var($product['product_id'], FILTER_SANITIZE_STRING);
                $qty = filter_var($product['qty'], FILTER_SANITIZE_NUMBER_INT);

                // Check if the product is already in the cart
                $verify_cart = $con->prepare("SELECT qty FROM cart WHERE user_id = ? AND product_id = ?");
                $verify_cart->bind_param("ss", $user_id, $product_id);
                $verify_cart->execute();
                $verify_cart_result = $verify_cart->get_result();

                if ($verify_cart_result->num_rows > 0) {
                    // If the product is already in the cart, update its quantity
                    $cart_row = $verify_cart_result->fetch_assoc();
                    $new_qty = $cart_row['qty'] + $qty;

                    $update_cart = $con->prepare("UPDATE cart SET qty = ? WHERE user_id = ? AND product_id = ?");
                    $update_cart->bind_param("iss", $new_qty, $user_id, $product_id);

                    if ($update_cart->execute()) {
                        $message = "Product quantity updated in your cart!";
                    } else {
                        $message = "Failed to update product quantity. Please try again!";
                    }
                } else {
                    // Check if cart has reached the maximum allowed items
                    $max_cart_items = $con->prepare("SELECT COUNT(*) AS item_count FROM cart WHERE user_id = ?");
                    $max_cart_items->bind_param("s", $user_id);
                    $max_cart_items->execute();
                    $max_cart_items_result = $max_cart_items->get_result();
                    $max_items_row = $max_cart_items_result->fetch_assoc();

                    if ($max_items_row['item_count'] >= 20) {
                        $message = "Your cart is full!";
                    } else {
                        // Fetch the product price
                        $select_price = $con->prepare("SELECT price FROM products WHERE id = ? LIMIT 1");
                        $select_price->bind_param("s", $product_id);
                        $select_price->execute();
                        $price_result = $select_price->get_result();

                        if ($price_result->num_rows > 0) {
                            $price_row = $price_result->fetch_assoc();
                            $price = $price_row['price'];

                            // Generate a unique ID for the cart item
                            $id = unique_id();

                            // Add the product to the cart
                            $insert_cart = $con->prepare("INSERT INTO cart (id, user_id, product_id, price, qty) VALUES (?, ?, ?, ?, ?)");
                            $insert_cart->bind_param("sssdi", $id, $user_id, $product_id, $price, $qty);

                            if ($insert_cart->execute()) {
                                $message = "Product added to your cart!";
                                echo "<script>location.reload()</script>";
                                
                            } else {
                                $message = "Failed to add product to your cart. Please try again!";
                            }
                        } else {
                            $message = "Product not found!";
                        }
                    }
                }
            }
        } else {
            // If 'products' is not set or not an array
            $message = "No products were selected to add to the cart.";
        }
    } else {
        // If user is not logged in, redirect to login page
        $message = "Please login to add products to your cart!";
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
