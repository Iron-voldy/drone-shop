<?php
session_start();
require 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit();
}

// Fetch drones from the database
$query = "SELECT * FROM drones ORDER BY created_at DESC";
$result = Database::search($query);
$drones = $result->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Drone Photography</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <!-- CSS here -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/progressbar_barfiller.css">
    <link rel="stylesheet" href="assets/css/gijgo.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/animated-headline.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/css/nice-select.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
    .product-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        transition: 0.3s ease-in-out;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
    }
    .product-image img {
        width: 80%;
        border-radius: 10px;
    }
    .product-details {
        margin-top: 15px;
        text-align: center;
    }
    .product-title {
        font-size: 18px;
        color: #333;
        font-weight: bold;
        text-decoration: none;
    }
    .product-description {
        font-size: 14px;
        color: #666;
        margin-bottom: 10px;
    }
    .product-price {
        font-size: 16px;
        font-weight: bold;
        color: #28a745;
        margin-bottom: 15px;
    }
    .product-actions {
        display: flex;
        justify-content: space-between;
        width: 100%;
        padding-top: 10px;
    }
    .product-actions button {
        flex: 1;
        margin: 5px;
        padding: 10px 12px;
        font-size: 14px;
        border-radius: 5px;
        transition: 0.3s;
        white-space: nowrap;
    }
    .product-actions button i {
        margin-right: 5px;
    }
    .product-actions button:hover {
        transform: scale(1.05);
    }
</style>

</head>

