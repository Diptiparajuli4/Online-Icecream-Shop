

<?php 
// Include database connection
require 'components/connect.php'; // Adjusted path to point to the correct location

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delightful Creamery - About Us Page</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        /* Basic Boxicons setup */
i.bx {
    font-family: 'boxicons' !important; /* Use the Boxicons font */
    font-style: normal; /* Remove italic styles */
    font-weight: normal; /* Set weight to normal */
    line-height: 1; /* Ensure consistent line height */
    display: inline-block; /* Inline display for icons */
    vertical-align: middle; /* Align with surrounding text */
}

/* Styling for the heart icon */
i.bxs-heart {
    font-size: 24px; /* Size of the icon */
    color: red; /* Default color for the heart */
    margin: 5px; /* Add spacing around the icon */
}

/* Add hover effect (optional) */
i.bxs-heart:hover {
    color: darkred; /* Change color on hover */
    transform: scale(1.1); /* Slightly enlarge on hover */
    transition: 0.3s ease; /* Smooth transition */
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
.chef {
    padding: 50px 0;
    background-color: #f9f9f9;
    text-align: center;
}

.box-container {
    display: flex;
    justify-content: center;
    align-items: center;
    max-width: 900px; /* Restricting width for better readability */
    margin: 0 auto;
    padding: 20px;
    border-radius: 15px;
    background-color: #fff; /* White background for box */
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1); /* Soft shadow for depth */
}

.box {
    padding: 20px;
}

.heading {
    margin-bottom: 20px;
}

.heading span {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--pink-color); /* Your defined pink color */
    margin-bottom: 10px;
}

.heading h1 {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 10px;
    color: #333;
}

.heading img {
    width: 40px; /* Smaller icon size */
    margin-bottom: 15px;
}

.heading p {
    font-size: 1rem;
    color: #666;
    line-height: 1.8;
    margin-bottom: 25px;
    max-width: 800px;
    margin: 0 auto; /* Centering the text block */
}

.heading a.btn {
    display: inline-block;
    text-decoration: none;
    font-weight: bold;
    padding: 12px 30px;
    background-color: #fff; /* White background */
    color: var(--pink-color); /* Your defined pink color */
    border: 2px solid var(--pink-color);
    border-radius: 50px; /* Rounded buttons */
    margin: 0 10px;
    transition: background-color 0.3s, color 0.3s;
}

.heading a.btn:hover {
    background-color: var(--pink-color); /* Pink background on hover */
    color: #fff; /* White text on hover */
}

.box img {
    width: 100%;
    border-radius: 10px;
    object-fit: cover;
    max-height: 400px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .box-container {
        flex-direction: column;
        text-align: center;
    }

    .heading span, .heading h1, .heading p {
        text-align: center;
    }

    .heading a.btn {
        margin-bottom: 15px;
    }
}
.story {
    padding: 50px 0;
    position: relative;
    background: url('image/about_bg.jpg') no-repeat center center/cover; /* Set the image as the background */
    color: #fff; /* White text for contrast */
    text-align: center;
    z-index: 1;
    border-radius: 15px; /* Rounded corners */
    overflow: hidden; /* Ensures no content overflows the container */
}

.story::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0.5, 0, 0); /* Semi-transparent dark overlay for better text readability */
    z-index: -1; /* Ensures the overlay is behind the text */
}

.story .heading {
    margin-bottom: 20px;
    z-index: 2; /* Ensures the heading stays above the overlay */
}
.story .heading img {
    width: 240px; /* Smaller icon size */
    margin-bottom: 15px;
}
.story h1 {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 15px;
    color: black; /* White color for the heading */
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7); /* Text shadow for better readability */
}

.story img {
    width: 80px; /* Increase the width from 40px to 80px */
    margin-bottom: 15px;
}


.story p {
    font-size: 1.2rem;
    line-height: 1.8;
    max-width: 800px;
    margin: 0 auto 30px;
    color: black ;/* White text color for paragraph */
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7); /* Text shadow for better readability */
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .story {
        padding: 30px 0;
    }

    .story h1 {
        font-size: 2rem;
    }

    .story p {
        font-size: 1rem;
    }
}
/* Container for the "Taking ice-cream to New Height" section */
.container {
    padding: 50px 0;
    display: flex;
    justify-content: center;
    align-items: center;
}

.box-container {
    display: flex;
    justify-content: center;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 15px;
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
}

