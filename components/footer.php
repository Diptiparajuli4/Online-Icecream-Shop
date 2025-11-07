<style>
/* Newsletter Section Styling */
.newsletter {
    background-image: url('image/bn3.3.webp');
    background-repeat: no-repeat;
    background-size: cover;
    background-attachment: fixed;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 70px 20px 100px;
    text-align: center;
    color: #333;
}

/* Content Span Styling */
.newsletter span {
    font-size: 1rem;
    background-color: var(--pink-opacity);
    color: var(--main-color);
    text-transform: uppercase;
    border-radius: 15px;
    padding: 0.5rem 1rem;
    font-weight: 600;
    margin-bottom: 1rem;
    display: inline-block;
}

/* Heading Styling */
.newsletter h1 {
    font-size: 2.5rem;
    margin: 0.5rem 0 1rem;
    color: #444;
}

/* Paragraph Styling */
.newsletter p {
    font-size: 1.1rem;
    color: gray;
    line-height: 1.6;
    max-width: 700px;
    margin: 0 auto 1.5rem;
}

/* Input Field Styling */
.newsletter .input-field {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-bottom: 2rem;
}

.newsletter input[type="email"] {
    padding: 1rem;
    border-radius: 10px;
    width: 30vw;
    background-color: var(--pink-opacity);
    border: 1px solid #ddd;
    font-size: 1rem;
    color: #333;
}


/* Box Container Styling */
.newsletter .box-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 2rem;
    margin-top: 2rem;
}

.newsletter .box {
    background-color: var(--pink-opacity);
    box-shadow: var(--box-shadow);
    padding: 2rem 2.5rem;
    border-radius: 10px;
    text-align: center;
    color: #333;
    width: 350px;
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: transform 0.3s ease;
}

.newsletter .box:hover {
    transform: translateY(-5px); /* Adds a hover lift effect */
}

.newsletter .box-counter {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.3rem;
    font-size: 9.5rem;
    color: #000;
    font-weight: bold;
    margin-bottom: 1rem;
}
.newsletter .box-counter .counter{
    font-size:3.5rem;
    color:black;
}

.newsletter .box h3 {
    font-size: 1.5rem;
    color: var(--main-color);
    margin: 0.5rem 0;
}

.newsletter .box p {
    font-size: 1rem;
    color: gray;
}

.content .input-field .btn {
    background-color:var(--pink-opacity);
}
/* Responsive Adjustments */
@media (max-width: 768px) {
    .newsletter h1 {
        font-size: 2rem;
    }

    .newsletter p {
        font-size: 1rem;
    }

    .newsletter input[type="email"] {
        width: 60vw;
    }

    .newsletter .box {
        width: 100%;
        padding: 2rem;
    }
}/* Footer Styling */
footer {
    background-image: url('image/footer-bg.jpg'); /* Footer background image */
    background-color: rgba(249, 230, 229, 0.9); /* Soft pink with opacity */
    padding: 50px 20px;
    color: #333;
    font-family: Arial, sans-serif;
    text-align: center;
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    position: relative;
    background-size: cover; /* Ensure background image covers the entire footer */
    background-position: center; /* Align the background image to the center */
}

/* Center Content Layout */
footer .content {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between; /* Space between boxes */
    align-items: flex-start; /* Align items at the top */
    max-width: 1200px;
    margin: 0 auto;
    position: relative;
}

