<?php
// Include database connection
require 'components/connect.php'; 

// Check if the user is logged in via cookie
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    header('Location: login.php');
    exit;
}

if (isset($_POST['delete_item'])) {
    $cart_id = $_POST['cart_id'];
    $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);

    // Check if the item exists in the wishlist
    $verify_delete = $con->prepare("SELECT * FROM `cart` WHERE `id` = ? AND `user_id` = ?");
    $verify_delete->bind_param("ii", $cart_id, $user_id);
    $verify_delete->execute();
    $result = $verify_delete->get_result();

    if ($result->num_rows > 0) {
        // Delete the specific item
        $delete_cart_id = $con->prepare("DELETE FROM `cart` WHERE `id` = ? AND `user_id` = ?");
        $delete_cart_id->bind_param("ii", $cart_id, $user_id);
        $delete_cart_id->execute();
        $success_msg = 'Item removed from cart';
    } else {
        $warning_msg[] = 'Item not found or already removed';
    }
}

if (isset($_POST['update_cart'])) {
    $cart_id = $_POST['cart_id'];
    $qty = $_POST['qty'];
    $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);
    $qty = filter_var($qty, FILTER_SANITIZE_NUMBER_INT);

    // Update cart quantity
    $update_cart = $con->prepare("UPDATE `cart` SET `qty` = ? WHERE `id` = ? AND `user_id` = ?");
    $update_cart->bind_param("iii", $qty, $cart_id, $user_id);
    $update_cart->execute();
    $success_msg = 'Cart updated successfully';
}
if (isset($_POST['empty_cart'])) {
      // Check if the item exists in the wishlist
      $verify_empty_item = $con->prepare("SELECT * FROM `cart` WHERE `user_id` = ?");
      $verify_empty_item->bind_param("i", $user_id);
      $verify_empty_item->execute();
      $result = $verify_empty_item->get_result();
  
      if ($result->num_rows > 0) {
          // Delete the specific item
          $delete_cart_id = $con->prepare("DELETE FROM `cart` WHERE `user_id` = ?");
          $delete_cart_id->bind_param("i", $user_id);
          $delete_cart_id->execute();
          $success_msg = 'Empty cart successfully';
      } else {
          $warning_msg[] = 'Your cart is already empty';
      }
  }
  

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delightful Creamery - Cart Page</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
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

.products .heading{
    text-align:center;
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
.box {
    width: 80px;
    flex: 1;
    text-align: center;
}

.box img {
    max-width: 100%;
    border-radius: 10px;
    box-shadow: var(--box-shadow);
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

.cart-total{
    text-align:center;
    padding:4%;
    margin:2rem;
    box-shadow:var(--box-shadow);
}
.cart-total p{
    font-size:1.5rem;
    margin:2rem 0;
    text-transform:capitalize;
}
.cart-total p span{
    color:var(--main-color);
    font-size:2rem;
    font-weight:bold;
}
.cart-total .button{
    display:flex;
    align-items:center;
    justify-content:center;
}
.cart-total .btn{
    margin: .5rem;
}
    </style>
</head>
<body>
    <?php include 'components/user_header.php'; ?>

    <div class="banner">
        <img src="image/banner.jpg" alt="Banner Image">
        <div class="detail">
            <h1>Cart Page</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur, assumenda repellendus, nemo adipisci possimus <br>atque ea porro quibusdam ratione debitis delectus architecto iure fuga nam cumque. Deleniti reprehenderit nesciunt quam!</p>
            <span><a href="home.php" class="btn">Home</a><i class="bx bx-right-arrow-alt"></i>Cart Products</span>
        </div>
    </div>

    <div class="products">
        <div class="heading">
            <h1>My Cart</h1>
            <img src="image/separator-img.png" alt="Separator">
        </div>

        <div class="box-container">
            <?php
            $grand_total = 0;

            // Fetch all cart items for the logged-in user
            $select_cart = $con->prepare("SELECT * FROM `cart` WHERE `user_id` = ?");
            $select_cart->bind_param("s", $user_id);
            $select_cart->execute();
            $result_cart = $select_cart->get_result();

            // Check if the result is valid and contains rows
            if ($result_cart && $result_cart->num_rows > 0) {
                // Loop through each cart item
                while ($fetch_cart = $result_cart->fetch_assoc()) {
                    $product_id = $fetch_cart['product_id'];

                    // Fetch the product details based on the product_id
                    $select_product = $con->prepare("SELECT * FROM `products` WHERE `id` = ?");
                    $select_product->bind_param("s", $product_id);
                    $select_product->execute();
                    $result_product = $select_product->get_result();

                    if ($result_product->num_rows > 0) {
                        // Fetch product details
                        $fetch_product = $result_product->fetch_assoc();
                        $sub_total = $fetch_cart['qty'] * $fetch_product['price']; // Calculate the subtotal for each product
                        $grand_total += $sub_total; // Add to grand total

                        // Display cart item
                        ?>
                            <form action="" method="post" class="box <?php if ($fetch_product['stock'] == 0) echo 'disabled'; ?>">
                            <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                            <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">

                            <img src="uploaded_files/<?= $fetch_product['image']; ?>" alt="<?= $fetch_product['name']; ?>" class="product-img">

                            <h3><?= $fetch_product['name']; ?></h3>

                            <?php if ($fetch_product['stock'] > 9) { ?>
                                <span class="stock in-stock">In Stock</span>
                            <?php } elseif ($fetch_product['stock'] == 0) { ?>
                                <span class="stock out-of-stock">Out of Stock</span>
                            <?php } else { ?>
                                <span class="stock low-stock">Hurry, only <?= $fetch_product['stock']; ?> left!</span>
                            <?php } ?>

                            <div class="content">
                                <p class="price">$<?= number_format($fetch_product['price'], 2); ?></p>
                                <input type="number" name="qty" required min="1" value="<?= $fetch_cart['qty']; ?>" max="99" class="qty">
                                <button type="submit" name="update_cart" class="bx bxs-edit fa-edit"></button>
                                <p class="sub-total">Subtotal: <span>$<?= number_format($sub_total, 2); ?></span></p>
                                <button type="submit" name="delete_item" class="btn" onclick="return confirm('Remove from cart?');">Delete <i class="bx bx-x"></i></button>
                            </div>
                        </form>
                        <?php
                    }
                }
            } else {
                echo '<div class="empty"><p>No products were added yet!</p></div>';
            }
            ?>
        </div>

        <?php if ($grand_total > 0) { ?>
            <div class="cart-total">
                <p>Total Amount Payable: <span>$<?= number_format($grand_total, 2); ?>/-</span></p>
                <div class="button">
                    <form action="" method="post">
                        <button type="submit" name="empty_cart" class="btn" onclick="return confirm('Are you sure to empty the cart?');">Empty Cart</button>
                    </form>
                    <a href="checkout.php" class="btn">Proceed to Checkout</a>
                </div>
            </div>
        <?php } ?>
    </div>

    <?php include 'components/alert.php'; ?>
    <?php include 'components/footer.php'; ?>
</body>
</html>