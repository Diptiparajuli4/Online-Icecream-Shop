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

// Get the post_id from URL to fetch the correct product
$get_id = $_GET['post_id'];

// delete product logic
if (isset($_POST['delete'])) {
    $p_id = $_POST['product_id'];
    $p_id = filter_var($p_id, FILTER_SANITIZE_STRING);

    // Prepare the SQL query to delete the product by ID and seller_id
    $delete_product = $con->prepare("SELECT image FROM `products` WHERE id = ? AND seller_id = ?");
    $delete_product->bind_param("ii", $p_id, $seller_id);
    $delete_product->execute();

    // Use get_result() to fetch the data
    $result = $delete_product->get_result();
    $fetch_delete_image = $result->fetch_assoc();

    // If the product has an associated image, delete it from the folder
    if ($fetch_delete_image && $fetch_delete_image['image'] != '') {
        unlink('../uploaded_files/' . $fetch_delete_image['image']);
    }

    // Delete the product from the database
    $delete_product = $con->prepare("DELETE FROM `products` WHERE id = ? AND seller_id = ?");
    $delete_product->bind_param("ii", $p_id, $seller_id);
    $delete_product->execute();

    // Redirect to the view product page after deletion
    header("location:view_product.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delightful Creamery - Product Details</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        .box-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .box {
            background-color: var(--white-alpha-40);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 380px;
            height: 530px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            position: relative;
            overflow: hidden;
        }

        .box img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .status {
            font-size: 1rem;
            font-weight: bold;
            color: limegreen;
            margin: 5px 0;
        }

        .status.inactive {
            color: coral;
        }

        .price {
            width: 70px;
            height: 70px;
            line-height: 70px;
            text-align: center;
            border-radius: 50%;
            background-color: var(--pinkcolor);
            color: var(--maincolor);
            font-size: 1.5rem;
            font-weight: bold;
            position: absolute;
            right: 10px;
            top: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .content {
            margin-top: 8px;
        }

        .content .title {
            font-size: 1rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .btn {
            background-color: var(--white-alpha-25);
            border: 2px solid var(--white-alpha-40);
            color: var(--main-color);
            padding: 0.4rem 1rem;
            border-radius: 1.5rem;
            font-size: 15px;
            cursor: pointer;
            width: 100%;
            max-width: 250px;
            margin: 0.4rem auto;
            display: block;
            text-align: center;
            transition: color 0.3s ease, background-color 0.3s ease;
        }
        .title{
            font-size:30px;
            color:var(--main-color);

        }
    </style>
</head>
<body>
  <div class="main-container">
    <?php include '../components/admin_header.php'; ?>
    <section class="dashboard">
        <div class="heading">
            <h1>Product Details</h1>
            <img src="../image/separator-img.png" alt="Separator">
        </div>
        <div class="box-container">
        <?php 
        // SQL query to fetch the product by post_id (id) and seller_id
        $select_product = $con->prepare("SELECT name, image, price, id, status, product_detail FROM `products` WHERE id = ? AND seller_id = ?");
        $select_product->bind_param("ii", $get_id, $seller_id);
        $select_product->execute();

        // Fetch the product details
        $result = $select_product->get_result();
        $fetch_product = $result->fetch_assoc();
        
        if ($fetch_product) {
        ?>
         <form action="" method="post" class="box">
                <input type="hidden" name="product_id" value="<?=$fetch_product['id'];?>">
                <div class="status" style="color:<?php if($fetch_product['status'] == 'active'){ echo "limegreen"; } else { echo "coral"; }?>"><?=$fetch_product['status'];?></div>
            <?php if($fetch_product['image'] != ''){ ?>
                    <img src="../uploaded_files/<?=$fetch_product['image']?>">
            <?php } ?>
                <div class="price">$<?=$fetch_product['price'];?>/-</div>
                <div class="title"><?=$fetch_product['name'];?></div>
                <div class="content"><?=$fetch_product['product_detail'];?></div>
                <div class="flex-btn">
                    <a href="edit_product.php?id=<?=$fetch_product['id']; ?>" class="btn">Edit</a>
                    <button type="submit" name="delete" class="btn" onclick="return confirm('Delete this product?');">Delete</button>
                    <a href="view_product.php?post_id=<?=$fetch_product['id']; ?>" class="btn">Go back</a>
                </div>
            </form>
     <?php
        } else {
            echo '
                <div class="empty">
                    <p>No product found!<br><a href="add_products.php" class="btn" style="margin-top:1.5rem;">Add Product</a></p>
                </div>
            ';
        }
        ?>
    </div>
    </section>
  </div> <!-- Closing main-container div -->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <script src="../js/admin_script.js"></script>
  <?php include '../components/alert.php'; ?>
</body>
</html>
