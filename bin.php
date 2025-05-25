<?php
require_once 'validation.php'; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $fields = [
            'First Name'      => trim($_POST['billing_first_name'] ?? ''),
            'Last Name'       => trim($_POST['billing_last_name'] ?? ''),
            'Email'           => trim($_POST['billing_email'] ?? ''),
            'Country'         => trim($_POST['billing_country'] ?? ''),
            'City'            => trim($_POST['billing_city'] ?? ''),
            'Address'         => trim($_POST['billing_address_1'] ?? ''),
            'Phone Number'    => trim($_POST['billing_number'] ?? ''),
        ];

        $missing = array_filter($fields, fn($val) => empty($val));
        if (!empty($missing)) {
            throw new Exception("Ju lutem plotësoni të gjitha fushat e detyrueshme.");
        }

    
        Validation::validateEmail($fields['Email']);
        Validation::validatePhone($fields['Phone Number']);

    
        echo "<div style='color: green; font-weight: bold;'>Checkout i suksesshëm</div>";

        // Printimi i te dhenave 
        foreach ($fields as $key => $value) {
            echo "<p><strong>$key:</strong> " . htmlspecialchars($value) . "</p>";
        }

        // Gjenerimi i nje ID 
        $orderId = 'order_' . uniqid();
        echo "<p><strong>Order ID:</strong> $orderId</p>";

    } catch (Exception $e) {
        echo "<div style='color: red; font-weight: bold;'>Gabim: " . $e->getMessage() . "</div>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="custom-styles.css">
        <link rel="website icon" type="png" href="images/logo1.png">
        <title>Checkout</title>
        <style>
          
    input[type="text"], input[type="tel"], input[type="email"], select {
     width: 100%;
     padding: 10px;
     font-size: 14px;
     border-radius: 8px;
     border: 1px solid #ddd;
     margin-bottom: 15px;
     transition: border 0.3s ease;
    }

    input[type="text"]:focus, input[type="tel"]:focus, input[type="email"]:focus, select:focus {
     border-color: #28a745; 
     outline: none;
    }

    
    label {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 5px;
        color: #333;
        display: block;
    }
    
    
    
    select#billing_country {
        background-color: #f9f9f9;
        color: #333;
        border: 1px solid #ddd;
    }
    
    
    button {
        font-size: 14px;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-block;
        text-align: center;
    }
    
    
    #checkout-btn {
        background-color: #28a745; 
        color: #fff;
        width: auto;
    }
    
    #checkout-btn:hover {
        background-color: #218838; 
        transform: translateY(-3px); 
    }
    
    
    .remove-from-cart {
        background-color: #dc3545; 
        color: #fff;
        padding: 6px 12px; 
        margin-top: 10px;
        width: auto;
    }
    
    .remove-from-cart:hover {
        background-color: #c82333; 
        transform: translateY(-3px); 
    }
    
    
    .cart-item img {
        width: 100px; 
        height: 100px;
        object-fit: cover;
        border-radius: 5px;
    }
    
    
    @media screen and (max-width: 768px) {
        #checkout-btn {
            font-size: 13px;
            padding: 6px 12px;
        }
    
        .remove-from-cart {
            background-color: #dc3545; 
            color: #fff;
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
        }
    
        .remove-from-cart:hover {
            background-color: #c82333; 
        }
    
        .cart-item img {
            width: 90px; 
            height: 90px;
        }
    
            #confirmation-message {
        display: none;
        position: fixed; 
        top: 50%; 
        left: 50%; 
        transform: translate(-50%, -50%);
        padding: 20px;
        background-color: white;
        border: 2px solid #4CAF50;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        z-index: 9999;
        width: 300px;
        border-radius: 10px;
        text-align: center;
        font-family: Arial, sans-serif;
    }
    
    #confirmation-message p {
        margin: 10px 0;
    }
    
    
    }
    
    .confirmation-popup {
        display: none; 
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5); 
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    
    
    button#close-btn {
        background-color: #49bfc4;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 5px;
    }
    
    button#close-btn:hover {
        background-color: #45a08b;
    }
    
    .popup-content {
        background: #fff;
        padding: 30px;
        border-radius: 15px;
        text-align: center;
        width: 90%;
        max-width: 400px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        animation: slide-up 0.5s ease-out;
    }
    
    
    h2 {
        font-size: 28px;
        color: #28a745;
        margin-bottom: 20px;
        font-weight: bold;
    }
    
    
    .confirmation-message-text {
        font-size: 18px;
        color: #555;
        margin: 12px 0;
        line-height: 1.5;
    }
    
    
    .order-details {
        margin: 20px 0;
        font-size: 14px;
        color: #555;
    }
    
    .order-details strong {
        color: #333;
    }
   
    @keyframes slide-up {
        from {
            transform: translateY(30px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    .form-warning-message {
        display: none; 
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #f44336;
        color: white;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 9999;
        font-size: 16px;
        text-align: center;
        width: 80%;
        max-width: 400px;
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }
    
    .form-warning-message.show {
        display: block;
        opacity: 1;
    }
        </style>
    
    </head>
    <body>
       
        
            <header class="header">
                <div class="container1">
                    <div class="logo">
                        <img src="images/logo.png" alt="Laced Lifestyle Logo">
                        <h1>Laced Lifestyle</h1>
                    </div>
                    <nav>
                        <ul class="nav-links">
                            <li><a href="./index.html">Home</a></li>
                            <li><a href="./Products.php">Products</a></li>
                            <li><a href="./About.html">About</a></li>
                            <li><a href="./Contact.html">Contact</a></li>
                        </ul>
                       
                        
                    </nav>
                </div>
            </header>
        
            <div class="main-content">
                <div class="container">
               
                  
                    <div class="billing-details">
                    <form name="checkout" method="post" class="checkout-form" action="bin.php" enctype="multipart/form-data">
    <h3>Billing Details</h3>

    <div class="billing-fields">
        <p class="form-field">
            <label for="billing_first_name">Name <abbr class="required">*</abbr></label>
            <input type="text" name="billing_first_name" id="billing_first_name" placeholder="Name" aria-required="true" required>
        </p>
        <p class="form-field">
            <label for="billing_last_name">Last Name <abbr class="required">*</abbr></label>
            <input type="text" name="billing_last_name" id="billing_last_name" placeholder="Last Name" aria-required="true" required>
        </p>

        <p class="form-field">
            <label for="billing_email">Email <abbr class="required">*</abbr></label>
            <input type="email" name="billing_email" id="billing_email" placeholder="Email" aria-required="true" required>
        </p>
        
        <p class="form-field">
            <label for="billing_country">Country <abbr class="required">*</abbr></label>
            <select name="billing_country" id="billing_country" aria-required="true" required>
                <option value="">Select a country</option>
                <option value="AL">Albania</option>
                <option value="XK">Kosovo</option>
                <option value="MK">North Macedonia</option>
            </select>
        </p>
        <p class="form-field">
            <label for="billing_city">City <abbr class="required">*</abbr></label>
            <input type="text" name="billing_city" id="billing_city" placeholder="City" aria-required="true" required>
        </p>
        <p class="form-field">
            <label for="billing_address_1">Address <abbr class="required">*</abbr></label>
            <input type="text" name="billing_address_1" id="billing_address_1" placeholder="Address" aria-required="true" required>
        </p>
        <p class="form-field">
            <label for="billing_number">Phone Number <abbr class="required">*</abbr></label>
            <input type="tel" name="billing_number" id="billing_number" placeholder="Phone Number" aria-required="true" required>
        </p>

    </div>

    
    <button type="submit" id="submit-btn" class="submit-btn">Checkout</button>
</form>

                    </div>
    
                           
                           <div id="cart-items-container">
                            <h1>Your Cart</h1>
                            <ul id="cart-items"></ul>
                            <p id="total-price"></p>
                            <p id="empty-cart-message" style="display: none;">Your cart is empty!</p>
                            
                        </div>
                    
                        <div id="confirmation-message" class="confirmation-popup">
                            <div class="popup-content">
                                <h2>Order Confirmed 🎉</h2>
                                <p class="confirmation-message-text">Your order has been successfully placed!</p>
                                <p class="confirmation-message-text">We're preparing it and it'll arrive within 2-5 business days. 🚚</p>
                                
                                <div class="order-details">
                                    <p><strong>Email:</strong> <span id="user-email"></span></p>
                                    <p><strong>Shipping Address:</strong> <span id="user-address"></span></p>
                                </div>
                                
                                <button id="close-btn" class="btn-close">Close and go to homepage</button>
                            </div>
                        </div>
    
                        <div id="form-warning-message" class="form-warning-message">
                            <p>Please fill in all the required fields before proceeding.</p>
                        </div>
                </div>
            </div>
            
            

            <audio id="success-audio" src="audio.wav" type="audio/wav"></audio>
    
            <script>
  
     
  document.addEventListener('DOMContentLoaded', () => {
            const cartItemsContainer = document.getElementById('cart-items');
            const totalPriceElement = document.getElementById('total-price');
            const emptyCartMessage = document.getElementById('empty-cart-message');
            const checkoutBtn = document.getElementById('checkout-btn');
            const confirmationMessage = document.getElementById('confirmation-message');
            const userEmailElement = document.getElementById('user-email');
            const userAddressElement = document.getElementById('user-address');
            const closeBtn = document.getElementById('close-btn');
            const formWarningMessage = document.getElementById('form-warning-message');
            const debitCardFields = document.getElementById('debit_card_fields'); 

           
            function validatePhoneNumber(phone) {
                const albaniaPhoneRegex = /^\+355\d{8}$/;
                const kosovoPhoneRegex = /^\+383\d{8}$/;
                const macedoniaPhoneRegex = /^\+389\d{7}$/;
                return albaniaPhoneRegex.test(phone) || kosovoPhoneRegex.test(phone) || macedoniaPhoneRegex.test(phone);
            }

            function validateEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

           
            function validateExpiryDate(expiryDate) {
                const [month, year] = expiryDate.split('/').map(num => parseInt(num, 10));
                if (isNaN(month) || isNaN(year) || month < 1 || month > 12) {
                    return false;
                }

                const currentDate = new Date();
                const currentYear = currentDate.getFullYear() % 100;
                const currentMonth = currentDate.getMonth() + 1;

                return year > currentYear || (year === currentYear && month >= currentMonth);
            }

        
            
            

            checkoutBtn.addEventListener('click', (event) => {
                event.preventDefault();  

                formWarningMessage.classList.remove('show');  

                const isValid = validateForm(); 
                if (!isValid) {
                
                    formWarningMessage.classList.add('show');
                    setTimeout(() => {
                        formWarningMessage.classList.remove('show');
                    }, 2000);
                } else {
                   
                    const email = document.getElementById('billing_email').value;
                    const address = document.getElementById('billing_address_1').value;

                    confirmationMessage.style.display = 'flex';  
                    userEmailElement.textContent = email;
                    userAddressElement.textContent = address;

                    cartItemsContainer.style.display = 'none';  
                    localStorage.removeItem('cartItems');  

                    
                    const successAudio = document.getElementById('success-audio');
                    successAudio.play();
                }
            });

        
            closeBtn.addEventListener('click', () => {
                confirmationMessage.style.display = 'none';
                setTimeout(() => {
                    window.location.href = '/index.html';
                }, 1000);
            });
        });
    </script>
    

    <?php include 'footer.php'; ?>
    
    </body>
    </html>