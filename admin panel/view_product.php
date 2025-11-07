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
//delete product
if (isset($_POST['delete'])) {
   $p_id=$_POST['product_id'];
   $p_id= filter_var($p_id, FILTER_SANITIZE_STRING);
   $delete_product = $con->prepare("DELETE FROM `products` WHERE  id= ?");
   $delete_product ->execute([$p_id]);
   $success_msg[] = 'Product deleted successfully';

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delightful Creamery - Products Page</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        .box-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
            margin-top: 20px;
        }

        .box {
            background-color: var(--white-alpha-40);
            padding: 10px; /* Reduced padding */
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: 100%;
            max-width: 300px; /* Reduced width slightly */
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            position: relative;
        }

        .box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .box img {
            width: 100%;
            height: 150px; /* Keeping image height for focus */
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .status {
            font-size: 1rem;
            font-weight: bold;
            color: limegreen;
            margin: 5px 0; /* Reduced margin */
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
            font-size: 1.5rem; /* Larger font size for emphasis */
            font-weight: bold;
            position: absolute;
            right: 10px;
            top: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .price:hover {
            background-color: transparent; /* Change to black on hover */
            transform: scale(1.1);
        }

        .content {
            margin-top: 8px;
        }

        .content .title {
            font-size: 1rem; /* Reduced font size */
            font-weight: bold;
            color: #333;
            margin-bottom: 5px; /* Reduced margin */
        }

        /* Button with Hover Effects */
        .btn {
            background-color: var(--white-alpha-25); 
            border: 2px solid var(--white-alpha-40);
            backdrop-filter: var(--backdrop-filter); 
            color: var(--main-color);
            padding: 0.4rem 1rem; /* Reduced padding */
            border-radius: 1.5rem;
            font-size: 15px;
            cursor: pointer;
            width: 100%;
            max-width: 250px;
            margin: 0.4rem auto; /* Reduced margin */
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

    </style>
</head>
<body>
  <div class="main-container">
    <?php include '../components/admin_header.php'; ?>
    <section class="dashboard">
        <div class="heading">
            <h1>Your Products</h1>
            <img src="../image/separator-img.png" alt="Separator">
        </div>
        <div class="box-container">
    <?php 
    // Modify the query to include the 'status' and 'price' columns
    $select_products = $con->prepare("SELECT name, image, price, id, status FROM `products` WHERE seller_id = ?");
    $select_products->bind_param('i', $seller_id);
    $select_products->execute();
    $result = $select_products->get_result();
    if($result->num_rows > 0){
        while($fetch_products = $result->fetch_assoc()){  
            ?>
            <form action="" method="post" class="box">
                <input type="hidden" name="product_id" value="<?=$fetch_products['id'];?>">
                <?php if($fetch_products['image'] != ''){ ?>
                    <img src="../uploaded_files/<?=$fetch_products['image']?>">
                <?php } ?>
                <?php if(isset($fetch_products['status'])) { ?>
                    <div class="status" style="color:<?php if($fetch_products['status']=='active'){
                        echo "limegreen";} else {echo "coral";}?>"><?=$fetch_products['status'];?></div>
                    <div class="price">$<?=$fetch_products['price'];?></div>
                    <div class="content">
                        <div class="title"><?=$fetch_products['name'];?></div>
                        <div class="flex-btn">
                            <a href="edit_product.php?id=<?=$fetch_products['id']; ?>"class="btn">Edit</a>
                            <button type="submit" name="delete" class="btn" onclick="return confirm('Delete this product?');">Delete</button>
                            <a href="read_product.php?post_id=<?=$fetch_products['id']; ?>"class="btn">Read Product</a>
                        </div>
                    </div>
                <?php } ?> 
            </form>
        <?php
        }
    } else {
        echo '
            <div class="empty">
                <p>No products added yet!<br><a href="add_products.php" class="btn" style="margin-top:1.5rem;">Add Products</a></p>
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
