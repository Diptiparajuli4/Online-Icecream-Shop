<?php 
// Include database connection
require 'components/connect.php'; 

// Check for user ID from cookie
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

include 'components/add_to_wishlist.php'; 
include 'components/add_to_cart.php'; 

// Define product status to display only active products
$status = 'active'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blue Sky Summer - Our Shop Page</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   


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

        /* Banner Section Styling */
        .banner {
            position: relative;
            width: 100%;
            height: 60vh;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #333;
        }

        .banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
        }

        .banner .detail {
            position: relative;
            z-index: 2;
            text-align: center;
            color: #fff;
            padding: 20px;
        }

        .banner .detail h1 {
            font-size: 3rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }

        /* Products Section Styling */
        .products {
            padding: 2rem;
            text-align: center;
        }

        .products .heading {
            margin-bottom: 2rem;
        }

        .products .box-container {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            justify-content: center;
        }

        .products .box {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 350px;
            width: 100%;
            padding: 1rem;
            transition: transform 0.3s ease;
        }

        .products .box:hover {
            transform: scale(1.05);
        }

        .products .box img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }

        .products .box h3 {
            font-size: 1.5rem;
            margin: 1rem 0;
        }

        .products .box .price {
            font-size: 1.2rem;
            color: #333;
            margin: 0.5rem 0;
        }

        .products .box .stock {
            font-size: 1rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }
/* Flex Container for Buttons */
.flex-btn {
    display: flex;
    justify-content: center; /* Center align buttons horizontally */
    align-items: center; /* Vertically center buttons */
    gap: 1rem; /* Spacing between buttons */
    flex-wrap: wrap; /* Ensure buttons wrap on smaller screens */
    margin-top: 1rem; /* Add spacing above the button group */
}

/* Individual Button Styling */
.btn,
.icon-btn {
    display: inline-block;
    text-align: center;
    padding: 0.5rem 1rem;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    border: 1px solid #ccc; /* Light border for structure */
    background: none; /* No color changes */
}

/* Quantity Input Placement */
.qty {
    width: 3rem;
    height: 2rem;
    text-align: center;
    margin: 0 0.5rem; /* Spacing around the input field */
    border: 1px solid #ccc;
    border-radius: 3px;
    font-size: 1rem;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .flex-btn {
        flex-direction: column; /* Stack buttons vertically on smaller screens */
        gap: 0.8rem;
    }

    .btn,
    .icon-btn {
        width: 100%; /* Full width for easier clicks on mobile */
        padding: 0.6rem;
    }
}

    </style>
</head>

<body>

<!-- Include header -->
<?php include 'components/user_header.php'; ?>

<!-- Banner Section -->
<div class="banner">
    <img src="image/banner.jpg" alt="Banner Image">
    <div class="detail">
        <h1>Our Shop</h1>
        <p>Discover our premium ice cream flavors crafted with passion. Indulge in deliciousness!</p>
    </div>
</div>

<!-- Products Section -->
<div class="products">
    <div class="heading">
        <h1>Our Latest Flavours</h1>
    </div>
    <div class="box-container">
        <?php
        // Fetch products from database
        $select_products = $con->prepare("SELECT * FROM `products` WHERE status = ?");
        $select_products->bind_param('s', $status); 
        $select_products->execute();
        $result = $select_products->get_result();

        if ($result->num_rows > 0) {
            while ($fetch_products = $result->fetch_assoc()) {
                ?>
                <div class="box">
                    <img src="uploaded_files/<?= htmlspecialchars($fetch_products['image']); ?>" alt="Product Image">
                    <h3><?= htmlspecialchars($fetch_products['name']); ?></h3>
                    <p class="price">$<?= htmlspecialchars($fetch_products['price']); ?></p>
                    <?php if ($fetch_products['stock'] == 0) { ?>
                        <span class="stock" style="color: red;">Out of Stock</span>
                    <?php } elseif ($fetch_products['stock'] > 9) { ?>
                        <span class="stock" style="color: green;">In Stock</span>
                    <?php } else { ?>
                        <span class="stock" style="color: orange;">Hurry, only <?= htmlspecialchars($fetch_products['stock']); ?> left!</span>
                    <?php } ?>

                    <div class="flex-btn">
                        <!-- Add to Cart Button -->
                        <form method="POST" action="components/add_to_cart.php">
                            <input type="hidden" name="products[0][product_id]" value="<?= htmlspecialchars($fetch_products['id']); ?>">
                            <input type="number" name="products[0][qty]" class="qty" value="1" min="1" max="<?= htmlspecialchars($fetch_products['stock']); ?>" required>
                            <button type="submit" name="add_to_cart" class="icon-btn add-to-cart">
                                <i class="bx bx-cart"></i> Add to Cart
                            </button>
                        </form>
                        <!-- Add to Wishlist Button -->
                        <form method="POST" action="components/add_to_wishlist.php">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($fetch_products['id']); ?>">
                            <button type="submit" name="add_to_wishlist" class="icon-btn add-to-wishlist">
                                <i class="bx bx-heart"></i> Add to Wishlist
                            </button>
                        </form>

                        <!-- View Product Button -->
                        <a href="view_page.php?pid=<?= htmlspecialchars($fetch_products['id']); ?>"><i class="bx bxs-show"></i></a>
                    </div>

                    <!-- Buy Now Button -->
                    <a href="checkout.php?get_id=<?= htmlspecialchars($fetch_products['id']); ?>" class="btn">Buy Now</a>
                </div>
                <?php
            }
        } else {
            echo '<p class="empty">No products available!</p>';
        }
        ?>
    </div>
</div>

<!-- Include footer -->
<?php include 'components/footer.php'; ?>

</body>
</html>
