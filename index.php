<?php
require_once 'includes/session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laced Lifestyle | Online Shoe Store</title>
    <link rel="stylesheet" href="style.css?v=1.0">
    <script defer src="script.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="website icon" type="png" href="images/logo1.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php include 'includes/session_init.php'; ?>
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="logo">
                <img src="images/logo.png" alt="Laced Lifestyle Logo">
                <h1>Laced Lifestyle</h1>
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="#home" title="Go to Homepage">Home</a></li>
                    <li><a href="./Products.php" title="View Products">Products</a></li>
                    <li><a href="./About.php" title="Learn About Us">About</a></li>
                    <li><a href="./contact.php" title="Contact Us">Contact</a></li>
                </ul>
            </nav>
            <div class="header-utils">
                <button id="login-button" class="nav-button">Login</button>
                <div id="user-account" class="user-account hidden">
                    <button id="profile-button" class="nav-button" type="button"> 
                        <i class="fa fa-user"></i> My Account 
                    </button>
                    <div id="account-dropdown" class="dropdown hidden">
                        <a href="profile.php" id="profile-link" class="dropdown-item">Profile</a>
                        <a href="cart.html" class="dropdown-item">My Orders</a>
                        <button id="logout-button" class="dropdown-item">Logout</button>
                    </div>
                </div>
                <button id="search-button"><i class="fa fa-search"></i></button>
                <div id="search-container" class="hidden">
                    <input type="text" id="search-input" placeholder="Search for a product..." />
                </div>
            </div>
        </div>
    </header>
    <div id="login-modal" class="modal">
        <div class="modal-content">
            <span id="close-modal" class="close">&times;</span>
            
            <div id="login-form" class="form">
                <h2>Login</h2>
                <form id="login-form-element">
                    <div class="form-group">
                        <label for="login-username">Username or Email:</label>
                        <input 
                            type="text" 
                            id="login-username" 
                            name="username" 
                            placeholder="Enter your username or email" 
                            required 
                        >
                    </div>
                    <div class="form-group">
                        <label for="login-password">Password:</label>
                        <div class="password-container">
                            <input 
                                type="password" 
                                id="login-password" 
                                name="password" 
                                placeholder="Enter your password" 
                                required 
                            >
                            <button type="button" class="toggle-password">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="submit-button">Login</button>
                    <p class="toggle-form">Don't have an account? <a href="#" id="sign-up-link">Sign Up</a></p>
                </form>
            </div>

            <div id="sign-up-form" class="form hidden">
                <h2>Sign Up</h2>
                <form id="sign-up-form-element">
                    <div class="form-group">
                        <label for="signup-firstname">First Name:</label>
                        <input 
                            type="text" 
                            id="signup-firstname" 
                            name="first_name" 
                            placeholder="Enter your first name" 
                            required 
                        >
                    </div>
                    <div class="form-group">
                        <label for="signup-lastname">Last Name:</label>
                        <input 
                            type="text" 
                            id="signup-lastname" 
                            name="last_name" 
                            placeholder="Enter your last name" 
                            required 
                        >
                    </div>
                    <div class="form-group">
                        <label for="signup-username">Username:</label>
                        <input 
                            type="text" 
                            id="signup-username" 
                            name="username" 
                            placeholder="Choose a username" 
                            required 
                        >
                    </div>
                    <div class="form-group">
                        <label for="signup-email">Email:</label>
                        <input 
                            type="email" 
                            id="signup-email" 
                            name="email" 
                            placeholder="Enter your email" 
                            required 
                        >
                    </div>
                    <div class="form-group">
                        <label for="signup-password">Password:</label>
                        <div class="password-container">
                            <input 
                                type="password" 
                                id="signup-password" 
                                name="password" 
                                placeholder="Create a password" 
                                required 
                            >
                            <button type="button" class="toggle-password">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="signup-confirm-password">Confirm Password:</label>
                        <div class="password-container">
                            <input 
                                type="password" 
                                id="signup-confirm-password" 
                                name="confirm-password" 
                                placeholder="Confirm your password" 
                                required 
                            >
                            <button type="button" class="toggle-password">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="signup-birthdate">Birthdate:</label>
                        <input 
                            type="date" 
                            id="signup-birthdate" 
                            name="birthdate" 
                            required 
                        >
                    </div>
                    <div class="form-group">
                        <label>Gender:</label>
                        <div class="gender-options">
                            <label>
                                <input type="radio" name="gender" value="male" required>
                                Male
                            </label>
                            <label>
                                <input type="radio" name="gender" value="female" required>
                                Female
                            </label>
                            <label>
                                <input type="radio" name="gender" value="other" required>
                                Other
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="submit-button">Sign Up</button>
                    <p class="toggle-form">Already have an account? <a href="#" id="login-link">Login</a></p>
                </form>
            </div>
        </div>
    </div>
    

    <section id="home" class="hero">
        <video autoplay loop muted playsinline class="background-video">
            <source src="images/videoplayback.mp4" type="video/mp4">
        </video>
        <div class="container">
            <h2>Find Your Perfect Pair</h2>
            <p>Step into comfort and style with our exclusive shoe collection.</p>
            <a href="./Products.php" class="cta-button">Shop Now</a>
        </div>
    </section>

    <section id="products" class="products">
        <div class="container">
            <h2>Featured Products</h2>
            <div class="product-grid">
                <div class="product-card">
                    <img src="images/runningshoes.jpg" alt="Running Shoes" loading="lazy">
                    <h3>Running Shoes</h3>
                    <a href="./Products.php" class="cta-button">Shop Now</a>
                </div>

                <div class="product-card">
                    <img src="images/casualshoes.webp" alt="Casual Sneakers" loading="lazy">
                    <h3>Casual Sneakers</h3>
                    <a href="./Products.php" class="cta-button">Shop Now</a>
                </div>

                <div class="product-card">
                    <img src="images/formalshoes.jpeg" alt="Formal Shoes" loading="lazy">
                    <h3>Formal Shoes</h3>
                    <a href="./Products.php" class="cta-button">Shop Now</a>                
                </div>                
            </div>
        </div>
    </section>

    <section id="about" class="about">
        <div class="about-container">
            <h2>About Us</h2>
            <p>Laced Lifestyle is your one-stop shop for high-quality footwear. We blend fashion and comfort to bring you the best shoes for any occasion. Join us in stepping up your style game.</p>
           
        </div>
    </section>

    <div class="container-wrapper">
        <section id="contact" class="contact">
            <h2>Our location</h2>
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2935.341554922525!2d21.151942299999998!3d42.632918599999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x13549ffe637b0dd7%3A0x4594c50f0099efc5!2sAlbi%20Mall!5e0!3m2!1sen!2s!4v1734215168091!5m2!1sen!2s"
                width="500" height="268" padding-right="100px" style="border:0; border-radius: 10px;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </section>

        <div class="sherbimet">
            <div class="sherbimet-content">
                <h2>Our services</h2>
                <div class="row">
                    <div class="sherbimi">
                        <img src="images/truck-icon.png" alt="Truck Icon">
                        <p class="p-sherbimi">Efficient transportation for our store includes secure packing, diverse shipping options, and real-time tracking to ensure timely deliveries. For every order, free shipping throughout Kosovo, while for orders in Albania, shipping is €5.</p>
                    </div>
                    <div class="sherbimi">
                        <img src="images/card-payment.png" alt="Card Icon">
                        <p class="p-sherbimi">Secure payments with VISA, MASTERCARD, and StarCard cards, offering flexible options for online shopping. Enjoy an easy and fast experience, with the option to pay in up to 6 installments, which helps you manage your budget better.</p>
                    </div>
                    <div class="sherbimi">
                        <img src="images/customer-service.png" alt="Customer Service Icon">
                        <p class="p-sherbimi">Customer support is vital for our store, offering 24/7 assistance via live chat, email, and phone to enhance the shopping experience. Efficient communication and support help reduce cart abandonment and boost customer satisfaction.</p>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <div class="contact-info">
        <h3>Other Ways to Reach Us</h3>
        <p><i class="fa fa-phone"></i> Phone: +383 41 234 567</p>
        <p><i class="fa fa-envelope"></i> Email: support@lacedlifestyle.com</p>
        <div class="social-icons">
            <a href="https://www.instagram.com" target="_blank">
                <img src="images/Instagram_icon.png.webp" alt="Instagram" class="icon">
            </a>
            <a href="https://www.facebook.com" target="_blank">
                <img src="images/Facebook_icon.svg.png" alt="Facebook" class="icon">
            </a>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <p>© 2025 Laced Lifestyle. All Rights Reserved.</p>
        </div>
    </footer>

    <button id="scrollToTop" style="display:none; position:fixed; bottom:20px; right:20px; width:50px; 
    height:50px; background-color:rgba(188, 188, 188, 0.7); color:#000000; border: none; border-radius:50%; 
    cursor:pointer; font-size:30px; text-align:center; line-height:5px; font-weight:bold;">&#8593;</button>

</body>
</html>
