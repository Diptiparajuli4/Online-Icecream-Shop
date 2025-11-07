

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
    <title>Delightful Creamery - Home Page</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
  
</head>
<body>

<section class="flex">
    <!-- Logo displayed directly in the main file to avoid any address issues -->
    <a class="logo">
        <img src="image/logo.png" width="130px" alt="Delightful Creamery Logo">
    </a>
</section>

<?php include 'components/user_header.php'; ?>

<div class="slider-container">
    <div class="slider">
        <div class="sliderBox active">
            <div class="textBox">
                <h1>We pride ourself on <br>exceptional flavors</h1>
                <a href="menu.php" class="btn">Shop now</a>
            </div>
            <div class="imgBox">
                <img src="image/slider.jpg" alt="Slider Image 1">
            </div>
        </div>
        <div class="sliderBox">
            <div class="textBox">
                <h1>Cold treats are my kind <br>of comfort food</h1>
                <a href="menu.php" class="btn">Shop now</a>
            </div>
            <div class="imgBox">
                <img src="image/slider0.jpg" alt="Slider Image 2">
            </div>
        </div>
    </div>
 
    <ul class="controls">
        <li onclick="nextSlide();" class="next"><i class="fas fa-arrow-right"></i></li>
        <li onclick="prevSlide();" class="prev"><i class="fas fa-arrow-left"></i></li>
    </ul>
</div>

<!---service item box---->
<div class="service">
    <div class="box-container">
        <div class="box">
            <div class="icon">
                <img src="image/services.png" class="img1">
                <img src="image/services (1).png" class="img2">
            </div>
            <div class="detail">
                <h4>Delivery</h4>
                <span>100% secure</span>
            </div>
        </div>

        <div class="box">
            <div class="icon">
                <img src="image/services (2).png" class="img1">
                <img src="image/services (3).png" class="img2">
            </div>
            <div class="detail">
                <h4>Service</h4>
                <span>Best service</span>
            </div>
        </div>

        <div class="box">
            <div class="icon">
                <img src="image/services (5).png" class="img1">
                <img src="image/services (6).png" class="img2">
            </div>
            <div class="detail">
                <h4>Support</h4>
                <span>24*7 hours</span>
            </div>
        </div>
        <div class="box">
            <div class="icon">
                <img src="image/service.png" class="img1">
                <img src="image/service (1).png" class="img2">
            </div>
            <div class="detail">
                <h4>Return</h4>
                <span>24*7 hours return</span>
            </div>
        </div>

        <div class="box">
            <div class="icon">
                <img src="image/services (7).png" class="img1">
                <img src="image/services (8).png" class="img2">
            </div>
            <div class="detail">
                <h4>Gift Service</h4>
                <span>Support gift services</span>
            </div>
        </div>
    </div>
</div>

<div class="categories">
            <div class="heading">
                <h1>Categories features</h1>
                <img src="image/separator-img.png" >
            </div>
            <div class="box-container">
                <div class="box">
                    <img src="image/categories.jpg">
                    <a href="menu.php" class="btn">coconuts</a>
    </div>
    <div class="box">
                    <img src="image/categories0.jpg">
                    <a href="menu.php" class="btn">chocolates</a>
    </div>
    <div class="box">
                    <img src="image/categories2.jpg">
                    <a href="menu.php" class="btn">strawberry</a>
    </div>
    <div class="box">
                    <img src="image/categories1.jpg">
                    <a href="menu.php" class="btn">corn</a>
    </div>
    </div>
    </div>
    <img src="image/menu-banner.jpg"class="menu-banner">
           
    <div class="taste">
    <div class="heading">
        <span>Taste</span>
                <h1>Buy any ice cream @get one free</h1>
                <img src="image/separator-img.png" >
            </div>

            <div class="box-container">
               
            <div class="box">
                    <img src="image/taste.webp">
                    <div class="detail">
                        <h2>natural sweetness</h2>
                        <h1>Vanila</h1>
</div>
</div>
<div class="box">
                    <img src="image/taste0.webp">
                    <div class="detail">
                        <h2>natural sweetness</h2>
                        <h1>Matcha</h1>
</div>
</div>
<div class="box">
                    <img src="image/taste1.webp">
                    <div class="detail">
                        <h2>natural sweetness</h2>
                        <h1>Blueberry</h1>
</div>
</div>
</div>
</div>
<div class="ice-container">
    <div class="overlay"></div>
    <div class="detail">
        <h1>Ice cream is cheaper than<br>therapy for stress</h1>
        <p>Wider Range,Bigger Choice<br>Click Down to Visit Shop</p>
        <a href="menu.php"class="btn">Shop now</a>
