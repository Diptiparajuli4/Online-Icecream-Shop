

<?php 
include '../components/connect.php'; 

if (isset($_POST['submit'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pass = sha1($_POST['pass']);
    
    // Prepare the statement to select the seller
    $select_seller = $con->prepare("SELECT * FROM sellers WHERE email = ? AND password = ?");
    $select_seller->bind_param("ss", $email, $pass); // Bind parameters
    $select_seller->execute(); // Execute the statement
    $result = $select_seller->get_result(); // Get the result set

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Fetch the associated array
        setcookie('seller_id', $row['id'], time() + 60 * 60 * 24 * 30, '/');
        header('location:dashboard.php');
        exit(); // Always good to exit after a redirect
    } else {
        $warning_msg[] = 'Confirm email or password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delightful Creamery- Seller Login Page</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all/min.css">
</head>
<body>
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data">
            <h3>Login Now</h3>
            <div class="input-field">
                <p>Your Email<span>*</span></p>
                <input type="email" name="email" placeholder="Enter your email" maxlength="50" required class="box">
            </div>
            <div class="input-field">
                <p>Your Password<span>*</span></p>
                <input type="password" name="pass" placeholder="Enter your password" maxlength="50" required class="box">
            </div>
            <button type="submit" name="submit" class="btn">Login Now</button>


            <p class="link">Do not have an account?<a href="register.php">Register now</a></p>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../js/admin_script.js"></script>
    <?php include '../components/alert.php'; ?>
</body>
</html>
