<?php 
// Include database connection
require 'components/connect.php'; // Adjusted path to point to the correct location
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}


if (isset($_POST['submit'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pass = sha1($_POST['pass']);
    
    // Prepare the statement to select the seller
    $select_user = $con->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $select_user->bind_param("ss", $email, $pass); // Bind parameters
    $select_user->execute(); // Execute the statement
    $result = $select_user->get_result(); // Get the result set

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Fetch the associated array
        setcookie('user_id', $row['id'], time() + 60 * 60 * 24 * 30, '/');
        header('location:home.php');
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
    <title>Delightful Creamery - Login User Page</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
  </head>

<body>

<?php include 'components/user_header.php'; ?>
<div class="banner">
    <img src="image/banner.jpg" alt="Banner Image">
    <div class="detail">
        <h1>Login Page</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur, assumenda repellendus, nemo adipisci possimus <br>atque ea porro quibusdam ratione debitis delectus architecto iure fuga nam cumque. Deleniti reprehenderit nesciunt quam!</p>
        <span><a href="home.php" class="btn">Home</a><i class="bx bx-right-arrow-alt"></i>Login </span>
    </div>
</div>
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
    <?php include 'components/alert.php'; ?>

<?php include 'components/footer.php'; ?>
 </body>
</html>
