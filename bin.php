<?php
session_start();

class AdvancedBillingDetails {
    private $firstName, $lastName, $email, $country, $city, $address, $phone, $paymentMethod, $orderId;

    public function __construct($firstName, $lastName, $email, $country, $city, $address, $phone, $paymentMethod, $orderId) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->country = $country;
        $this->city = $city;
        $this->address = $address;
        $this->phone = $phone;
        $this->paymentMethod = $paymentMethod;
        $this->orderId = $orderId;
    }

    public function getAdvancedBillingInfo() {
        return [
            "Order ID" => $this->orderId,
            "Name" => $this->firstName . " " . $this->lastName,
            "Email" => $this->email,
            "Country" => $this->country,
            "City" => $this->city,
            "Address" => $this->address,
            "Phone" => $this->phone,
            "Payment Method" => $this->paymentMethod
        ];
    }
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = trim($_POST["billing_first_name"] ?? '');
    $lastName = trim($_POST["billing_last_name"] ?? '');
    $email = trim($_POST["billing_email"] ?? '');
    $country = $_POST["billing_country"] ?? '';
    $city = $_POST["billing_city"] ?? '';
    $address = $_POST["billing_address_1"] ?? '';
    $phoneNumber = $_POST["billing_number"] ?? '';
    $paymentMethod = $_POST["payment_method"] ?? '';

    if (!preg_match("/^[a-zA-ZëËçÇ ]{2,}$/u", $firstName)) $errors[] = "Emri nuk është i vlefshëm.";
    if (!preg_match("/^[a-zA-ZëËçÇ ]{2,}$/u", $lastName)) $errors[] = "Mbiemri nuk është i vlefshëm.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email-i nuk është i vlefshëm.";
    if (!in_array($country, ['AL', 'XK', 'MK'])) $errors[] = "Shteti nuk është i vlefshëm.";
    if (strlen($address) < 5) $errors[] = "Adresa është shumë e shkurtër.";
    if (!preg_match("/^[a-zA-ZëËçÇ ]{2,}$/u", $city)) $errors[] = "Qyteti nuk është i vlefshëm.";
    if (!preg_match("/^\+?[0-9\s\-]{8,15}$/", $phoneNumber)) $errors[] = "Numri i telefonit nuk është i vlefshëm.";
    if (empty($paymentMethod)) $errors[] = "Zgjidh një mënyrë pagese.";

    if ($paymentMethod === "debit_card") {
        $cardNumber = trim($_POST["card_number"] ?? '');
        $expiryDate = trim($_POST["expiry_date"] ?? '');
        $cvv = trim($_POST["cvv"] ?? '');

        if (!preg_match("/^\d{13,19}$/", $cardNumber)) $errors[] = "Numri i kartës nuk është i vlefshëm.";
        if (!preg_match("/^(0[1-9]|1[0-2])\/\d{2}$/", $expiryDate)) $errors[] = "Data e skadencës nuk është e vlefshme (format: MM/YY).";
        if (!preg_match("/^\d{3,4}$/", $cvv)) $errors[] = "CVV nuk është i vlefshëm.";
    }

    if (empty($errors)) {
        $orderId = uniqid('order_');
        $billingDetails = new AdvancedBillingDetails(
            $firstName, $lastName, $email, $country, $city, $address, $phoneNumber, $paymentMethod, $orderId
        );

        $_SESSION['billingInfo'] = $billingDetails->getAdvancedBillingInfo();

        header("Location: success.php");
        exit;
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
       .header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    background-color:rgb(46, 45, 45);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    z-index: 1000;
    padding: 0; /* heq padding nga lartësia */
}

.header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.main-nav ul {
    list-style: none;
    display: flex;
    gap: 20px;
    margin: 0;
    padding: 0;
}
#note-status {
    opacity: 0;
    transition: opacity 1s ease;
    color: green;
    margin-top: 10px;
}

.main-nav a {
    text-decoration: none;
    color: #2c3e50;
    font-weight: 500;
}

