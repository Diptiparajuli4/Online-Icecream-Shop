<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['send_message'])) {
    if ($user_id != '') {
        $id = unique_id();
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
        $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

        // Corrected SQL syntax with backticks for table and column names
        $verify_message = $con->prepare("SELECT * FROM `message` WHERE `user_id` = ? AND `email` = ? AND `subject` = ? AND `message` = ?");
        $verify_message->bind_param("ssss", $user_id, $email, $subject, $message); // Correct parameter binding
        $verify_message->execute();
        $result = $verify_message->get_result();

        if ($result->num_rows > 0) {
            $warning_msg[] = 'Message already exists!';
        } else {
            // Corrected SQL syntax and query
            $insert_message = $con->prepare("INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `subject`, `message`) VALUES (?, ?, ?, ?, ?, ?)");
            $insert_message->bind_param("ssssss", $id, $user_id, $name, $email, $subject, $message);
            $insert_message->execute();
            $success_msg[] = 'Message sent successfully!';
        }
    } else {
        $warning_msg[] = 'Please login first!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delightful Creamery</title>
    <link rel="stylesheet" type="text/css" href="../css/user_style.css?v=<?php echo time() ; ?>">     
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    
    
<?php include 'components/user_header.php'; ?>

<div class="banner">
    <img src="image/banner.jpg" alt="Banner Image">
    <div class="detail">
        <h1>Contact Us</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur, assumenda repellendus, nemo adipisci possimus<br>atque ea porro quibusdam ratione debitis delectus architecto iure fuga nam cumque. Deleniti reprehenderit nesciunt quam!</p>
        <span><a href="home.php" class="btn">Home</a><i class="bx bx-right-arrow-alt"></i> Contact Us</span>
    </div>
</div>

<div class="services">
    <div class="heading">
        <h1>Our Services</h1>
        <p>Just a few click to make the reservation online for saving your time and money</p>
        <img src="image/separator-img.png">
</div>
<div class="box-container">
    <div class="box">
        <img src="image/0.png">
        <div>
            <h1>Free shipping fast</h1>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cum, iusto iste harum dignissimos nesciunt voluptatibus ab? Quia, eligendi temporibus placeat consequatur ipsum exercitationem iure animi tempora amet veritatis, ipsam dolores.</p>
</div>
</div>
<div class="box">
        <img src="image/1.png">
        <div>
            <h1>Money back and guarantee</h1>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cum, iusto iste harum dignissimos nesciunt voluptatibus ab? Quia, eligendi temporibus placeat consequatur ipsum exercitationem iure animi tempora amet veritatis, ipsam dolores.</p>
</div>
</div> 
<div class="box">
        <img src="image/2.png">
        <div>
            <h1>Online support 24/7</h1>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cum, iusto iste harum dignissimos nesciunt voluptatibus ab? Quia, eligendi temporibus placeat consequatur ipsum exercitationem iure animi tempora amet veritatis, ipsam dolores.</p>
</div>
</div>
</div>
</div>

<div class="form-container">
    <div class="heading">
        <h1>Drop us a line</h1>
        <img src="image/separator-img.png" alt="Separator">
    </div>
    <form action="" method="post" class="register">
        <div class="input-field">
            <label>Name<sup>*</sup></label>
            <input type="text" name="name" required placeholder="Enter your name" class="box">
        </div>
        <div class="input-field">
            <label>Email<sup>*</sup></label>
            <input type="email" name="email" required placeholder="Enter your email" class="box">
        </div>
        <div class="input-field">
            <label>Subject<sup>*</sup></label>
            <input type="text" name="subject" required placeholder="Reason.." class="box">
        </div>
        <div class="input-field">
            <label>Comment<sup>*</sup></label>
            <textarea name="message" cols="30" rows="10" required placeholder="Enter your message..." class="message"></textarea>
        </div>
        <button type="submit" name="send_message" class="btn">Send Message</button>
    </form>
</div>

<div class="address">
    <div class="heading">
        <h1> Our Contact</h1>
        <p>Just a few click to make the reservation online for saving your time and money</p>
        <img src="image/separator-img.png">
</div>
<div class="box-container">
    <div class="box">
        <i class="bx bxs-map-alt"></i>
        <div>
            <h4>address</h4>
            <p>1093 Marigold,Coral Way<br>Miami,Florida,33169</p>
</div>
</div>

<div class="box">
        <i class="bx bxs-phone-incoming"></i>
        <div>
            <h4>phone number</h4>
            <p>1111111111</p>
            <p>1111133169</p>
</div>
</div>
<div class="box">
        <i class="bx bxs-envelope"></i>
        <div>
            <h4>email</h4>
            <p>dipti123@gmail.com</p>
            <p>dilip456@gmail.com</p>
</div>
</div>

</div>
</div>

<?php include 'components/footer.php'; ?>

</body>
</html>