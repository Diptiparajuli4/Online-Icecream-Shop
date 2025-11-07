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
?> 

<!DOCTYPE html> 
<html lang="en"> 
<head>     
    <meta charset="UTF-8">     
    <meta name="viewport" content="width=device-width, initial-scale=1.0">     
    <title>Seller Dashboard</title>     
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">     
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"> 

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
        }

        .main-container {
            width: 100%;
            margin: 0 auto;
        }

        .dashboard {
            padding: 20px;
            background-color: #fff;
            margin: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .dashboard .heading {
            text-align: center;
            margin-bottom: 20px;
        }

        .dashboard .heading h1 {
            margin-top: 10px;
            font-size: 2rem;
            color: #333;
        }

        /* Separator Styling */
        .dashboard .heading img {
            width: 250px;
            height: 80px;
            margin-top: 15px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            border-radius: 10px;
            background: linear-gradient(90deg, #f5a623, #f5e25f);
        }

        .box-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-left: 15rem;
            justify-content: center;
        }

        /* Image Box Styling */
        .box {
            background-color: #fff;
            width: 480px;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
            text-align: center;
            position: relative;
        }

        /* Image Styling */
        .box img {
         
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
            transition: transform 0.3s ease;
        }

        /* Hover Effect for Image */
        .box:hover img {
            transform: scale(1.05); /* Slight zoom effect on hover */
        }

        .box p {
            font-size: 1rem;
            color: #555;
            margin-bottom: 10px;
        }

        .box p span {
            font-weight: bold;
            color: #333;
        }

        .box:hover {
            transform: translateY(-10px);
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.15);
        }

        /* Responsive Adjustment */
        @media (max-width: 768px) {
            .box-container {
                flex-direction: column;
                align-items: center;
            }

            .box {
                width: 90%;
                margin-bottom: 15px;
            }

            .box img {
                height: 250px; /* Make images a little bigger for smaller screens */
            }
        }

        /* Header and alert styling (for the included files) */
        header {
            background-color: #333;
            padding: 10px;
            color: white;
            text-align: center;
        }

        .alert {
            margin-top: 20px;
            padding: 10px;
            background-color: #ffcccc;
            color: #ff0000;
            border: 1px solid #ff0000;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head> 

<body>   
    <div class="main-container">     
        <?php include '../components/admin_header.php'; ?>     
        
        <section class="dashboard">         
            <div class="heading">             
                <h1>Registered Sellers</h1>             
                <img src="../image/separator-img.png" alt="Separator">         
            </div>         
            
            <div class="box-container">             
                <?php             
                // Fetch users for the seller
                $select_sellers = mysqli_query($con, "SELECT * FROM `sellers`");

                if ($select_sellers && mysqli_num_rows($select_sellers) > 0) {
                    while ($fetch_sellers = mysqli_fetch_assoc($select_sellers)) {
                        $seller_id = $fetch_sellers['id'];
                        ?>
                        <div class="box">
                        <img src="../uploaded_files/<?= $fetch_sellers['image']; ?>" alt="Sellers Image">
                        <p>Seller ID: <span><?= htmlspecialchars($seller_id); ?></span></p>
                            <p>Seller Name: <span><?= htmlspecialchars($fetch_sellers['name']); ?></span></p>
                            <p>Seller Email: <span><?= htmlspecialchars($fetch_sellers['email']); ?></span></p>
                        </div>
                        <?php 
                    }
                } else {
                    echo "<p>No sellers found.</p>";
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
