<?php
// Include database connection
require 'components/connect.php';

// Check for user ID from cookie
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    header('location:login.php');
    exit();
}

include 'components/add_to_cart.php';

if (isset($_POST['delete_item'])) {
    $wishlist_id = $_POST['wishlist_id'];
    $wishlist_id = filter_var($wishlist_id, FILTER_SANITIZE_STRING);

    // Check if the item exists in the wishlist
    $verify_delete = $con->prepare("SELECT * FROM `whitelist` WHERE `id` = ? AND `user_id` = ?");
    $verify_delete->bind_param("ss", $id, $user_id);
    $verify_delete->execute();
    $result = $verify_delete->get_result();

    if ($result->num_rows > 0) {
        // Delete the specific item
        $delete_wishlist_id = $con->prepare("DELETE FROM `whitelist` WHERE `id` = ? AND `user_id` = ?");
        $delete_wishlist_id->bind_param("ss", $id, $user_id);
        $delete_wishlist_id->execute();
        $success_msg = 'Item removed from wishlist';
    } else {
        $warning_msg[] = 'Item not found or already removed';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delightful Creamery- My Wishlist</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Header Section */
        header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }

        header .logo {
            font-size: 2rem;
            font-weight: bold;
            letter-spacing: 1px;
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
} /* Product Boxes Container */
 .products .heading {
    margin-bottom: 20px;
    text-align:center;
}

.products .box-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    padding: 20px;
    justify-items: center;
}

/* Product Box */
.products .box {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 1rem;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.products .box:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}

/* Product Image */
.products .box .product-img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 1rem;
}

/* Product Name */
.products .box h3 {
    font-size: 1.2rem;
    margin: 0.5rem 0;
    font-weight: bold;
}

/* Price */
.products .box .price {
    font-size: 1.2rem;
    color: #333;
    margin-bottom: 0.5rem;
}

/* Stock Status */
.products .box .stock {
    display: block;
    font-size: 1rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
    padding: 0.3rem;
    border-radius: 5px;
}

.products .box .in-stock {
    color: green;
    background: #eaffea;
}

.products .box .low-stock {
    color: orange;
    background: #fff4e5;
}

.products .box .out-of-stock {
    color: red;
    background: #ffe5e5;
}

/* Buttons */
.products .box .buttons {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin: 1rem 0;
}

.products .box .btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    text-decoration: none;  
    background-color: var(--pink-opacity);
    transition: background-color 0.3s ease;
}

.products .box .add-to-cart {
    color: var(--pink-color);
}

.products .box .add-to-cart:hover {
    color: #fff;
}

.products .box .view {
    color: var(--pink-color);
}

.products .box .view:hover {
    color: #fff;
}

.products .box .delete {
    color: var(--pink-color);
}

.products .box .delete:hover {
    color:  #fff;
}


/* Empty Wishlist */
.products .empty {
    text-align: center;
    font-size: 1.5rem;
    color: #555;
    margin-top: 2rem;
}


    </style>
</head>
<body>
<!-- Include header -->
<?php include 'components/user_header.php'; ?>

<div class="banner">
    <img src="image/banner.jpg" alt="Banner Image">
    <div class="detail">
        <h1>My Wishlist</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur, assumenda repellendus, nemo adipisci possimus <br> atque ea porro quibusdam ratione debitis delectus architecto iure fuga nam cumque. Deleniti reprehenderit nesciunt quam!</p>
        <span><a href="home.php" class="btn">Home</a><i class="bx bx-right-arrow-alt"></i>My Wishlist</span>
    </div>
</div>

<div class="products">
    <div class="heading">
        <h1>My Wishlist</h1>
        <img src="image/separator-img.png" alt="Separator">
    </div>
    <div class="box-container">
        <?php 
        $grand_total = 0;

        // Fetch wishlist items
        $select_wishlist = $con->query("SELECT * FROM `whitelist` WHERE `user_id` = '$user_id'");
        if ($select_wishlist->num_rows > 0) {
            while ($fetch_wishlist = $select_wishlist->fetch_assoc()) {
                $product_id = $fetch_wishlist['product_id'];
                $select_product = $con->query("SELECT * FROM `products` WHERE `id` = '$product_id'");

                if ($select_product->num_rows > 0) {
                    $fetch_product = $select_product->fetch_assoc();
                    ?>
                    <form action="" method="post" class="box <?php if ($fetch_product['stock'] == 0) echo 'disabled'; ?>">
                        <input type="hidden" name="wishlist_id" value="<?= $fetch_wishlist['id']; ?>">
                        <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">
                        
                        <img src="uploaded_files/<?= $fetch_product['image']; ?>" alt="<?= $fetch_product['name']; ?>" class="product-img">

                        <h3><?= $fetch_product['name']; ?></h3>

                        <?php 
                        if ($fetch_product['stock'] > 9) { ?>
                            <span class="stock in-stock">In Stock</span>
                        <?php } elseif ($fetch_product['stock'] == 0) { ?>
                            <span class="stock out-of-stock">Out of Stock</span>
                        <?php } else { ?>
                            <span class="stock low-stock">Hurry, only <?= $fetch_product['stock']; ?> left!</span>
                        <?php } ?>

                        <p class="price">$<?= number_format($fetch_product['price'], 2); ?></p>

                        <div class="buttons">
                            <button type="submit" name="add_to_cart" class="btn add-to-cart"><i class="bx bx-cart"></i></button>
                            <a href="view_page.php?pid=<?= htmlspecialchars($fetch_product['id']); ?>"><i class="bx bxs-show"></i></a>
                            <button type="submit" name="delete_item" class="btn delete" onclick="return confirm('Remove from wishlist?');"><i class="bx bx-x"></i></button>
                        </div>

                        <a href="checkout.php?get_id=<?= $fetch_product['id']; ?>" class="btn buy-now">Buy Now</a>
                    </form>
                    <?php
                    $grand_total += $fetch_wishlist['price'];
                }
            }
        } else {
            echo '<div class="empty"><p>No products added yet!</p></div>';
        }
        ?>
    </div>
</div>

<!-- Include footer -->
<?php include 'components/footer.php'; ?>

</body>
</html>
