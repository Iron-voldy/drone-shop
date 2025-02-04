<?php
session_start();
require 'connection.php';
Database::setUpConnection();

if (!isset($_GET['drone_id']) || empty($_GET['drone_id'])) {
    die("Product not found!");
}

$drone_id = intval($_GET['drone_id']);

// Fetch product details
$query = "SELECT * FROM drones WHERE drone_id = ?";
$stmt = Database::$connection->prepare($query);
$stmt->bind_param("i", $drone_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Product not found!");
}

$product = $result->fetch_assoc();
$stmt->close();

// Fetch reviews
$reviews_query = "SELECT r.*, u.username FROM reviews r JOIN users u ON r.user_id = u.user_id WHERE r.drone_id = ? ORDER BY r.created_at DESC";
$reviews_stmt = Database::$connection->prepare($reviews_query);
$reviews_stmt->bind_param("i", $drone_id);
$reviews_stmt->execute();
$reviews = $reviews_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - Product Details</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

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
        .product-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 50px;
        }
        .product-image img {
            width: 100%;
            max-width: 450px;
            border-radius: 10px;
        }
        .product-details {
            max-width: 500px;
        }
        .price {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .discount-price {
            text-decoration: line-through;
            color: red;
        }
        .product-actions button {
            margin-top: 15px;
            margin-right: 10px;
        }
        .tabs {
            margin-top: 40px;
        }
    </style>
</head>
<body>
   <div class="container">

   
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
    
 
        
            <div class="product-image">
                <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            </div>
            <div class="product-details">
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                <p class="price">$<?php echo number_format($product['price'], 2); ?> <span class="discount-price">$<?php echo number_format($product['price'] * 1.2, 2); ?></span></p>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <div class="quantity-selector">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1">
                </div>
                <div class="product-actions">
                    <button class="btn btn-primary" onclick="addToCart(<?php echo $product['drone_id']; ?>)"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
                    <button class="btn btn-warning" onclick="addToWishlist(<?php echo $product['drone_id']; ?>)"><i class="fas fa-heart"></i> Wishlist</button>
                    <button class="btn btn-success" onclick="buyNow(<?php echo $product['drone_id']; ?>)"><i class="fas fa-bolt"></i> Buy Now</button>
                </div>
            </div>
        </div>
        
        <div class="tabs">
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#description">Description</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#reviews">Reviews (<?php echo $reviews->num_rows; ?>)</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane container active" id="description">
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                </div>
                <div class="tab-pane container fade" id="reviews">
                    <?php while ($review = $reviews->fetch_assoc()) { ?>
                        <div class="review">
                            <h5><?php echo htmlspecialchars($review['username']); ?></h5>
                            <p>Rating: <?php echo $review['rating']; ?> / 5</p>
                            <p><?php echo htmlspecialchars($review['review_text']); ?></p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
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

    </div>
    
    <script>
        function addToCart(droneId) {
            fetch('add_to_cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `drone_id=${droneId}&quantity=${document.getElementById('quantity').value}`
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