.img-box img {
    width: 100%;
    height: auto;
    max-width: 400px;
    border-radius: 10px;
    object-fit: cover;
}

.box {
    padding: 20px;
    text-align: center;
}

.heading {
    margin-bottom: 20px;
}

.heading h1 {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 15px;
    color: #333;
}

.heading img {
    width: 100px; /* Increased the size of the separator image */
    margin-bottom: 15px;
}
.containe .box-container .img-box img{
    background-image:url('image/shap.png');
}
.box .heading img{
    width: 400px; /* Increased the size of the separator image */
    margin-bottom: 15px;   
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .box-container {
        flex-direction: column;
        text-align: center;
    }

    .img-box img {
        max-width: 100%;
    }

    .heading h1 {
        font-size: 2rem;
    }
}
.container {
    padding: 50px 0;
    display: flex;
    justify-content: center;
    align-items: center;
}

.box-container {
    display: flex;
    justify-content: center;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
    color: black; /* White text color for contrast */
}

.img-box img {
    background: url('image/shap.png') no-repeat center center; /* Add your background image */
    background-size: cover; 
    width: 100%;
    height: auto;
    max-width: 400px;
    border-radius: 10px;
    object-fit: cover;
}

.box {
    padding: 20px;
    text-align: center;
}

.heading {
    margin-bottom: 20px;
}

.heading h1 {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 15px;
    color: black; /* White text for the heading */
}

.heading img {
    width: 100px; /* Adjust the separator image size */
    margin-bottom: 15px;
}
.box .heading p{
    color:black;
}
.team {
    padding: 50px 0;
    background-color: #f9f9f9;
    text-align: center;
}

.team .heading {
    margin-bottom: 40px;
}

.team .heading span {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--pink-color); /* Your defined pink color */
    margin-bottom: 10px;
}

.team .heading h1 {
    font-size: 2.5rem;
    font-weight: bold;
    color: #333;
}

.team .heading img {
    width: 300px; /* Adjust separator size */
    margin-bottom: 20px;
}

.team .box-container {
    background-image:url('image/bn3.3.webp');
    no-repeat center center; /* Add your background image */
    background-size: cover; 
    object-fit: cover;
    display: flex;
    justify-content: center;
    gap: 30px;
    flex-wrap: wrap;
}

.team .box {
    background-color: #fff;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
    max-width: 300px;
    text-align: center;
    transition: transform 0.3s;
}

.team .box:hover {
    transform: translateY(-10px); /* Slight lift effect on hover */
}

.team .box img {
    width: 100%;
    height: auto;
    border-radius: 10px;
    object-fit: cover; /* Ensures the image covers the box without distortion */
}

.team .content {
    margin-top: 15px;
}

.team .content img {
    width: 50px; /* Adjust icon size */
    margin-bottom: 10px;
}

.team .content h2 {
    font-size: 1.5rem;
    color: #333;
    margin-bottom: 5px;
}

.team .content p {
    font-size: 1rem;
    color: #666;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .team .box-container {
        flex-direction: column;
        align-items: center;
    }

    .team .box {
        max-width: 100%;
        margin-bottom: 20px;
    }
}

.standards {
    padding: 50px 0;
    background-color: #f4f4f4; /* Light gray background */
    text-align: center;
}

.standards .detail {
    background-color: #fff; /* White background for fallback */
    padding: 30px;
    border-radius: 10px; /* Rounded corners for the content box */
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1); /* Soft shadow for depth */
    max-width: 1400px;
    margin: 0 auto; /* Centers the content */
    background-image: url('image/std.jpg'); /* Add your image URL here */
    background-size: cover; /* Ensure the image covers the box */
    background-position: center; /* Center the background image */
    color: #fff; /* White text color for contrast */
}

.standards .heading {
    margin-bottom: 20px;
}

.standards .heading h1 {
    font-size: 2.5rem;
    font-weight: bold;
    color: black; /* White text for heading on dark background */
    margin-bottom: 10px;
}

.standards .heading img {
    width: 300px;
    margin-bottom: 20px;
}

.standards p {
    font-size: 1.2rem;
    line-height: 1.8;
    color: black; /* White text color for paragraphs */
    max-width: 800px;
    text-align: left; /* Center the background image */

    margin-left:3px;
}

.standards i {
    font-size: 2rem;
    color: #ff6f61; /* Soft red color for icons */
    margin-bottom: 10px;
    display: block;
}

