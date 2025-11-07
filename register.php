<?php 
// Include database connection
require 'components/connect.php'; // Adjusted path to point to the correct location

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

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
    $image_folder = 'uploaded_files/' . $rename;

    // Correct SQL query with backticks
    $select_seller = $con->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_seller->bind_param("s", $email); // Bind the email parameter
    $select_seller->execute();
    $result = $select_seller->get_result(); // Get the result set from the statement

    if ($result->num_rows > 0) { // Use num_rows instead of rowCount()
        $warning_msg[] = 'Email already exists!';
    } else {
        if ($pass != $cpass) {
            $warning_msg[] = 'Confirm password does not match.';
        } else {
            // Correct SQL query for insertion with backticks
            $insert_seller = $con->prepare("INSERT INTO `users` (id, name, email, password, image) VALUES (?, ?, ?, ?, ?)");
            $insert_seller->bind_param("sssss", $id, $name, $email, $cpass, $rename); // Bind parameters for insertion

            if ($insert_seller->execute()) {
                move_uploaded_file($image_tmp_name, $image_folder);
                $success_msg[] = 'New user registered! Please login now.';
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
    <title>Delightful Creamery - Register User Page</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
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

    </style>
</head>

<body>

<?php include 'components/user_header.php'; ?>
<div class="banner">
    <img src="image/banner.jpg" alt="Banner Image">
    <div class="detail">
        <h1>About Us</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur, assumenda repellendus, nemo adipisci possimus <br>atque ea porro quibusdam ratione debitis delectus architecto iure fuga nam cumque. Deleniti reprehenderit nesciunt quam!</p>
        <span><a href="home.php" class="btn">Home</a><i class="bx bx-right-arrow-alt"></i>Register </span>
    </div>
</div>
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
    <?php include 'components/alert.php'; ?>

<?php include 'components/footer.php'; ?>
  <script>
       let currentSlide = 0;

function showSlide(index) {
    const slides = document.querySelectorAll('.sliderBox');
    const controls = document.querySelectorAll('.controls li');

    // Loop through slides when index exceeds bounds
    if (index >= slides.length) {
        currentSlide = 0;
    } else if (index < 0) {
        currentSlide = slides.length - 1;
    } else {
        currentSlide = index;
    }

    // Calculate the offset for the transition
    const offset = -100 * currentSlide; // Slide transition in percentage
    document.querySelector('.slider').style.transform = `translateX(${offset}%)`;

    // Remove active class from all slides and controls
    slides.forEach((slide, i) => {
        slide.classList.remove('active');
        controls[i].classList.remove('active');
    });

    // Add active class to the current slide and control
    slides[currentSlide].classList.add('active');
    controls[currentSlide].classList.add('active');
}

// Function to go to the next slide
function nextSlide() {
    showSlide(currentSlide + 1);
}

// Function to go to the previous slide
function prevSlide() {
    showSlide(currentSlide - 1);
}

// Set interval for automatic slide change (every 3 seconds)
setInterval(nextSlide, 3000); // Auto slide every 3 seconds

// Event listeners for next and prev buttons
document.getElementById('nextBtn').addEventListener('click', nextSlide);
document.getElementById('prevBtn').addEventListener('click', prevSlide);
    </script>
</body>
</html>
