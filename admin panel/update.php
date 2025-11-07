<?php
include 'auth_check.php'; 
include '../components/connect.php'; 

// Check if seller_id cookie exists
if (isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
} else {
    header('location:login.php');
    exit; // Ensure the script stops after the redirect
}

if (isset($_POST['submit'])) {
    $product_id = $_POST['product_id'];  // Assuming product_id is being passed in the form
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = unique_id() . '.' . $ext;
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_files/' . $rename;

    // Check if product exists and belongs to the current seller
    $check_product = $con->prepare("SELECT * FROM `products` WHERE seller_id = ? AND id = ? LIMIT 1");
    $check_product->bind_param("ii", $seller_id, $product_id);
    $check_product->execute();
    $result = $check_product->get_result();

    if ($result->num_rows > 0) {
        // Product exists and belongs to this seller, proceed with updating

        // Update product name if provided
        if (!empty($name)) {
            $update_name = $con->prepare("UPDATE `products` SET name = ? WHERE id = ? AND seller_id = ?");
            $update_name->bind_param("sii", $name, $product_id, $seller_id);
            $update_name->execute();
            $success_msg[] = 'Product name updated successfully';
        }

        // Update product price if provided
        if (!empty($price)) {
            $update_price = $con->prepare("UPDATE `products` SET price = ? WHERE id = ? AND seller_id = ?");
            $update_price->bind_param("dii", $price, $product_id, $seller_id);  // price is a float
            $update_price->execute();
            $success_msg[] = 'Product price updated successfully';
        }

        // Update product image if a new image is uploaded
        if (!empty($image)) {
            if ($image_size > 2000000) {
                $warning_msg[] = 'Image size is too large';
            } else {
                $update_image = $con->prepare("UPDATE `products` SET image = ? WHERE id = ? AND seller_id = ?");
                $update_image->bind_param("sii", $rename, $product_id, $seller_id);
                $update_image->execute();
                move_uploaded_file($image_tmp_name, $image_folder);

                // Remove the old image if it exists and it's different from the new one
                $prev_image = $result->fetch_assoc()['image'];
                if ($prev_image != '' && $prev_image != $rename) {
                    unlink('../uploaded_files/' . $prev_image);
                }
                $success_msg[] = 'Product image updated successfully';
            }
        }

        // If there's any new information, execute the changes and return a success message
        if (isset($success_msg)) {
            foreach ($success_msg as $msg) {
                echo "<script>alert('$msg');</script>";
            }
        }

    } else {
        $warning_msg[] = 'Product not found for this seller!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="form-container">
            <div class="heading">
                <h1>Update Product Details</h1>
                <img src="../image/separator-img.png" alt="Separator">
            </div>
            <form action="" method="post" enctype="multipart/form-data" class="register">
                <div class="input-field">
                    <p>Enter Product ID <span>*</span></p>
                    <input type="text" name="product_id" class="box" placeholder="Enter product ID" required>
                </div>
                
                <div class="input-field">
                    <p>Enter Product Name <span>*</span></p>
                    <input type="text" name="name" class="box" placeholder="Enter product name" required>
                </div>

                <div class="input-field">
                    <p>Enter Product Price <span>*</span></p>
                    <input type="number" step="0.01" name="price" class="box" placeholder="Enter product price" required>
                </div>

                <div class="input-field">
                    <p>Update Product Image <span>*</span></p>
                    <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
                </div>

                <input type="submit" name="submit" value="Update Product" class="btn">
            </form>
        </section>
    </div>
</body>
</html>
