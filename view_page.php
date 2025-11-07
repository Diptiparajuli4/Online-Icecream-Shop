<?php 
// Include database connection
require 'components/connect.php'; 

// Check for user ID from cookies
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

// Check for product ID in the URL
if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
} else {
    $pid = '';
}

// Include other components
include 'components/add_to_wishlist.php';
include 'components/add_to_cart.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delightful Creamery- Product Detail Page</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
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
        .heading {
            margin-bottom: 20px;
            text-align: center;
        }

        .box {
            margin: 2rem auto;
            padding: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            max-width: 600px;
        }

        .img-box img {
            width: 100%;
            border-radius: 10px;
        }

        .view_page {
            background-image: url('image/bn3.3.webp');
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
            padding: 100px 6%;
        }
    </style>
</head>
<body>

<?php include 'components/user_header.php'; ?>

<div class="banner">
    <img src="image/banner.jpg" alt="Banner Image">
    <div class="detail">
        <h1>Product Detail</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur, assumenda repellendus, nemo adipisci possimus<br>atque ea porro quibusdam ratione debitis delectus architecto iure fuga nam cumque. Deleniti reprehenderit nesciunt quam!</p>
        <span><a href="home.php" class="btn">Home</a><i class="bx bx-right-arrow-alt"></i> Product Detail</span>
    </div>
</div>

<section class="view_page">
    <div class="heading">
        <h1>Product Detail</h1>
        <img src="image/separator-img.png">
    </div>

    <?php 
    // Fetch product details if product ID is valid
    if (!empty($pid)) {
        $select_product = $con->prepare("SELECT * FROM products WHERE id = ?");
        $select_product->bind_param("s", $pid);
        $select_product->execute();
        $result = $select_product->get_result();

        if ($result->num_rows > 0) {
            while ($fetch_product = $result->fetch_assoc()) {
    ?>
    <form action="" method="post" class="box">
        <div class="img-box">
            <img src="uploaded_files/<?= htmlspecialchars($fetch_product['image']) ?>" alt="Product Image">
        </div>
        <?php 
        if ($fetch_product['stock'] > 9) { ?>
            <span class="stock in-stock" style="color:green;">In Stock</span>
        <?php } elseif ($fetch_product['stock'] == 0) { ?>
            <span class="stock out-of-stock" style="color:red;">Out of Stock</span>
        <?php } else { ?>
            <span class="stock low-stock" style="color:red;">Hurry, only <?= $fetch_product['stock']; ?> left!</span>
        <?php } ?>
        <p class="price">$<?= htmlspecialchars($fetch_product['price']); ?>/-</p>
        <div class="name"><?= htmlspecialchars($fetch_product['name']); ?></div>
        <p class="product-detail"><?= htmlspecialchars($fetch_product['product_detail']); ?></p>
        <input type="hidden" name="product_id" value="<?= htmlspecialchars($fetch_product['id']); ?>">
        <div class="buttons">
            <button type="submit" name="add_to_wishlist" class="btn add-to-wishlist">Add to Wishlist<i class="bx bx-heart"></i></button>
            <input type="hidden" name="qty" value="1">
            <button type="submit" name="add_to_cart" class="btn add-to-cart">Add to Cart<i class="bx bx-cart"></i></button>
        </div>
        </div>
    </form>
    <?php
            }
        } 
    }?>
   </section>
   <div class="products">
    <div class="heading">
        <h1> similar products</h1>
        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quibusdam alias asperiores odit vitae sapiente quisquam voluptatum velit quis repellendus vero consequatur, animi tempore corrupti nobis, quae debitis accusantium neque autem?</p>
        <img src="image/separator-img.png">
</div>
<?php include 'components/shop.php';  ?>
</div>
    
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<?php include 'components/alert.php'; ?>
<?php include 'components/footer.php'; ?>
</body>
</html>