/* Footer Box Styling */
footer .box {
    flex: 1 1 220px;
    width: 240px; /* Make boxes have a fixed width */
    margin-bottom: 20px;
    background: rgba(255, 255, 255, 0.3); /* Transparent white background for boxes */
    backdrop-filter: blur(10px); /* Optional: adds blur effect to background image behind box */
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    color: #333;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Adds shadow for better visibility */
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* Box Hover Effect */
footer .box:hover {
    transform: translateY(-5px); /* Slightly lift boxes on hover */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Enhanced shadow on hover */
}

/* Logo and Contact Button */
footer .box img {
    width: 130px;
    margin-bottom: 1rem;
}

footer .box p, 
footer .box a {
    color: #555;
    line-height: 1.6;
    font-size: 1rem;
}

/* Headings */
footer .box h3 {
    font-size: 1.2rem;
    color: #333;
    font-weight: bold;
    margin-bottom: 1rem;
}

/* Links Styling for Lists */
footer .box ul {
    list-style: none; /* Remove default list styling */
    padding: 0;
}

footer .box li {
    display: block; /* Ensure each list item is on a new line */
    margin-bottom: 10px; /* Add space between the list items */
}

footer .box a {
    color: #333;
    text-decoration: none;
    font-size: 0.95rem;
    display: block; /* Makes each link behave like a block-level element */
}

footer .box a:hover {
    color: #ff7f81; /* Soft pink color on hover */
}

/* Contact Icons Styling */
footer .box p i,
footer .icons i {
    color: #ff7f81;
    margin-right: 8px;
    font-size: 1.2rem;
}

/* Social Media Icons */
footer .icons {
    display: flex;
    gap: 15px;
    margin-top: 1rem;
    justify-content: center;
}

footer .icons i {
    font-size: 1.3rem;
    color: #777;
    transition: color 0.3s;
    cursor: pointer;
}

footer .icons i:hover {
    color: #ff7f81;
}

/* Bottom Footer */
footer .bottom {
    text-align: center;
    padding-top: 20px;
    border-top: 1px solid black;
    font-size: 0.85rem;
    color: #777;
    margin-top: 30px;
}

footer .bottom p,
footer .bottom a {
    color: #777;
    text-decoration: none;
    font-size: 1.5rem;
}

footer .bottom a {
    color: #ff7f81;
    font-weight: bold;
    margin-left: 5px;
}

footer .bottom a:hover {
    color: var(--pink-color);
}

/* Responsive Footer */
@media (max-width: 768px) {
    footer .content {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    footer .box {
        flex: 1 1 100%;
        margin-bottom: 30px; /* Add space between boxes */
    }

    footer .icons {
        justify-content: center;
    }

    footer .bottom {
        padding-top: 30px;
        font-size: 0.8rem;
    }
}




    </style>
   
        <link rel="stylesheet" type="text/css" href="css/user_style.css">
<div class="newsletter">
    <div class="content">
        <span>get latest Delightful Creamery updates</span>
        <h1>subscribe our newsletter</h1>
        <p>Please fill out the form below and submit if you have any feedback or queries about our service.!</p>
    <div class="input-field">
        <input type="email" name="" placeholder="Enter your E-mail">
        <button class="btn">subscribe</button>
</div>
<p>No ads,No trails,No commitmen</p>
<div class="box-container">
    <div class="box">
        <div class="box-counter"><p  class="counter">5000 +</p><i class="bx-bx-plus"></i></div>
        <h3> Successfully Trained</h3>
        <p>Learner & counting</p>
</div>
<div class="box">
        <div class="box-counter"><p  class="counter">10000 +</p><i class="bx-bx-plus"></i></div>
        <h3> Certificate seller</h3>
        <p>Online seller</p>
</div>
</div>
</div>
</div>
<footer>
    <div class="content">
        <div class="box">
        <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

            <img src="image/logo.png">
            <p>We're always in search for talented and motivated people.Don't be shy introduce yourself!</p>
            
</div>
<div class="box">
    <h3>my account</h3>        
    <a href=""><i class="bx-bx-chevron-right"></i>My account</a>
    <a href=""><i class="bx-bx-chevron-right"></i>Order history</a>
    <a href=""><i class="bx-bx-chevron-right"></i>Whitelist</a>
    <a href=""><i class="bx-bx-chevron-right"></i>Newsletter</a>
</div>
<div class="box">
    <h3>Information</h3>        
    <a href=""><i class="bx-bx-chevron-right"></i>About us</a>
    <a href=""><i class="bx-bx-chevron-right"></i>Deliver Information</a>
    <a href=""><i class="bx-bx-chevron-right"></i>Privacy policy</a>
    <a href=""><i class="bx-bx-chevron-right"></i>Terms & Condition</a>

</div>

<div class="box">
    <h3>Extras</h3>        
    <a href=""><i class="bx-bx-chevron-right"></i>Brands</a>
    <a href=""><i class="bx-bx-chevron-right"></i>Gift Certification</a>
    <a href=""><i class="bx-bx-chevron-right"></i>Affiliate</a>
    <a href=""><i class="bx-bx-chevron-right"></i>Specials</a>
</div>

<div class="box">
    <h3>Contact Us</h3>
    <p><i class="bx bxs-phone"></i>01-2345678</p>     
    <p><i class="bx bxs-envelope"></i>deeptiparajuli4@gmail.com</p>     
    <p><i class="bx bxs-location-plus"></i>Kathmandu, Nepal</p>     
    <div class="icons">
        <i class="bx bxl-facebook"></i>
        <i class="bx bxl-twitter"></i>
        <i class="bx bxl-instagram"></i>
        <i class="bx bxl-linkedin"></i>
    </div>
</div>

  
</div>
<div class="bottom">
    <p>Copyright @ 2023 code with Dipti.All Rights Reserved</p>
    <a href="admin panel/login.php">become a seller</a>
</div>
</footer>
