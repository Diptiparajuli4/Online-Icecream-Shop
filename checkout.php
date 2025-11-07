<?php
// Include database connection
require 'components/connect.php';

session_start();

// Ensure user_id and seller_id are stored in the session after login
// Example:
$_SESSION['user_id'] = $user_id; // After successful user login
$_SESSION['seller_id'] = $seller_id; // After seller login

// Check if the user is logged in
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    header('location:login.php');
    exit;
}

if (isset($_POST['place_order'])) {
    // Sanitize input data
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $number = filter_var($_POST['number'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $address = filter_var(
        $_POST['flat'] . ',' . $_POST['street'] . ',' . $_POST['city'] . ',' . $_POST['country'],
        FILTER_SANITIZE_STRING
    );
    $address_type = filter_var($_POST['address_type'], FILTER_SANITIZE_STRING);
    $method = filter_var($_POST['method'], FILTER_SANITIZE_STRING);

    $grand_total = 0;

    if (isset($_GET['get_id'])) {
        // Single product checkout
        $product_id = intval($_GET['get_id']);
        $stmt = $con->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $seller_id = $product['seller_id']; // Correct seller_id fetched from product details
            $product_price = $product['price'];
            $qty = 1;

            $order_id = uniqid(); // Generate a unique order ID

            $stmt = $con->prepare("INSERT INTO `orders` 
                (id, user_id, seller_id, name, number, email, address, address_type, method, product_id, price, qty, dates, status, payment_status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'in progress', 'pending')");
            $stmt->bind_param(
                "sissssssssii",
                $order_id, $user_id, $seller_id, $name, $number, $email, $address, $address_type, $method,
                $product_id, $product_price, $qty
            );
            $stmt->execute();

            header('location:order.php');
            exit;
        } else {
            $warning_msg[] = 'Product not found!';
        }
    } else {
        // Cart checkout
        $stmt = $con->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($cart_item = $result->fetch_assoc()) {
                $product_id = $cart_item['product_id'];

                // Fetch product details to get the correct seller_id
                $product_stmt = $con->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
                $product_stmt->bind_param("i", $product_id);
                $product_stmt->execute();
                $product_result = $product_stmt->get_result();

                if ($product = $product_result->fetch_assoc()) {
                    $seller_id = $product['seller_id']; // Correct seller_id fetched from product details
                    $product_price = $product['price'];
                    $qty = $cart_item['qty'];

                    $order_id = uniqid(); // Generate a unique order ID

                    $insert_order_stmt = $con->prepare("INSERT INTO `orders` 
                        (id, user_id, seller_id, name, number, email, address, address_type, method, product_id, price, qty, dates, status, payment_status)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'in progress', 'pending')");
                    $insert_order_stmt->bind_param(
                        "sissssssssii",
                        $order_id, $user_id, $seller_id, $name, $number, $email, $address, $address_type, $method,
                        $product_id, $product_price, $qty
                    );
                    $insert_order_stmt->execute();
                }
            }

            // Clear the user's cart after placing the order
            $clear_cart_stmt = $con->prepare("DELETE FROM `cart` WHERE user_id = ?");
            $clear_cart_stmt->bind_param("i", $user_id);
            $clear_cart_stmt->execute();

            header('location:order.php');
            exit;
        } else {
            $warning_msg[] = 'Your cart is empty!';
        }
    }
}


$grand_total = 0;
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blue Sky Summer - Checkout Page</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    
</head>
<style>
        /* Styling for the checkout section */
.checkout {
   
    padding: 3rem 2rem;
    background-color: transparent;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin: 2rem auto;
    max-width: 900px;
    background-image: url('image/bg1.webp'); /* Optional background image */
    background-size: cover;
    background-position: center;
}

.checkout .heading {
    text-align: center;
  
}

.checkout .heading h1 {
    font-size: 2.5rem;
    color: #333;
    text-transform: uppercase;
    font-weight: bolder;
}

.checkout .heading img {
    margin-top: 1rem;
    width: 50px;
    width:23rem;
}

.checkout .row {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.checkout .row h3 {
    font-size: 1.8rem;
    text-align: center;
    margin-bottom: 1rem;
    font-weight: bold;
    color: var(--main-color);
}

.checkout .register .box {
    width: 100%;
    padding: 12px;
    margin-bottom: 1.2rem;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 1rem;
    background-color: #fff;
    transition: all 0.3s ease;
}

.checkout .register .box:focus {
    border-color: var(--main-color);
    outline: none;
}

.checkout .register .input-field p {
    margin-bottom: 0.5rem;
    font-weight: bold;
    color: #333;
}

.checkout button {
    
/*---- Button with Hover Effects from Second File ----*/
    background-color: var(--white-alpha-25); 
    border: 2px solid var(--white-alpha-40);
    backdrop-filter: var(--backdrop-filter); 
    color: var(--main-color);
    padding: 0.8rem 2rem;
    border-radius: 1.5rem;
    font-size: 20px;
    cursor: pointer;
    width: 100%;
    max-width: 300px;
    margin: 1rem auto;
    display: block;
    text-align: center;
    position: relative;
    transition: color 0.3s ease, background-color 0.3s ease;
}

.checkout button::before {
    position: absolute;
    content: '';
    top: 0;
    left: 0;
    height: 100%;
    width: 0;
    border-radius: 30px;
    background-color: var(--main-color); 
    z-index: -1;
    transition: width 0.3s ease;
}

.checkout button:hover::before {
    width: 100%;
}

.checkout button:hover {
    color: rgb(14, 11, 12);
}

.checkout .summary .name{
    font-size:2.2rem;
    color:var(--main-color);
    margin-bottom:.5rem;
    text-transform:capitalize;
    padding-bottom:1.5rem;
}
.checkout .summary h3{
    font-size:2.2rem;
    color:black;
    text-transform:capitalize;
    padding-bottom:1.5rem;
}
.checkout .summary .flex{
    display:flex;
    align-items:center;
    justify-content:center;
    padding:1rem 0;
}
.checkout .summary .flex img{
    box-shadow:var(--box-shadow);
    border-radius:50%;
    width:100px;
    height:100px;
    padding:.5rem;
    margin-right:2rem;
}
.checkout .summary .price{
    font-size:1.5rem;
    color:red;
}
.checkout .summary .grand-total{
    border-radius:.5rem;
    box-shadow:var(--box-shadow);
    display:flex;
    justify-content:center;
    flex-wrap:wrap;
    font-size:2rem;
    text-transform:capitalize;

}

.checkout .summary .grand-total p{
    color:red;
    margin-left:.5rem;
}


/* Responsive adjustments */
@media (max-width: 768px) {
    .checkout {
        padding: 2rem 1rem;
    }

    .checkout .heading h1 {
        font-size: 2rem;
    }

    .checkout .row h3 {
        font-size: 1.5rem;
    }

    .checkout .register .box {
        font-size: 1rem;
    }

    .checkout button {
        font-size: 1rem;
    }
}

   /* Styling for the form container */
.form-container {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    padding: 4% 0;
   
}

/* Form Styling */
.form-container form {
    background-color: rgba(255, 255, 255, 0.8);
    border: 2px solid rgba(255, 255, 255, 0.6);
    backdrop-filter: blur(10px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    border-radius: 8px;
    padding: 2rem;
    width: 100%;
    max-width: 500px;
    font-size: 16px;
    text-align: center;
    color: #333;
}

/* Form header */
.form-container form h3 {
    font-size: 2rem;
    margin-bottom: 2rem;
    color: var(--main-color);
    font-weight: bolder;
    text-transform: uppercase;
}

/* Input Fields */
.form-container form .box {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-container form .box:focus {
    border-color: var(--main-color);
    outline: none;
}

/* Select Fields */
.form-container form select.box {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 1rem;
    background-color: #fff;
    transition: all 0.3s ease;
}

.form-container form select.box:focus {
    border-color: var(--main-color);
    outline: none;
}



/* Responsive adjustments */
@media (max-width: 768px) {
    .form-container form {
        max-width: 90%;
        padding: 1.5rem;
    }

    .form-container form h3 {
        font-size: 1.5rem;
    }

    .form-container form .box {
        font-size: 1rem;
    }

    .form-container form button {
        font-size: 1rem;
    }
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
.heading {
    text-align: center;
    margin-bottom: 2rem;
}
.row h3{
    text-align: center;
    margin-bottom: 2rem;
}
/* Billing Details Section Styling */
.billing-details {

    padding: 3rem 2rem;
    background-color: transparent;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin: 2rem auto;
    max-width: 900px;
    background-image: url('image/bg1.webp'); /* Optional background image */
    background-size: cover;
    background-position: center;
   
}

.billing-details h3 {
    font-size: 2.2rem;
    color: var(--main-color);
    text-align: center;
    margin-bottom: 1.5rem;
    font-weight: bold;
    text-transform: uppercase;
}

.billing-details form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.billing-details .input-field {
    display: flex;
    flex-direction: column;
}

.billing-details .input-field p {
    font-size: 1rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 0.5rem;
}

.billing-details .box {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 1rem;
    background-color: #fff;
    transition: border-color 0.3s ease;
}

.billing-details .box:focus {
    border-color: var(--main-color);
    outline: none;
}

.billing-details button {
    background-color: var(--white-alpha-25); 
    border: 2px solid var(--white-alpha-40);
    backdrop-filter: var(--backdrop-filter); 
    color: var(--main-color);
    padding: 0.8rem 2rem;
    border-radius: 1.5rem;
    font-size: 1.2rem;
    cursor: pointer;
    width: 100%;
    max-width: 300px;
    margin: 1rem auto;
    display: block;
    text-align: center;
    position: relative;
    transition: color 0.3s ease, background-color 0.3s ease;
}

.billing-details button::before {
    position: absolute;
    content: '';
    top: 0;
    left: 0;
    height: 100%;
    width: 0;
    border-radius: 30px;
    background-color: var(--main-color); 
    z-index: -1;
    transition: width 0.3s ease;
}

.billing-details button:hover::before {
    width: 100%;
}

.billing-details button:hover {
    color: #fff;
}

/* Responsive Adjustments for Billing Details */
@media (max-width: 768px) {
    .billing-details {
        padding: 2rem 1rem;
    }

    .billing-details h3 {
        font-size: 1.8rem;
    }

    .billing-details .box {
        font-size: 1rem;
    }

    .billing-details button {
        font-size: 1rem;
    }
}


    </style>
<body>

<?php include 'components/user_header.php'; ?>

<div class="banner">
    <img src="image/banner.jpg" alt="Banner Image">
    <div class="detail">
        <h1>Checkout</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit...</p>
        <span>
            <a href="home.php" class="btn">Home</a>
            <i class="bx bx-right-arrow-alt">Checkout</i>
        </span>
    </div>
</div>

<div class="checkout">
    <div class="heading">
        <h1>Checkout Summary</h1>
        <img src="image/separator-img.png">
    </div>
    <div class="row">
        <!-- My Bag Section -->
        <div class="summary">
            <h3>My Bag</h3>
            <div class="box-container">
                <?php
                if (isset($_GET['get_id'])) {
                    $get_id = $_GET['get_id'];
                    $select_get = mysqli_query($con, "SELECT * FROM `products` WHERE id='$get_id'");
                    while ($fetch_get = mysqli_fetch_assoc($select_get)) {
                        $sub_total = $fetch_get['price'];
                        $grand_total+= $sub_total;
                        ?>
                        <div class="flex">
                            <img src="uploaded_files/<?php echo htmlspecialchars($fetch_get['image']); ?>" class="image">
                            <div>
                                <h3 class="name"><?php echo htmlspecialchars($fetch_get['name']); ?></h3>
                                <p class="price">$<?php echo htmlspecialchars($fetch_get['price']); ?>/-</p>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    $select_cart = mysqli_query($con, "SELECT * FROM `cart` WHERE user_id='$user_id'");
                    if (mysqli_num_rows($select_cart) > 0) {
                        while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                            $product_id = $fetch_cart['product_id'];
                            $select_products = mysqli_query($con, "SELECT * FROM `products` WHERE id='$product_id'");
                            $fetch_products = mysqli_fetch_assoc($select_products);
                            $sub_total = ($fetch_cart['qty'] * $fetch_products['price']);
                            $grand_total += $sub_total;
                            ?>
                            <div class="flex">
                                <img src="uploaded_files/<?php echo htmlspecialchars($fetch_products['image']); ?>" class="image">
                                <div>
                                    <h3 class="name"><?php echo htmlspecialchars($fetch_products['name']); ?></h3>
                                    <p class="price">RS.<?php echo htmlspecialchars($fetch_products['price']); ?> X <?php echo $fetch_cart['qty']; ?></p>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<p>Your cart is empty!</p>';
                    }
                }
                ?>
            </div>
            <div class="grand-total">
                <span>Total Amount Payable:</span>
                <p>RS.<?=$grand_total;?>/-</p>
            </div>
        </div>
            </div>
            </div>

        <!-- Billing Details Section -->
        <div class="billing-details">
            <h3>Billing Details</h3>
            <form action="" method="post" class="register">
                <input type="hidden" name="p_id" value="<?php echo isset($_GET['get_id']) ? htmlspecialchars($_GET['get_id']) : ''; ?>">
                <div class="input-field">
                    <p>Your Name</p>
                    <input type="text" name="name" required maxlength="50" placeholder="Enter your name" class="box">
                </div>
                <div class="input-field">
                    <p>Your Number</p>
                    <input type="number" name="number" required maxlength="10" placeholder="Enter your number" class="box">
                </div>
                <div class="input-field">
                    <p>Your Email</p>
                    <input type="email" name="email" required maxlength="50" placeholder="Enter your email" class="box">
                </div>
                <div class="input-field">
                    <p>Payment Method<span>*</span></p>
                    <select name="method" class="box">
                        <option value="cash on delivery">Cash on Delivery</option>
                        <option value="credit or debit card">Credit or Debit Card</option>
                        <option value="net banking">Net Banking</option>
                        <option value="UPI or RuPay">UPI or RuPay</option>
                        <option value="paytm">Paytm</option>
                    </select>
                </div>
                <div class="input-field">
                    <p>Address Type<span>*</span></p>
                    <select name="address_type" class="box">
                        <option value="home">Home</option>
                        <option value="office">Office</option>
                    </select>
                </div>
                <div class="input-field">
                    <p>Address Line 01<span>*</span></p>
                    <input type="text" name="flat" required maxlength="50" placeholder="e.g flat or building name" class="box">
                </div>
                <div class="input-field">
                    <p>Address Line 02<span>*</span></p>
                    <input type="text" name="street" required maxlength="50" placeholder="e.g street name" class="box">
                </div>
                <div class="input-field">
                    <p>City Name<span>*</span></p>
                    <input type="text" name="city" required maxlength="50" placeholder="e.g city name" class="box">
                </div>
                <div class="input-field">
                    <p>Country Name<span>*</span></p>
                    <input type="text" name="country" required maxlength="50" placeholder="e.g country name" class="box">
                </div>
                <div class="input-field">
                    <p>Pincode<span>*</span></p>
                    <input type="number" name="pin" required maxlength="6" placeholder="e.g 110011" class="box">
                </div>
                <form action="place_order.php" method="POST">
    <!-- Other form fields for user input -->
    <input type="" name="user_id" value="<?= $user_id; ?>">
    <button type="submit" name="place_order">Place Order</button>
</form>
            </form>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<?php include 'components/alert.php'; ?>
<?php include 'components/footer.php'; ?>

</body>
</html>