.standards .bx-bxs-heart {
    font-size: 2rem; /* Icon size */
    margin-bottom: 10px; /* Space between icons */
}

.standards .bx-bxs-heart:hover {
    color: #e74c3c; /* Change color on hover */
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .standards .heading h1 {
        font-size: 2rem;
    }

    .standards p {
        font-size: 1rem;
    }
}/* Overall Container */
.testimonial1 {
    max-width: 800px;
    margin: auto;
    text-align: center;
    font-family: Arial, sans-serif;
}

/* Heading Styles */
.heading h1 {
    font-size: 2em;
    margin-bottom: 10px;
}

.heading img {
    width: 100px;
    margin-bottom: 20px;
}

/* Slider Container */
.slider-container {
    position: relative;
    overflow: hidden;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 20px;
    background-color: #f9f9f9;
}

/* Slider Wrapper */
.slider {
    display: flex;
    transition: transform 0.5s ease;
}

/* Individual Slide */
.sliderBox {
    min-width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    opacity: 0.5;
    transition: opacity 0.5s ease;
}

/* Active Slide */
.sliderBox.active {
    opacity: 1;
}

/* User Image */
.user-img img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    margin-bottom: 10px;
    border: 2px solid #007bff;
}

/* User Text */
.user-text {
    background: #fff;
    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.user-text h2 {
    font-size: 1.2em;
    margin: 10px 0 5px;
    color: #333;
}

.user-text p {
    margin: 0;
    color: #666;
}

/* Controls for navigation dots */

.controls {
    display: flex;
    justify-content: center;
    margin-top: 10px;
    list-style-type: none;
}

.controls li {
    width: 10px;
    height: 10px;
    background-color: #bbb;
    border-radius: 50%;
    margin: 0 5px;
    cursor: pointer;
}

.controls .active {
    background-color: #007bff;
}
.mission {
    background-image: url('image/bg1.webp'); /* Correct background image syntax */
    background-position: center;
    background-size: cover;
    padding: 2rem 4%;
    position: relative;
}

.mission .box-container {
    display: flex;
    flex-direction: row; /* Horizontal layout for the mission and man image */
    align-items: flex-start; /* Align items at the top */
    gap: 2rem; /* Space between mission details and the man image */
}

.mission .box {
    flex: 2; /* Mission section takes more space */
    display: flex;
    flex-direction: column; /* Stack mission details vertically */
    gap: 1.5rem; /* Space between mission detail blocks */
}

.mission .box .detail {
    display: flex;
    align-items: center;
    gap: 1rem; /* Space between image and text */
    background-color: rgba(255, 255, 255, 0.8); /* Optional: Add a light background */
    padding: 1rem; /* Padding for better spacing */
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
}

.mission .box .detail .img-box img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px dashed var(--main-color); /* Dashed border */
}

.mission .box .detail h2 {
    color: var(--main-color);
    font-size: 1.5rem;
    margin: 0;
}

.mission .box .detail p {
    color: #666;
    line-height: 1.6;
    margin: 0;
    font-size: 1rem;
}

.mission .side-image {
    flex: 1; /* Man's image takes less space */
    display: flex;
    align-items: center; /* Vertically align the image */
    justify-content: center; /* Horizontally center the image */
}

.mission .side-image img {
    max-width: 100%;
    height: 900px;
    object-fit: contain; /* Ensure the image is not distorted */
}




/* Slider Buttons */
button {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    font-size: 1em;
}

#prevBtn {
    left: 10px;
}

#nextBtn {
    right: 10px;
}

button:hover {
    background-color: #0056b3;
}
   .content h2 {
    font-size: 1.3rem;
    color: #333;
    margin-bottom: 10px;
}

.content p {
    font-size: 1rem;
    color: #666;
    line-height: 1.5;
    max-width: 300px;
    margin: 0 auto;
}


