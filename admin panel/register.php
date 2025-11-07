<?php 
include '../components/connect.php'; 

if (isset($_POST['submit'])) {
    $id = unique_id();
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pass = sha1($_POST['pass']);
    $cpass = sha1($_POST['cpass']);
    $image = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];

    // Handle file extension and renaming
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = unique_id() . '.' . $ext;
    $image_folder = '../uploaded_files/' . $rename;

    // Use mysqli to prepare the statement
    $select_seller = $con->prepare("SELECT * FROM sellers WHERE email = ?");
    $select_seller->bind_param("s", $email); // Bind the email parameter
    $select_seller->execute();
    $result = $select_seller->get_result(); // Get the result set from the statement

    if ($result->num_rows > 0) { // Use num_rows instead of rowCount()
        $warning_msg[] = 'Email already exists!';
    } else {
        if ($pass != $cpass) {
            $warning_msg[] = 'Confirm password does not match.';
        } else {
            $insert_seller = $con->prepare("INSERT INTO sellers (id, name, email, password, image) VALUES (?, ?, ?, ?, ?)");
            $insert_seller->bind_param("sssss", $id, $name, $email, $cpass, $rename); // Bind parameters for insertion
            if ($insert_seller->execute()) {
                move_uploaded_file($image_tmp_name, $image_folder);
                $success_msg[] = 'New seller registered! Please login now.';
            } else {
                $warning_msg[] = 'Failed to register, please try again.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delightful Creamery- Seller Registration Page</title>
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
<div class="form-container">
    <form action="" method="post" enctype="multipart/form-data">
        <h3>Register Now</h3>
        <div class="flex">
            <div class="col">
                <div class="input-field">
                    <p>Your Name<span>*</span></p>
                    <input type="text" name="name" placeholder="Enter your name" maxlength="50" required class="box">
                </div>
                <div class="input-field">
                    <p>Your Email<span>*</span></p>
                    <input type="email" name="email" placeholder="Enter your email" maxlength="50" required class="box">
                </div>
            </div>
            <div class="col">
                <div class="input-field">
                    <p>Your Password<span>*</span></p>
                    <input type="password" name="pass" placeholder="Enter your password" maxlength="50" required class="box">
                </div>
                <div class="input-field">
                    <p>Confirm Password<span>*</span></p>
                    <input type="password" name="cpass" placeholder="Confirm your password" maxlength="50" required class="box">
                </div>
            </div>
        </div>
        <div class="input-field">
            <p>Your Profile<span>*</span></p>
            <input type="file" name="image" accept="image/*" required class="box">
        </div>
        
        <!-- Centered button and message below -->
        <button type="submit" name="submit" class="btn">Register Now</button>
        
        <p class="link">Already have an account? <a href="login.php">Login now</a></p>
    </form>
</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../js/admin_script.js"></script>
    <?php include '../components/alert.php'; ?>
</body>
</html>