.main-nav a:hover {
    color: #28a745;
}
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f2f4f7;
    margin: 0;
    padding-top: 100px; /* për të kompensuar header-in e fiksuar, rregullo në bazë të lartësisë reale të header-it */
}

        h2 {
            text-align: center;
            color: #2d3436;
            margin-bottom: 2rem;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .form-field {
            margin-bottom: 1.2rem;
        }

        label {
            display: block;
            font-weight: 600;
            font-size: 15px;
            margin-bottom: 6px;
            color: #34495e;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
            background-color: #fdfdfd;
            transition: border-color 0.3s;
        }

        input:focus, select:focus {
            border-color: #4CAF50;
            outline: none;
            background-color: #ffffff;
        }

        #debit_card_fields {
            display: none;
            margin-top: 1rem;
            padding: 1rem;
            background: #f8f9fa;
            border: 1px dashed #ccc;
            border-radius: 10px;
        }

        button {
            background: linear-gradient(45deg, #28a745, #218838);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            width: 100%;
            margin-top: 1.5rem;
        }

        button:hover {
            background: linear-gradient(45deg, #218838, #1e7e34);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        @media screen and (max-width: 600px) {
            form {
                padding: 1.5rem;
            }
            h2 {
                font-size: 24px;
            }
        }
    </style>
    <script>
        function toggleCardInput() {
            const method = document.getElementById("payment_method").value;
            const cardFields = document.getElementById("debit_card_fields");
            cardFields.style.display = (method === "debit_card") ? "block" : "none";
        }
    </script>
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
                            <li><a href="./index.php">Home</a></li>
                            <li><a href="./Products.php">Products</a></li>
                            <li><a href="./About.php">About</a></li>
                            <li><a href="./Contact.html">Contact</a></li>
                        </ul>
                       
                        
                    </nav>
                </div>
            </header>
    

<h2>Checkout</h2>
<?php if (!empty($errors)): ?>
    <div style="
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        border-radius: 8px;
        padding: 15px 20px;
        margin: 20px 0;
        font-family: Arial, sans-serif;
    ">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
   

<form method="post">
    <h3>Shënim për porosinë (opsionale):</h3>
    <textarea id="note" placeholder="Shkruani një shënim..." style="width:100%; height:100px;"></textarea>
    <button type="button" onclick="saveNote()">Ruaj Shënimin</button>
    <div id="note-status" style="margin-top: 10px; color: green;"></div>

    <script>
        function saveNote() {
            const note = document.getElementById("note").value;
            fetch("save_note.php", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({ note })
            })
            .then(res => res.json())
            .then(data => {
    const messageBox = document.getElementById("note-status");
    messageBox.textContent = "U ruajt: " + data.note;
    messageBox.style.opacity = "1";

    setTimeout(() => {
        messageBox.style.transition = "opacity 1s ease";
        messageBox.style.opacity = "0";
    }, 3000);
});

        }
    </script>
    <div class="form-field">
        <label for="billing_first_name">Name *</label>
        <input type="text" name="billing_first_name" required>
    </div>
    <div class="form-field">
        <label for="billing_last_name">Last Name *</label>
        <input type="text" name="billing_last_name" required>
    </div>
    <div class="form-field">
        <label for="billing_email">Email *</label>
        <input type="email" name="billing_email" required>
    </div>
    <div class="form-field">
        <label for="billing_country">Country *</label>
        <select name="billing_country" required>
            <option value="">Select a country</option>
            <option value="AL">Albania</option>
            <option value="XK">Kosovo</option>
            <option value="MK">North Macedonia</option>
        </select>
    </div>
    <div class="form-field">
        <label for="billing_city">City *</label>
        <input type="text" name="billing_city" required>
    </div>
    <div class="form-field">
        <label for="billing_address_1">Address *</label>
        <input type="text" name="billing_address_1" required>
    </div>
    <div class="form-field">
        <label for="billing_number">Phone Number *</label>
        <input type="tel" name="billing_number" required>
    </div>
    <div class="form-field">
        <label for="payment_method">Payment Method *</label>
        <select name="payment_method" id="payment_method" onchange="toggleCardInput()" required>
            <option value="">Select a payment method</option>
            <option value="cash">Cash</option>
            <option value="debit_card">Debit Card</option>
        </select>
    </div>
    <div id="debit_card_fields">
        <div class="form-field">
            <label for="card_number">Card Number *</label>
            <input type="text" name="card_number">
        </div>
        <div class="form-field">
            <label for="expiry_date">Expiry Date (MM/YY) *</label>
            <input type="text" name="expiry_date">
        </div>
        <div class="form-field">
            <label for="cvv">CVV *</label>
            <input type="text" name="cvv">
        </div>
    </div>
    <button type="submit">Place Order</button>
</form>


  <footer class="footer">
            <div class="container">
                <p>© 2024 Laced Lifestyle. All Rights Reserved.</p>
            </div>
        </footer>


</body>
</html>