<body>
    <!-- ? Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="assets/img/logo/loder.png" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader Start -->
    <header>
        <!-- Header Start -->
        <div class="header-area header-transparent">
            <div class="main-header ">
                <div class="header-bottom  header-sticky">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <!-- Logo -->
                            <div class="col-xl-2 col-lg-2">
                                <div class="logo">
                                    <a href="index.html"><img src="assets/img/logo/logo.png" alt=""></a>
                                </div>
                            </div>
                            <div class="col-xl-10 col-lg-10">
                                <div class="menu-wrapper  d-flex align-items-center justify-content-end">
                                    <!-- Main-menu -->
                                    <div class="main-menu d-none d-lg-block">
                                        <nav>
                                            <ul id="navigation">
                                                <li><a href="index.php">Home</a></li>
                                                <li><a href="about.html">About</a></li>
                                                <li><a href="services.php">Products</a></li>
                                                <li><a href="contact.html">Contact</a></li>
                                                <!-- Header btn -->
                                                <li>
                                                    <div class="header-right-btn ml-40">
                                                        <a href="#" class="btn"><img src="assets/img/icon/smartphone.svg" alt="">Profile</a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <!-- Mobile Menu -->
                            <div class="col-12">
                                <div class="mobile_menu d-block d-lg-none"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>
    <main>
        <!--? slider Area Start-->
        <section class="slider-area ">
            <div class="slider-active">
                <!-- Single Slider -->
                <div class="single-slider slider-bg1 hero-overly slider-height d-flex align-items-center">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-xl-8 col-lg-9 col-md-12">
                                <div class="hero__caption text-center">
                                    <h1 data-animation="bounceIn" data-delay="0.2s">Drone Photography<br> & Videography</h1>
                                    <p data-animation="fadeInUp" data-delay="0.4s">Duis aute irure dolor inasfa reprehenderit in voluptate
                                        velit esse cillum reeut cupidatatfug.</p>
                                    <a href="#" class="hero-btn" data-animation="fadeInUp" data-delay="0.7s">Explore services</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Single Slider -->
                <div class="single-slider slider-bg1 hero-overly slider-height d-flex align-items-center">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-xl-8 col-lg-9 col-md-12">
                                <div class="hero__caption text-center">
                                    <h1 data-animation="bounceIn" data-delay="0.2s">Drone Photography<br> & Videography</h1>
                                    <p data-animation="fadeInUp" data-delay="0.4s">Duis aute irure dolor inasfa reprehenderit in voluptate
                                        velit esse cillum reeut cupidatatfug.</p>
                                    <a href="#" class="hero-btn" data-animation="fadeInUp" data-delay="0.7s">Explore services</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- slider Area End-->
        <!--? About 1 Start-->
        <section class="about-low-area section-padding30">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-xl-6 col-lg-6 col-md-10">
                        <div class="about-caption mb-50">
                            <!-- Section Tittle -->
                            <div class="section-tittle mb-35">
                                <h2>Hassle-Free Drone<br> Photography</h2>
                            </div>
                            <p class="about-cap-top">Inasfa reprehenderit in voluptate velit esse
                                cillum reeut cupidatatfug nulla pariatur.</p>
                            <p>Aute irure dolor inasfa reprehenderit in voluptate velit esse
                                cillum reeut cupidatatfug nulla pariatur. Excepteur sintxsdfas
                                occaecat.</p>
                            <a href="#" class="btn black-btn">Explore services</a>
                        </div>
                    </div>
                    <div class="offset-xl-0 col-xl-6 offset-lg-0 col-lg-6 col-md-9 offset-md-1 offset-sm-1">
                        <div class="about-right-cap">
                            <div class="about-right-img">
                                <img src="assets/img/gallery/about1.png" alt="">
                            </div>
                            <div class="img-cap">
                                <span>20</span>
                                <p>Years of experience</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- About  End-->
        <!--? services area start -->
        <section class="services-section pb-padding fix">
    <div class="container">
        <div class="custom-row">
            <div class="services-active">
                <?php foreach ($drones as $drone) : ?>
                <div class="col-lg-4">
                    <div class="single-cat product-card">
                        <div class="product-image text-center">
                            <img src="<?php echo $drone['image_url']; ?>" alt="<?php echo $drone['name']; ?>">
                        </div>
                        <div class="product-details text-center">
                            <h5><a href="product-details.php?drone_id=<?php echo $drone['drone_id']; ?>" class="product-title">
                                <?php echo $drone['name']; ?>
                            </a></h5>
                            <p class="product-description"><?php echo $drone['description']; ?></p>
                            <p class="product-price"><strong>Price:</strong> $<?php echo number_format($drone['price'], 2); ?></p>
                        </div>

                        <!-- Buttons -->
                        <div class="product-actions d-flex justify-content-around flex-wrap">
                            <button class="btn btn-primary add-cart" onclick="addToCart(<?php echo $drone['drone_id']; ?>)"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
                            <button class="btn btn-warning add-wishlist" onclick="addToWishlist(<?php echo $drone['drone_id']; ?>)"><i class="fas fa-heart"></i> Wishlist</button>
                            <button class="btn btn-success buy-now" onclick="buyNow(<?php echo $drone['drone_id']; ?>)"><i class="fas fa-bolt"></i> Buy Now</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
        <!-- Services End -->
        <!--? video_start -->
        <div class="video-area section-bg2 d-flex align-items-end fix" data-background="assets/img/gallery/video-bg.png">
            <!-- Video icon -->
            <div class="video-icon">
                <a class="popup-video btn-icon" href="https://www.youtube.com/watch?v=up68UAfH0d0"><i class="fas fa-play"></i></a>
            </div>
            <div class="container">
                <div class="video-contents">
                    <div class="row justify-content-between">
                        <div class="col-xl-5 col-lg-5 col-md-10">
                            <div class="section-tittle  mb-90">
                                <h2>How we work?</h2>
                                <p class="tittle-pera1">Inasfa reprehenderit in voluptate velit esse cillum reeut cupidatatfug nulla pariatur.</p>
                                <p>Aute irure dolor inasfa reprehenderit in voluptate velit esse cillum reeut cupidatatfug nulla pariatur. Excepteur sintxsdfas occaecat.</p>
                                <a href="#" class="btn black-btn">Start a Project</a>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-6 col-md-8">
                            <div class="edu-details">
                                <!-- single-item -->
                                <div class="single-items mb-50">
                                    <span>Tell Us About Your Project</span>
                                    <p>Aute irure dolor inasfa prehenderit in voluptate velit esse cillum.</p>
                                </div>
                                <!-- single-item -->
                                <div class="single-items single-items2 mb-50">
                                    <span>We'll Schedule a Flight</span>
                                    <p>Aute irure dolor inasfa prehenderit in voluptate velit esse cillum.</p>
                                </div>
                                <!-- single-item -->
                                <div class="single-items single-items3 mb-50">
                                    <span>We'll Schedule a Flight</span>
                                    <p>Aute irure dolor inasfa prehenderit in voluptate velit esse cillum.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- video_end -->
        <!--? Testimonial Area Start -->
        <section class="testimonial-area testimonial-padding fix section-bg" data-background="assets/img/gallery/section_bg03.png">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class=" col-lg-9">
                        <div class="about-caption">
                            <!-- Testimonial Start -->
                            <div class="h1-testimonial-active dot-style">
                                <!-- Single Testimonial -->
                                <div class="single-testimonial position-relative">
                                    <div class="testimonial-caption">
                                        <img src="assets/img/icon/quotes-sign.png" alt="" class="quotes-sign">
                                        <p>"The automated process starts as soon as your clothe go into the machine. This site outcome is gleaming clothe. Placeholder text commonly used. In publishing and graphic.</p>
                                    </div>
                                    <!-- founder -->
                                    <div class="testimonial-founder d-flex align-items-center">
                                        <div class="founder-img">
                                            <img src="assets/img/icon/testimonial.png" alt="">
                                        </div>
                                        <div class="founder-text">
                                            <span>Robart Brown</span>
                                            <p>Creative designer at Colorlib</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single Testimonial -->
                                <div class="single-testimonial position-relative">
                                    <div class="testimonial-caption">
                                        <img src="assets/img/icon/quotes-sign.png" alt="" class="quotes-sign">
                                        <p>"The automated process starts as soon as your clothe go into the machine. This site outcome is gleaming clothe. Placeholder text commonly used. In publishing and graphic.</p>
                                    </div>
                                    <!-- founder -->
                                    <div class="testimonial-founder d-flex align-items-center">
                                        <div class="founder-img">
                                            <img src="assets/img/icon/testimonial.png" alt="">
                                        </div>
                                        <div class="founder-text">
                                            <span>Robart Brown</span>
                                            <p>Creative designer at Colorlib</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Testimonial End -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--? Testimonial Area End -->
        <div class="contact-form">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="form-wrapper">
                            <div class="row ">
                                <div class="col-xl-12 col-lg-11 col-md-8 col-lg-7 col-sm-9">
                                    <div class="section-tittle mb-30">
                                        <h2>Get a Quote</h2>
                                        <p>Inasfa reprehenderit in voluptate velit esse cillum reeut cupidatatfug nulla pariatur.</p>
                                    </div>
                                </div>
                            </div>
                            <form id="contact-form" action="#" method="POST">
                                <div class="row">
                                    <div class="col-lg-12 col-md-6">
                                        <div class="form-box user-icon mb-15">
                                            <input type="text" name="name" placeholder="Your Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-6">
                                        <div class="form-box email-icon mb-15">
                                            <input type="text" name="email" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-6">
                                        <div class="form-box email-icon mb-15">
                                            <input type="text" name="email" placeholder="Phone no.">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-6 mb-15">
                                        <div class="select-itms">
                                            <select name="select" id="select2">
                                                <option value="">Topic</option>
                                                <option value="">Topic one</option>
                                                <option value="">Topic Two</option>
                                                <option value="">Topic Three</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-box message-icon mb-15">
                                            <textarea name="message" id="message" placeholder="Message"></textarea>
                                        </div>
                                        <div class="submit-info">
                                            <button class="submit-btn2" type="submit">Send Message</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="contact-img">
                <img src="assets/img/gallery/contact-img.png" alt="">
            </div>
        </div>
    </main>
    <footer>
        <div class="footer-wrapper section-bg2" data-background="assets/img/gallery/footer-bg.png">
            <!-- Footer Start-->
            <div class="footer-area footer-padding">
                <div class="container">
                    <div class="row justify-content-between">
                        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-7">
                            <div class="single-footer-caption mb-50">
                                <div class="single-footer-caption mb-30">
                                    <!-- logo -->
                                    <div class="footer-logo mb-35">
                                        <a href="index.html"><img src="assets/img/logo/logo2_footer.png" alt=""></a>
                                    </div>
                                    <div class="footer-tittle">
                                        <div class="footer-pera">
                                            <p>Duis aute irure dolor inasfa reprehenderit in voluptate velit esse cillum reeut cupidatatfug.</p>
                                        </div>
                                        <ul class="mb-40">
                                            <li class="number"><a href="#">0779393662</a></li>
                                            <li class="number2"><a href="#">hasindut1@gmail.com</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="offset-xl-1 col-xl-2 col-lg-2 col-md-4 col-sm-6">
                            <div class="single-footer-caption mb-50">
                                <div class="footer-tittle">
                                    <h4>Navigation</h4>
                                    <ul>
                                        <li><a href="#">Home</a></li>
                                        <li><a href="#">About</a></li>
                                        <li><a href="#">Services</a></li>
                                        <li><a href="#">Blog</a></li>
                                        <li><a href="#">Contact</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6">
                            <div class="single-footer-caption mb-50">
                                <div class="footer-tittle">
                                    <h4>Services</h4>
                                    <ul>
                                        <li><a href="#">Drone Mapping</a></li>
                                        <li><a href="#"> Real State</a></li>
                                        <li><a href="#">Commercial</a></li>
                                        <li><a href="#">Construction</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                            <div class="single-footer-caption mb-50">
                                <!-- social -->
                                <div class="footer-social">
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="https://bit.ly/sai4ull"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#"><i class="fab fa-pinterest-p"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- footer-bottom area -->
            <div class="footer-bottom-area">
                <div class="container">
                    <div class="footer-border">
                        <div class="row">
                            <div class="col-xl-12 ">
                                <div class="footer-copy-right text-center">
                                    <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                        Copyright &copy;<script>
                                            document.write(new Date().getFullYear());
                                        </script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://hasindu-theekshana-theta.vercel.app" target="_blank">Hasindu Theekshana</a>
                                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End-->
        </div>
    </footer>
    <!-- Scroll Up -->
    <div id="back-top">
        <a title="Go to Top" href="#"> <i class="fas fa-level-up-alt"></i></a>
    </div>

    <script>
