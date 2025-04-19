




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
          
    input[type="text"], input[type="tel"], select {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border-radius: 8px;
        border: 1px solid #ddd;
        margin-bottom: 15px;
        transition: border 0.3s ease;
    }
    
    
    input[type="text"]:focus, input[type="tel"]:focus, select:focus {
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
    
    
    .payment-methods select {
        background-color: #f9f9f9;
        color: #333;
        border: 1px solid #ddd;
    }
    
    
    .payment-methods select:hover {
        border-color: #28a745;
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
    
    <?php
    class BillingDetails {
    private $firstName;
    private $lastName;
    private $email;
    private $country;
    private $city;
    private $address;
    private $phoneNumber;
    private $paymentMethod;

    
    public function __construct($firstName, $lastName, $email, $country, $city, $address, $phoneNumber, $paymentMethod) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->country = $country;
        $this->city = $city;
        $this->address = $address;
        $this->phoneNumber = $phoneNumber;
        $this->paymentMethod = $paymentMethod;
    }
    public function getFirstName() {
        return $this->firstName;
    }
    
    public function getLastName() {
        return $this->lastName;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getCountry() {
        return $this->country;
    }

    public function getCity() {
        return $this->city;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getPhoneNumber() {
        return $this->phoneNumber;
    }

    public function getPaymentMethod() {
        return $this->paymentMethod;
    }


    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setCountry($country) {
        $this->country = $country;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function setPhoneNumber($phoneNumber) {
        $this->phoneNumber = $phoneNumber;
    }

    public function setPaymentMethod($paymentMethod) {
        $this->paymentMethod = $paymentMethod;
    }
    
    public function getBillingInfo() {
        return [
            'First Name' => $this->firstName,
            'Last Name' => $this->lastName,
            'Email' => $this->email,
            'Country' => $this->country,
            'City' => $this->city,
            'Address' => $this->address,
            'Phone Number' => $this->phoneNumber,
            'Payment Method' => $this->paymentMethod
        ];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['billing_first_name'];
    $lastName = $_POST['billing_last_name'];
    $email = $_POST['billing_email'];
    $country = $_POST['billing_country'];
    $city = $_POST['billing_city'];
    $address = $_POST['billing_address_1'];
    $phoneNumber = $_POST['billing_number'];
    $paymentMethod = $_POST['payment_method'];

    // Krijo instancën e klasës BillingDetails
    $billingDetails = new BillingDetails($firstName, $lastName, $email, $country, $city, $address, $phoneNumber, $paymentMethod);
    
    // Përdor metodën getBillingInfo për të marrë informacionin e faturimit
    $billingInfo = $billingDetails->getBillingInfo();
    
    // Shfaq informacionin e faturimit
    echo "<h2>Billing Information:</h2>";
    echo "<ul>";
    foreach ($billingInfo as $key => $value) {
        echo "<li><strong>$key:</strong> $value</li>";
    }
    echo "</ul>";
}
?>
    
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
                            <li><a href="/Products.php">Products</a></li>
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
                                    <input type="text" name="billing_first_name" id="billing_first_name" placeholder="Name" aria-required="true">
                                </p>
                                <p class="form-field">
                                    <label for="billing_last_name">Last Name <abbr class="required">*</abbr></label>
                                    <input type="text" name="billing_last_name" id="billing_last_name" placeholder="Last Name" aria-required="true">
                                </p>
    
                                <p class="form-field">
                                    <label for="billing_email">Email <abbr class="required">*</abbr></label>
                                    <input type="email" name="billing_email" id="billing_email" placeholder="Email" aria-required="true" required>
                                </p>
                                
                                <p class="form-field">
                                    <label for="billing_country">Country <abbr class="required">*</abbr></label>
                                    <select name="billing_country" id="billing_country" aria-required="true">
                                        <option value="">Select a country</option>
                                        <option value="AL">Albania</option>
                                        <option value="XK">Kosovo</option>
                                        <option value="MK">North Macedonia</option>
                                    </select>
                                </p>
                                <p class="form-field">
                                    <label for="billing_city">City <abbr class="required">*</abbr></label>
                                    <input type="text" name="billing_city" id="billing_city" placeholder="City" aria-required="true">
                                </p>
                                <p class="form-field">
                                    <label for="billing_address_1">Address <abbr class="required">*</abbr></label>
                                    <input type="text" name="billing_address_1" id="billing_address_1" placeholder="Address" aria-required="true">
                                </p>
                                <p class="form-field">
                                    <label for="billing_number">Phone Number <abbr class="required">*</abbr></label>
                                    <input type="tel" name="billing_number" id="billing_number" placeholder="Phone Number" aria-required="true">
                                </p>
                                <div class="payment-methods">
                                    <p class="form-field">
                                        <label for="payment_method">Payment Method <abbr class="required">*</abbr></label>
                                        <select name="payment_method" id="payment_method" aria-required="true" onchange="toggleCardInput()">
                                            <option value="">Select a payment method</option>
                                            <option value="cash">Cash</option>
                                            <option value="debit_card">Debit Card</option>
                                        </select>
                                    </p>
                                
                                  
                                    <div id="debit_card_fields" style="display:none;">
                                        <p class="form-field">
                                            <label for="card_number">Debit Card Number <abbr class="required">*</abbr></label>
                                            <input type="text" name="card_number" id="card_number" placeholder="Debit Card Number" aria-required="true">
                                        </p>
                                
                                        <p class="form-field">
                                            <label for="expiry_date">Expiration Date <abbr class="required">*</abbr></label>
                                            <input type="text" name="expiry_date" id="expiry_date" placeholder="MM/YY" aria-required="true">
                                        </p>
                                
                                        <p class="form-field">
                                            <label for="cvv">CVV <abbr class="required">*</abbr></label>
                                            <input type="text" name="cvv" id="cvv" placeholder="CVV" aria-required="true">
                                        </p>
                                    </div>
                                </div>
    
    
                            
                            </div>
                        </form>
                    </div>
    
                           
                           <div id="cart-items-container">
                            <h1>Your Cart</h1>
                            <ul id="cart-items"></ul>
                            <p id="total-price"></p>
                            <p id="empty-cart-message" style="display: none;">Your cart is empty!</p>
                            <button id="checkout-btn">Checkout</button>
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

  
    function validateCardNumber(cardNumber) {
        const cardNumberRegex = /^\d{16}$/; 
        return cardNumberRegex.test(cardNumber);
    }

   
    function toggleCardInput() {
        debitCardFields.style.display = document.getElementById('payment_method').value === "debit_card" ? 'block' : 'none';
    }

   
    function validateForm() {
    try {
        const fields = {
            "First Name": document.getElementById('billing_first_name').value,
            "Last Name": document.getElementById('billing_last_name').value,
            "Email": document.getElementById('billing_email').value,
            "Country": document.getElementById('billing_country').value,
            "City": document.getElementById('billing_city').value,
            "Address": document.getElementById('billing_address_1').value,
            "Phone Number": document.getElementById('billing_number').value,
            "Payment Method": document.getElementById('payment_method').value,
        };

        const missingFields = Object.keys(fields).filter(field => !fields[field]);

        if (missingFields.length > 0) {
            throw new Error(`Please fill in the following fields: ${missingFields.join(', ')}`);
        }

        if (!validateEmail(fields["Email"])) {
            throw new Error("Invalid email address!");
        }

        const phone = fields["Phone Number"];
        if (!validatePhoneNumber(phone)) {
            throw new Error("Invalid phone number! Must be for Albania, Kosovo, or North Macedonia.");
        }

        if (fields["Payment Method"] === "debit_card") {
            const cardNumber = document.getElementById('card_number').value;
            const expiryDate = document.getElementById('expiry_date').value;
            const cvv = document.getElementById('cvv').value;

            if (!validateCardNumber(cardNumber)) {
                throw new Error("Invalid debit card number!");
            }

            if (!validateExpiryDate(expiryDate)) {
                throw new Error("Invalid expiration date!");
            }

            if (!cvv || cvv.length !== 3) {
                throw new Error("Invalid CVV!");
            }
        }

        return true;
    } catch (error) {
        formWarningMessage.textContent = error.message;
        formWarningMessage.classList.add('show');
        return false;
    }
}
    checkoutBtn.addEventListener('click', (event) => {
       
        formWarningMessage.classList.remove('show');
        
        const isValid = validateForm();

        if (!isValid) {
            event.preventDefault();
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
        }

        const successAudio = document.getElementById('success-audio');
        successAudio.play();
    });

    closeBtn.addEventListener('click', () => {
        confirmationMessage.style.display = 'none';
        setTimeout(() => {
            window.location.href = '/index.html';
        }, 1000);
    });

    function updateCart() {
    try {
        const cartItems = localStorage.getItem('cartItems') || '';
        const productsArray = cartItems.split(';').filter(Boolean);
        let totalPrice = 0;

        cartItemsContainer.innerHTML = '';

        if (productsArray.length === 0) {
            emptyCartMessage.style.display = 'block';
            totalPriceElement.style.display = 'none';
            checkoutBtn.style.display = 'none';
            return;
        }

        emptyCartMessage.style.display = 'none';

        productsArray.forEach((item) => {
            const [productId, productName, productPrice, productImage, quantity] = item.split(',');
            const pricePerItem = parseFloat(productPrice.replace('$', ''));
            const itemQuantity = parseInt(quantity || '1', 10); 
            const totalItemPrice = pricePerItem * itemQuantity;

            const cartItem = document.createElement('li');
            cartItem.className = 'cart-item';

            cartItem.innerHTML = `
                <img src="${productImage}" alt="${productName}">
                <div class="cart-item-details">
                    <h3>${productName}</h3>
                    <p class="price">$<span>${totalItemPrice.toFixed(2)}</span> (${itemQuantity} x $${pricePerItem.toFixed(2)})</p>
                </div>
                <button class="remove-from-cart" data-id="${productId}">Remove</button>
            `;

            cartItemsContainer.appendChild(cartItem);
            totalPrice += totalItemPrice;

        
            cartItem.querySelector('.remove-from-cart').addEventListener('click', function () {
                removeFromCart(productId);
            });
        });

        totalPriceElement.textContent = `Total Price: $${totalPrice.toFixed(2)}`;
        totalPriceElement.style.display = 'block';
        checkoutBtn.style.display = 'inline-block';
    } catch (error) {
        console.error("Error updating the cart:", error.message);
        emptyCartMessage.textContent = "An error occurred while updating the cart.";
        emptyCartMessage.style.display = 'block';
    }
}




    function removeFromCart(productId) {
        let cartItems = localStorage.getItem('cartItems') || '';
        const cartArray = cartItems.split(';').filter(Boolean);

        const updatedCartArray = cartArray.filter(item => !item.startsWith(productId));
        localStorage.setItem('cartItems', updatedCartArray.join(';'));
        updateCart();
    }

    updateCart();

document.getElementById('billing_first_name').addEventListener('input', validateForm);
document.getElementById('billing_last_name').addEventListener('input', validateForm);
document.getElementById('billing_email').addEventListener('input', validateForm);
document.getElementById('billing_country').addEventListener('change', validateForm);
document.getElementById('billing_city').addEventListener('input', validateForm);
document.getElementById('billing_address_1').addEventListener('input', validateForm);
document.getElementById('billing_number').addEventListener('input', validateForm);
document.getElementById('payment_method').addEventListener('change', toggleCardInput);
document.getElementById('card_number').addEventListener('input', validateForm);
document.getElementById('expiry_date').addEventListener('input', validateForm);
document.getElementById('cvv').addEventListener('input', validateForm);


});
    
    </script>
              
            
    
    


        <footer class="footer">
            <div class="container">
                <p>© 2024 Laced Lifestyle. All Rights Reserved.</p>
            </div>
        </footer>
    
    
    </body>
    </html>