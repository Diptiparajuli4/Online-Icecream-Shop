<?php
include 'components/connect.php'; 

// Check if user_id cookie exists
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    header('location:login.php');
    exit; // Ensure the script stops after the redirect
}

// Prepare and execute the query to fetch user profile details
$select_user = $con->prepare("SELECT * FROM `users` WHERE id = ?");
$select_user->bind_param("i", $user_id);
$select_user->execute();
$user_result = $select_user->get_result();

if ($user_result->num_rows > 0) {
    $fetch_profile = $user_result->fetch_assoc();
} else {
    die("No user found with the given ID. Please log in again.");
}

// Prepare and execute the query to get total messages
$select_message = $con->prepare("SELECT * FROM `message` WHERE user_id = ?");
$select_message->bind_param("i", $user_id);
$select_message->execute();
$message_result = $select_message->get_result();
$total_message = $message_result->num_rows;

// Prepare and execute the query to get total orders
$select_orders = $con->prepare("SELECT * FROM `orders` WHERE user_id = ?");
$select_orders->bind_param("i", $user_id);
$select_orders->execute();
$order_result = $select_orders->get_result();
$total_orders = $order_result->num_rows;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        /* Seller Profile Section */
        .user {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-bottom: 20px;
            width: 250px;
            margin: 0 auto;
        }

        /* Profile Image Styling */
        .user img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #ddd;
            margin-bottom: 10px;
        }

        /* Seller Name Styling */
        .user .name {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .user span {
            display: block;
            font-size: 1rem;
            color: #888;
            margin-bottom: 10px;
        }

        /* Update Profile Button Styling */
        .user .btn {
            background-color: #ff6f61;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 1rem;
            transition: background-color 0.3s ease;
            display: inline-block;
            margin-top: 15px;
        }

        .user .btn:hover {
            background-color: #ff5049;
        }

        /* General Section Styling */
        .details {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: #f7f7f7;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .details .user {
            text-align: center;
            margin-bottom: 30px;
        }

        .details .flex {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .details .box {
            flex: 1;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .details .box span {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
        }

        .details .box p {
            font-size: 1rem;
            color: #888;
        }

        .details .box .btn {
            margin-top: 10px;
        }
        
    .form-container {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    padding: 4% 0;
    position: relative;
    background-image:url('image/bg1.webp');
    background-position:center;
}

.form-container form {
    background-color: var(--white-alpha-25);
    border: 2px solid var(--white-alpha-40);
    backdrop-filter: var(--backdrop-filter);
    box-shadow: var(--box-shadow);
    border-radius: .5rem;
    padding: 2rem;
    width: 500px;
    font-size: 25px;
}

.form-container .login {
    width: 150rem;
}
.form-container .box {
    font-size: 25px;
    width:400px;
}
.form-container .register {
    width: 180rem;
}

.form-container form h3 {
    text-align: center;
    font-size: 3rem;
    margin-bottom: 5rem;
    color: var(--main-color);
    text-transform: capitalize;
    font-weight: bolder;
}

.form-container form .btn {
    width: 100%;
    font-size: 1.3rem;
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
}


/* Responsive adjustments */
@media (max-width: 768px) {
    .banner {
        height: 40vh;
    }

    .detail h1 {
        font-size: 2em;
    }

    .detail p {
        font-size: 1em;
    }
}
.dashboard .heading {
    margin-bottom: 20px;
    text-align:center;
}

.dashboard .heading h1 {
    font-size: 2.5rem;
    font-weight: bold;
    text-align:center;
    color: black; /* White text for heading on dark background */
    margin-bottom: 10px;
}

   
    </style>

</head>
<?php include 'components/user_header.php'; ?>
<div class="banner">
    <img src="image/banner.jpg" alt="Banner Image">
    <div class="detail">
        <h1>Profile Page</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur, assumenda repellendus, nemo adipisci possimus <br>atque ea porro quibusdam ratione debitis delectus architecto iure fuga nam cumque. Deleniti reprehenderit nesciunt quam!</p>
        <span><a href="home.php" class="btn">Home</a><i class="bx bx-right-arrow-alt"></i>Profile </span>
    </div>
</div>
<body>
    <div class="main-container">
        <?php include 'components/user_header.php'; ?>
        <section class="dashboard">
            <div class="heading">
                <h1>Profile Details</h1>
                <img src="image/separator-img.png" alt="Separator">
            </div>
            <div class="details">
                <div class="user">
                    <img src="uploaded_files/<?= htmlspecialchars($fetch_profile['image']); ?>" alt="Profile Picture">
                    <h3 class="name"><?= htmlspecialchars($fetch_profile['name']); ?></h3>
                    <span><?= htmlspecialchars($fetch_profile['email']); ?></span>
                </div>
                <a href="update.php" class="btn">Update Profile</a>

                <div class="flex">
                    <div class="box">
                        <span><?= $total_message; ?></span>
                        <p>Total Messages</p>
                        <a href="message.php" class="btn">View Messages</a>
                    </div>
                    <div class="box">
                        <span><?= $total_orders; ?></span>
                        <p>Total Orders Placed</p>
                        <a href="order.php" class="btn">View Orders</a>
                    </div>
                </div>
            </div>
        </section>
    </div> <!-- Closing main-container div -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <?php include 'components/footer.php'; ?>
</body>
</html>