function addToCart(droneId) {
    fetch('add_to_cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `drone_id=${droneId}&quantity=1`
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
    });
}

function addToWishlist(droneId) {
    fetch('add_to_wishlist.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `drone_id=${droneId}`
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
    });
}

function buyNow(droneId) {
    window.location.href = `checkout.php?drone_id=${droneId}`;
}
</script>

    <!-- JS here -->

    <script src="./assets/js/vendor/modernizr-3.5.0.min.js"></script>
    <!-- Jquery, Popper, Bootstrap -->
    <script src="./assets/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="./assets/js/popper.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <!-- Jquery Mobile Menu -->
    <script src="./assets/js/jquery.slicknav.min.js"></script>

    <!-- Jquery Slick , Owl-Carousel Plugins -->
    <script src="./assets/js/owl.carousel.min.js"></script>
    <script src="./assets/js/slick.min.js"></script>
    <!-- One Page, Animated-HeadLin -->
    <script src="./assets/js/wow.min.js"></script>
    <script src="./assets/js/animated.headline.js"></script>
    <script src="./assets/js/jquery.magnific-popup.js"></script>

    <!-- Date Picker -->
    <script src="./assets/js/gijgo.min.js"></script>
    <!-- Nice-select, sticky -->
    <script src="./assets/js/jquery.nice-select.min.js"></script>
    <script src="./assets/js/jquery.sticky.js"></script>
    <!-- Progress -->
    <script src="./assets/js/jquery.barfiller.js"></script>

    <!-- counter , waypoint,Hover Direction -->
    <script src="./assets/js/jquery.counterup.min.js"></script>
    <script src="./assets/js/waypoints.min.js"></script>
    <script src="./assets/js/jquery.countdown.min.js"></script>
    <script src="./assets/js/hover-direction-snake.min.js"></script>

    <!-- contact js -->
    <script src="./assets/js/contact.js"></script>
    <script src="./assets/js/jquery.form.js"></script>
    <script src="./assets/js/jquery.validate.min.js"></script>
    <script src="./assets/js/mail-script.js"></script>
    <script src="./assets/js/jquery.ajaxchimp.min.js"></script>

    <!-- Jquery Plugins, main Jquery -->
    <script src="./assets/js/plugins.js"></script>
    <script src="./assets/js/main.js"></script>



</body>

</html>