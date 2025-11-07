<?php 
include 'auth_check.php'; 
?>

<?php 

include '../components/connect.php'; 

// Check if seller_id cookie exists
if (isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
} else {
    header('location:login.php');
    exit; // Ensure the script stops after the redirect
}

// Add product to database
if (isset($_POST['publish'])) {
    $id = unique_id();
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);

    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);

    $stock = $_POST['stock'];
    $stock = filter_var($stock, FILTER_SANITIZE_STRING);
    $status = 'active';

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_files/' . $image;

    // Prepare and execute a query to check if the image already exists for the seller
    $select_image = $con->prepare("SELECT * FROM `products` WHERE image = ? AND seller_id = ?");
    $select_image->bind_param("si", $image, $seller_id);
    $select_image->execute();
    $result = $select_image->get_result();

    if (isset($image)) {
        if ($result->num_rows > 0) {
            $warning_msg[] = 'Image name repeated';
        } elseif ($image_size > 2000000) {
            $warning_msg[] = 'Image size is too large';
        } else {
            move_uploaded_file($image_tmp_name, $image_folder);
        }
    } else {
        $image = '';
    }

    if ($result->num_rows == 0 && $image != '') {
        // Insert product if image does not already exist
        $insert_product = $con->prepare("INSERT INTO `products` (id, seller_id, name, price, image, stock, product_detail, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $insert_product->bind_param("sisssiss", $id, $seller_id, $name, $price, $image, $stock, $description, $status);
        $insert_product->execute();
        $success_msg[] = 'Product inserted successfully';
    } else {
        $warning_msg[] = 'Rename your image';
    }
}

// Add product to database as draft
if (isset($_POST['draft'])) {
    $id = unique_id();
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);

    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);

    $stock = $_POST['stock'];
    $stock = filter_var($stock, FILTER_SANITIZE_STRING);
    $status = 'deactive';

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_files/' . $image;

    // Prepare and execute a query to check if the image already exists for the seller
    $select_image = $con->prepare("SELECT * FROM `products` WHERE image = ? AND seller_id = ?");
    $select_image->bind_param("si", $image, $seller_id);
    $select_image->execute();
    $result = $select_image->get_result();

    if (isset($image)) {
        if ($result->num_rows > 0) {
            $warning_msg[] = 'Image name repeated';
        } elseif ($image_size > 2000000) {
            $warning_msg[] = 'Image size is too large';
        } else {
            move_uploaded_file($image_tmp_name, $image_folder);
        }
    } else {
        $image = '';
    }

    if ($result->num_rows == 0 && $image != '') {
        // Insert product if image does not already exist
        $insert_product = $con->prepare("INSERT INTO `products` (id, seller_id, name, price, image, stock, product_detail, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $insert_product->bind_param("sisssiss", $id, $seller_id, $name, $price, $image, $stock, $description, $status);
        $insert_product->execute();
        $success_msg[] = 'Product saved as draft successfully';
    } else {
        $warning_msg[] = 'Rename your image';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delightful Creamery - Admin Add Products Page</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        .form-container {
            display: flex;
            justify-content: center;
            padding: 1rem;
        }

        .form-container form {
            width: 100%;
            max-width: 600px;
            background-color: var(--maincolor);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
        }

        .form-container .input-field {
            margin-bottom: 1.5rem;
        }

        .form-container .input-field p {
            font-size: 1rem;
            font-weight: 500;
            color: #555;
            margin-bottom: 0.5rem;
        }

        .form-container .input-field p span {
            color: #da6285;
        }

        .form-container .box {
            width: 100%;
            padding: 0.8rem;
            font-size: 1rem;
            color: #333;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
            transition: all 0.3s ease;
        }

        .form-container .box:focus {
            border-color: #da6285;
            box-shadow: 0px 0px 5px rgba(218, 98, 133, 0.4);
        }

        .form-container .input-field textarea {
            resize: vertical;
            min-height: 120px;
        }

        /* Button with Hover Effects */
        .btn {
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

        .btn::before {
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

        .btn:hover::before {
            width: 100%;
        }

        .btn:hover {
            color: rgb(14, 11, 12);
        }

        @media (max-width: 768px) {
            .main-container {
                padding: 1rem;
            }

            .form-container form {
                padding: 1.5rem;
            }

            .form-container .input-field p {
                font-size: 0.9rem;
            }

            .form-container .btn {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="dashboard">
            <div class="heading">
                <h1>Add Products</h1>
                <img src="../image/separator-img.png" alt="Separator">
            </div>
            <div class="form-container">
                <form action="" method="post" enctype="multipart/form-data" class="register">
                    <div class="input-field">
                        <p>Product Name<span>*</span></p>
                        <input type="text" name="name" maxlength="100" placeholder="Add product name" required class="box">
                    </div>
                    <div class="input-field">
                        <p>Product Price<span>*</span></p>
                        <input type="number" name="price" min="0" max="9999999999" placeholder="Enter Product Price" required class="box">
                    </div>
                    <div class="input-field">
                        <p>Product Stock<span>*</span></p>
                        <input type="number" name="stock" min="0" max="9999999999" placeholder="Enter available stock" required class="box">
                    </div>
                    <div class="input-field">
                        <p>Product Description<span>*</span></p>
                        <textarea name="description" placeholder="Enter Product Detail" class="box" required maxlength="5000" cols="30" rows="10"></textarea>
                    </div>
                    <div class="input-field">
                        <p>Product Image<span>*</span></p>
                        <input type="file" name="image" accept="image/*" class="box" required>
                    </div>
                    <button type="submit" name="publish" class="btn">Publish Product</button>
                    <button type="submit" name="draft" class="btn">Save As Draft</button>
                </form>
            </div>
        </section>
    </div>
    <script src="../js/admin_script.js"></script>
    <?php include '../components/alert.php';
    ?>

</body>
</html>
