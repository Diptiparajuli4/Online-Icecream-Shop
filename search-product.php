<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

include 'components/add_to_wishlist.php';
include 'components/add_to_cart.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delightful Creamery - Search Products Page</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css?v=<?php echo time(); ?>">     
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
</head>
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
    position: relative;
    margin-left: 4rem; /* Increased left margin to move the text further left */
    z-index: 1; 
    text-align: center;
    color: #fff;
    background: transparent;
    padding: 20px;
    border-radius: 8px;
}

.detail h1 {
    font-size: 3rem;
    margin-bottom: 10px;
    text-align:center;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
}

.detail p {
    font-size: 1.2em;
    line-height: 1.5;
    margin-bottom: 10px;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
}

.detail a {
    text-decoration: none;
    font-weight: bold;
    padding: 10px 20px;
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
</style>
<body>
<?php include 'components/user_header.php'; ?>

<div class="banner">
    <img src="image/banner.jpg" alt="Banner Image">
    <div class="detail">
        <h1>Search Products Page</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
        <span><a href="home.php" class="btn">Home</a><i class="bx bx-right-arrow-alt"></i> Search Products </span>
    </div>
</div>

<div class="products">
    <div class="heading">
        <h1>Search Results</h1>
        <img src="image/separator-img.png">
    </div>
    <div class="box-container">
        <?php
        if (isset($_POST['search_product']) && !empty($_POST['search_product'])) {
            $search_products = $_POST['search_product'];
            $search_products = mysqli_real_escape_string($con, $search_products);

            $stmt = $con->prepare("SELECT * FROM `products` WHERE `name` LIKE ? AND `status` = ?");
            $search_term = "%$search_products%";
            $status = "active";
            $stmt->bind_param("ss", $search_term, $status);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($fetch_products = $result->fetch_assoc()) {
                    ?>
                    <form action="" method="post" class="box">
                        <div class="img-box">
                            <img src="uploaded_files/<?= htmlspecialchars($fetch_products['image']) ?>" alt="Product Image">
                        </div>
                        <div class="details">
                            <?php 
                            if ($fetch_products['stock'] > 9) { ?>
                                <span class="stock in-stock" style="color:green;">In Stock</span>
                            <?php } elseif ($fetch_products['stock'] == 0) { ?>
                                <span class="stock out-of-stock" style="color:red;">Out of Stock</span>
                            <?php } else { ?>
                                <span class="stock low-stock" style="color:red;">Hurry, only <?= $fetch_products['stock']; ?> left!</span>
                            <?php } ?>
                            <p class="price">$<?= htmlspecialchars($fetch_products['price']); ?>/-</p>
                            <div class="name"><?= htmlspecialchars($fetch_products['name']); ?></div>
                            <p class="product-detail"><?= htmlspecialchars($fetch_products['product_detail']); ?></p>
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($fetch_products['id']); ?>">
                            <input type="hidden" name="qty" value="1">
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

                            </div>
                        </div>
                    </form>
                    <?php
                }
            } else {
                echo '<div class="empty"><p>No products found.</p></div>';
            }
            $stmt->close();
        } else {
            echo '<div class="empty"><p>Please enter a product name to search.</p></div>';
        }
        ?>
    </div>
</div>

<?php include 'components/footer.php'; ?>
</body>
</html>
