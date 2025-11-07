<div class="products">
    <div class="box-container">
        <?php

        $status="active";
        // Fetch products from database
        $select_products = $con->prepare("SELECT * FROM `products` WHERE status = ? LIMIT 6");
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

