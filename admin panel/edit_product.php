<?php 
include 'auth_check.php'; 
?>

<?php  
include '../components/connect.php';   

// Check if seller_id cookie exists 
if (isset($_COOKIE['seller_id'])) {     
    $seller_id = $_COOKIE['seller_id']; 
} else {     
    echo 'No seller_id cookie found. Redirecting to login.';     
    header('location:login.php');     
    exit; 
}  

// Fetch the product data based on the selected product ID 
$product_id = $_GET['id'] ?? null; 
if ($product_id) {     
    echo "Fetching data for product ID: " . $product_id . " and Seller ID: " . $seller_id;     
    // Prepare the SELECT query     
    $select_product = $con->prepare("SELECT * FROM `products` WHERE id = ? AND seller_id = ?");     
    $select_product->bind_param("ii", $product_id, $seller_id);     
    $select_product->execute();     
    $result = $select_product->get_result();      

    if ($result->num_rows > 0) {         
        $fetch_products = $result->fetch_assoc(); // Fetch the data     
    } else {         
        // No product found or permission issue         
        echo '<p class="empty">Product not found or you don\'t have permission to edit this product!</p>';         
        exit;     
    } 
} else {     
    echo "Product ID is missing!";     
    exit; 
}  

// Update product in the database if the form is submitted 
if (isset($_POST['update'])) {     
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);     
    $price = filter_var($_POST['price'], FILTER_SANITIZE_STRING);     
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);     
    $stock = filter_var($_POST['stock'], FILTER_SANITIZE_STRING);     
    $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);      

    // Handle the uploaded image     
    $image = $_FILES['image']['name'];     
    $image_size = $_FILES['image']['size'];     
    $image_tmp_name = $_FILES['image']['tmp_name'];     
    $image_folder = '../uploaded_files/' . $image;      

    // Check if an image is uploaded     
    if ($image) {         
        if ($image_size > 2000000) {             
            echo 'Image size is too large. Please upload an image smaller than 2MB.';         
        } else {             
            move_uploaded_file($image_tmp_name, $image_folder);             
            // Update product with new image             
            $update_product = $con->prepare("UPDATE `products` SET name = ?, price = ?, image = ?, stock = ?, product_detail = ?, status = ? WHERE id = ? AND seller_id = ?");             
            $update_product->bind_param("sssissii", $name, $price, $image, $stock, $description, $status, $product_id, $seller_id);         
        }     
    } else {         
        // Update product without changing the image         
        $update_product = $con->prepare("UPDATE `products` SET name = ?, price = ?, stock = ?, product_detail = ?, status = ? WHERE id = ? AND seller_id = ?");         
        $update_product->bind_param("ssissii", $name, $price, $stock, $description, $status, $product_id, $seller_id);     
    }      

    if ($update_product->execute()) {         
        echo 'Product updated successfully!';     
    } else {         
        echo 'Failed to update the product.';     
    } 
} 
?>  

<!DOCTYPE html> 
<html lang="en"> 
<head>     
    <meta charset="UTF-8">     
    <meta name="viewport" content="width=device-width, initial-scale=1.0">     
    <title>Edit Product</title>     
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">     
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">     
    <style>         
        .edit-product-container {             
            width: 100%;             
            max-width: 600px;             
            background-color: var(--white-alpha-40);             
            padding: 20px;             
            border-radius: 8px;             
            border: 1px solid #ddd;             
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);             
            margin: 20px auto;         
        }         
        .edit-product-container h1 {             
            font-size: 1.8em;             
            color: var(--main-color);             
            margin-bottom: 20px;             
            text-align: center;         
        }         
        .edit-product-container .input-field {             
            margin-bottom: 15px;         
        }         
        .edit-product-container .input-field p {             
            font-weight: bold;             
            margin-bottom: 5px;             
            color: var(--main-color);         
        }         
        .edit-product-container .input-field input[type="text"],         
        .edit-product-container .input-field input[type="number"],         
        .edit-product-container .input-field textarea,         
        .edit-product-container .input-field select {             
            width: 100%;             
            padding: 10px;             
            border: 1px solid #ddd;             
            border-radius: 4px;             
            font-size: 16px;         
        }         
        .edit-product-container .input-field textarea {             
            resize: vertical;             
            min-height: 100px;         
        }         
        .edit-product-container .image-preview {             
            margin-top: 10px;             
            max-width: 100%;             
            height: auto;             
            border: 1px solid #ddd;             
            border-radius: 4px;         
        }         
        .edit-product-container .btn {             
            display: inline-block;             
            padding: 10px 15px;             
            border: 2px solid var(--white-alpha-40);             
            border-radius: 1.5rem;             
            background-color: var(--white-alpha-25);             
            color: var(--main-color);             
            text-align: center;             
            text-decoration: none;             
            cursor: pointer;             
            font-size: 14px;             
            margin-top: 20px;             
            width: 100%;             
            max-width: 250px;             
            transition: color 0.3s ease, background-color 0.3s ease;         
        }         
        .edit-product-container .btn:hover {             
            background-color: var(--main-color);             
            color: #fff;         
        }     
    </style> 
</head> 
<body>     
    <div class="main-container">         
        <?php include '../components/admin_header.php'; ?>         
        <section class="dashboard">             
            <div class="edit-product-container">                 
                <h1>Edit Product</h1>                  

                <form action="" method="post" enctype="multipart/form-data">                     
                    <div class="input-field">                         
                        <p>Product Status<span>*</span></p>                         
                        <select name="status" class="box">                             
                            <option value="<?= $fetch_products['status']; ?>" selected><?= $fetch_products['status']; ?></option>                             
                            <option value="active">Active</option>                             
                            <option value="deactive">Deactive</option>                         
                        </select>                     
                    </div>                     
                    <div class="input-field">                         
                        <p>Product Name<span>*</span></p>                         
                        <input type="text" name="name" value="<?= $fetch_products['name']; ?>" required>                     
                    </div>                     
                    <div class="input-field">                         
                        <p>Product Price<span>*</span></p>                         
                        <input type="number" name="price" value="<?= $fetch_products['price']; ?>" required>                     
                    </div>                     
                    <div class="input-field">                         
                        <p>Product Description<span>*</span></p>                         
                        <textarea name="description" required><?= $fetch_products['product_detail']; ?></textarea>                     
                    </div>                     
                    <div class="input-field">                         
                        <p>Product Stock<span>*</span></p>                         
                        <input type="number" name="stock" value="<?= $fetch_products['stock']; ?>" required>                     
                    </div>                     
                    <div class="input-field">                         
                        <p>Product Image<span>*</span></p>                         
                        <input type="file" name="image">                         
                        <?php if ($fetch_products['image']): ?>                             
                            <img src="../uploaded_files/<?= $fetch_products['image']; ?>" alt="Product Image" class="image-preview">                         
                        <?php endif; ?>                     
                    </div>                     
                    <button type="submit" name="update" class="btn">Update Product</button>                     
                </form>             
            </div>         
        </section>     
    </div> 
</body> 
</html> 