</div>
</div>
<div class="taste2">
    <div class="t-banner">
        <div class="overlay"></div>
        <h1>find your taste of deserts</h1>
        <p>Treat them to a delicious treat and send them some luck 'o the Irish too!</p>
        <a href="menu.php" class="btn">shop now</a>
</div>
<div class="box-container">
    <div class="box">
        <div class="box-overlay"></div>
        <img src="image/type4.jpg">
        <div class="box-details fadeIn-bottom">
        <h1>Strawberry</h1>
        <p>find your taste of deserts</p>
        <a href="menu.php" class="btn">Explore more</a>
</div>
</div>
    <div class="box">
        <div class="box-overlay"></div>
        <img src="image/type4.jpg">
        <div class="box-details fadeIn-bottom">
        <h1>Strawberry</h1>
        <p>find your taste of deserts</p>
        <a href="menu.php" class="btn">Explore more</a>
</div>
</div>
<div class="box">
        <div class="box-overlay"></div>
        <img src="image/type4.jpg">
        <div class="box-details fadeIn-bottom">
        <h1>Strawberry</h1>
        <p>find your taste of deserts</p>
        <a href="menu.php" class="btn">Explore more</a>
</div>
</div>

<div class="box">
        <div class="box-overlay"></div>
        <img src="image/type0.avif">
        <div class="box-details fadeIn-bottom">
        <h1>Strawberry</h1>
        <p>find your taste of deserts</p>
        <a href="menu.php" class="btn">Explore more</a>
</div>
</div>
</div>
</div>
<div class="flavor">
    <div class="box-container">
        <img src="image/left-banner2.webp">
        <div class="detail">
            <h1>Hot Deal ! Sale Up To <span> 20% off</span></h1>
            <p>expired</p>
            <a href="menu.php" class="btn">shop now</a>
</div>
</div>
</div>
<div class="usage">
    <div class="heading">
        <h1>how it works</h1>
        <img src="image/separator-img.png">
</div>
<div class="row">
    <div class="box-container">
        <div class="box">
            <img src="image/icon.avif">
            <div class="detail">
                <h3>scoop ice-cream</h3>
                <p> Frozen cakes that incorporate ice cream fully or sometimes only partly.!</p>
</div>
</div>
<div class="box">
            <img src="image/icon0.avif">
            <div class="detail">
                <h3>scoop ice-cream</h3>
                <p>  Industrially made ice cream, which are frozen and solidified with small wooden sticks protruding from their bodies.!</p>
</div>
</div>
<div class="box">
            <img src="image/icon1.avif">
            <div class="detail">
                <h3>scoop ice-cream</h3>
                <p>  Edible hollow cone in which ice cream is poured.!</p>
</div>
</div>
</div>
<img src="image/sub-banner.png" class="divider">
<div class="box-container">
        <div class="box">
            <img src="image/icon2.avif">
            <div class="detail">
                <h3>scoop ice-cream</h3>
                <p> It consists of the tall glass, few scoops of ice creams and many additional syrups and toppings.!</p>
</div>
</div>
<div class="box">
            <img src="image/icon3.avif">
            <div class="detail">
                <h3>scoop ice-cream</h3>
                <p> Liquid desert that uses carbonated bubbles to ensure that one scoop of ice cream floats on the top of the glass.!</p>
</div>
</div>
<div class="box">
            <img src="image/icon4.avif">
            <div class="detail">
                <h3>scoop ice-cream</h3>
                <p>  Liquid desert that uses carbonated bubbles to ensure that one scoop of ice cream floats on the top of the glass.!</p>
</div>
</div>
</div>
</div>
</div>
<div class="pride">
    <div class="detail">
        <h1>We Pride Ourselves On<br>Exceptional Flavors.</h1>
        <p>We pride ourselves in fresh  made offerings and are no exception!.</p>
        <a href="menu.php" class="btn">shop now</a>
    </div>
</div>

<?php include 'components/footer.php'; ?>

<script>
    let currentSlide = 0;

    function showSlide(index) {
        const slides = document.querySelectorAll('.sliderBox');
        const controls = document.querySelectorAll('.controls li');

        if (index >= slides.length) {
            currentSlide = 0;
        } else if (index < 0) {
            currentSlide = slides.length - 1;
        } else {
            currentSlide = index;
        }

        const offset = -100 * currentSlide; // Slide transition in percentage
        document.querySelector('.slider').style.transform = `translateX(${offset}%)`;

        slides.forEach((slide, i) => {
            slide.classList.remove('active');
            controls[i].classList.remove('active');
        });

        slides[currentSlide].classList.add('active');
        controls[currentSlide].classList.add('active');
    }

    function nextSlide() {
        showSlide(currentSlide + 1);
    }

    function prevSlide() {
        showSlide(currentSlide - 1);
    }

    setInterval(nextSlide, 3000); // Auto slide every 5 seconds
</script>

</body>
</html>