@media (max-width: 768px) {
    .testimonial1 .heading h1 {
        font-size: 2rem;
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
        <p>Delightful Creamery is the fastest, easiest and most convenient way to enjoy the best food of your favourite restaurants at home, at the office or wherever you want to.

We know that your time is valuable and sometimes every minute in the day counts. That’s why we deliver! So you can spend more time doing the things you love.</p>
        <span><a href="home.php" class="btn">Home</a><i class="bx bx-right-arrow-alt"></i>About Us</span>
    </div>
</div>
<div class="chef">
<div class="box-container">
<div class="box">
<div class="heading">
        <span>Dilip</span>
        <h1>Masterchef</h1>
        <img src="image/separator-img.png">
        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Vitae perferendis dicta architecto reprehenderit ad saepe. Sint, dolorum non ducimus provident laudantium, amet reiciendis est aut aspernatur nesciunt obcaecati cumque sapiente!</p>

       <a href="" class="btn">Explore our menu</a>
       <a href="menu.php"class="btn">Visit our shop</a>
</div>
</div>
<div class="box">
<img src="uploaded_files\FlaZBaUsWLyzwEPx2aOh.jpg">
</div>
</div>

<div class="story">
    <div class="heading">
        <h1>Our Story</h1>
        <img src="image/separator-img.png">
</div>
<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis excepturi, recusandae iusto nulla molestiae, quidem magnam, in totam eligendi perferendis eveniet ipsam consequatur voluptatem ratione repudiandae voluptatibus! Animi, voluptatum dolorum. <br>Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio, officia exercitationem. Voluptates doloremque sit hic sapiente consequuntur. Voluptates veritatis ab aspernatur. Nulla accusantium voluptatibus hic vel praesentium eos labore unde?<br>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Autem eius minus doloribus ratione unde ut asperiores, totam voluptas quae vero perferendis natus ad non corrupti delectus esse accusantium nam? Vero.<br>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consectetur ea obcaecati officia quam atque doloribus fuga, facere iure autem quidem eveniet illo, provident laboriosam necessitatibus quia reprehenderit commodi laborum modi.</p>
<a href="menu.php" class="btn">Our Services</a>

</div>
<div class="container">
    <div class="box-container">
        <div class="img-box">
            <img src="image/about.png">
</div>
<div class="box">
    <div class="heading">
        <h1>Taking ice-cream to New Height</h1>
        <img src="image/separator-img.png">
</div>
<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa, optio tenetur. Accusantium doloribus impedit nam magni nihil voluptates expedita mollitia. Iure delectus et voluptatum repellendus blanditiis autem quis, ipsam nostrum? Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex autem facilis nobis distinctio blanditiis esse et? Aperiam distinctio excepturi iusto blanditiis pariatur, ad tempore quos maxime eaque numquam quaerat non. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Vero harum asperiores voluptatem unde, quas ipsum, perspiciatis tenetur repellendus eveniet nemo ipsa iure excepturi fugiat voluptate nostrum quidem voluptas similique perferendis? </p>
<a href="" class="btn">Learn More</a>
</div>
</div>
</div>
<div class="team">
<div class="heading">
    <span>Our Team</span>
        <h1>Quality and passion with our services</h1>
        <img src="image/separator-img.png" alt="">
</div>
<div class="box-container">
<div class="box">
        
        <img src="image/team-1.jpg" alt="">
        <div class="content">
        <img src="image/shape-19.png" alt="shap">
        <h2>Ralp Johnson</h2>
        <p>Coffee chef</p>
      </div>
</div>
<div class="box">
        
        <img src="image/team-2.jpg" alt="">
        <div class="content">
        <img src="image/shape-19.png" alt="shap">
        <h2>Fiona Johnson</h2>
        <p>Pastry chef</p>
      </div>
</div>
<div class="box">
        
        <img src="image/team-3.jpg" alt="">
        <div class="content">
        <img src="image/shape-19.png" alt="shap">
        <h2>Tom Knelltonns</h2>
        <p>Coffee chef</p>
      </div>
</div>
    </div>
</div>
<div class="standards">
    <div class="detail">
        <div class="heading">
            <h1>Our Standarts</h1>
            <img src="image/separator-img.png">
</div>
<p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius dolorem similique ut aut officia id inventore! Distinctio nam exercitationem aspernatur quaerat minima a perferendis similique, modi veniam, ipsa harum minus?</p>
<i class="bx-bxs-heart"></i>
<p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius dolorem similique ut aut officia id inventore! Distinctio nam exercitationem aspernatur quaerat minima a perferendis similique, modi veniam, ipsa harum minus?</p>
<i class="bx-bxs-heart"></i>
<p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius dolorem similique ut aut officia id inventore! Distinctio nam exercitationem aspernatur quaerat minima a perferendis similique, modi veniam, ipsa harum minus?</p>
<i class="bx-bxs-heart"></i>
<p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius dolorem similique ut aut officia id inventore! Distinctio nam exercitationem aspernatur quaerat minima a perferendis similique, modi veniam, ipsa harum minus?</p>
<i class="bx-bxs-heart"></i>
<p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius dolorem similique ut aut officia id inventore! Distinctio nam exercitationem aspernatur quaerat minima a perferendis similique, modi veniam, ipsa harum minus?</p>
<i class="bx-bxs-heart"></i>
</div>
</div>
<div class="testimonial1">
    <div class="heading">
        <h1>Testimonial</h1>
        <img src="image/separator-img.png" alt="Separator">
    </div>
    <div class="slider-container">
        <div class="slider">
            <!-- Testimonial Slide 1 -->
            <div class="sliderBox">
                <div class="user-img">
                    <img src="image/testimonial (1).jpg" alt="User 1">
                </div>
                <div class="user-text">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis quos soluta ipsam nemo sint sequi.</p>
                    <h2>Zen</h2>
                    <p>Author</p>
                </div>
            </div>
            <!-- Testimonial Slide 2 -->
            <div class="sliderBox">
                <div class="user-img">
                    <img src="image/testimonial (2).jpg" alt="User 2">
                </div>
                <div class="user-text">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis quos soluta ipsam nemo sint sequi.</p>
                    <h2>Anna</h2>
                    <p>Author</p>
                </div>
            </div>
            <!-- Testimonial Slide 3 -->
            <div class="sliderBox">
                <div class="user-img">
                    <img src="image/testimonial (3).jpg" alt="User 3">
                </div>
                <div class="user-text">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis quos soluta ipsam nemo sint sequi.</p>
                    <h2>Mike</h2>
                    <p>Author</p>
                </div>
            </div>
            <!-- Testimonial Slide 4 -->
            <div class="sliderBox">
                <div class="user-img">
                    <img src="image/testimonial (4).jpg" alt="User 4">
                </div>
                <div class="user-text">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis quos soluta ipsam nemo sint sequi.</p>
                    <h2>Linda</h2>
                    <p>Author</p>
                </div>
            </div>
        </div>

        <!-- Controls for slider -->
        <ul class="controls">
            <li class="control-dot"></li>
            <li class="control-dot"></li>
            <li class="control-dot"></li>
            <li class="control-dot"></li>
        </ul>

        <ul class="controls">
        <li onclick="nextSlide();" class="next"><i class="fas fa-arrow-right"></i></li>
        <li onclick="prevSlide();" class="prev"><i class="fas fa-arrow-left"></i></li>
    </ul>
</div>
</div>

</div>
</div>
<div class="indicator">
    <span class="btn1 active"></span>
    <span class="btn1"></span>
    <span class="btn1"></span>
    <span class="btn1"></span>

</div>
</div>
<div class="mission">
    <div class="box-container">
        <!-- Mission Details -->
        <div class="box">
            <div class="heading">
                <h1>Our mission</h1>
                <img src="image/separator-img.png" alt="separator">
            </div>
            <div class="detail">
                <div class="img-box">
                    <img src="image/mission.webp" alt="Mexican Chocolate">
                </div>
                <div>
                    <h2>Mexican Chocolate</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptas sint ratione explicabo perspiciatis rerum odit facere quod quibusdam!</p>
                </div>
            </div>
            <div class="detail">
                <div class="img-box">
                    <img src="image/mission1.webp" alt="Vanilla with Honey">
                </div>
                <div>
                    <h2>Vanilla with Honey</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptas sint ratione explicabo perspiciatis rerum odit facere quod quibusdam!</p>
                </div>
            </div>
            <div class="detail">
                <div class="img-box">
                    <img src="image/mission0.jpg" alt="Peppermint Chip">
                </div>
                <div>
                    <h2>Peppermint Chip</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptas sint ratione explicabo perspiciatis rerum odit facere quod quibusdam!</p>
                </div>
            </div>
            <div class="detail">
                <div class="img-box">
                    <img src="image/mission2.webp" alt="Raspberry Sorbet">
                </div>
                <div>
                    <h2>Raspberry Sorbet</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptas sint ratione explicabo perspiciatis rerum odit facere quod quibusdam!</p>
                </div>
            </div>
        </div>
        
        <!-- Man Image -->
        <div class="side-image">
        <img src="image/form.png"  alt="Man Pointing">
        </div>
    </div>
</div>

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
