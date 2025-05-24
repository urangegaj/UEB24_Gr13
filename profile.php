<?php
session_start();

// if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
//     header('Location: index.html');
//     exit;
// }

$userData = array();
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['name']) || empty($_POST['lastname']) || empty($_POST['username']) || empty($_POST['email']) || empty($_POST['birthdate']) || empty($_POST['gender'])) {
        $errorMessage = "Please fill in all the fields.";
    } else {
        $userData = array(
            "name" => $_POST['name'],
            "lastname" => $_POST['lastname'],
            "username" => $_POST['username'],
            "email" => $_POST['email'],
            "birthdate" => $_POST['birthdate'],
            "gender" => $_POST['gender']
        );
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="User profile page">
    <link rel="stylesheet" href="style.css">
    <link rel="website icon" type="png" href="images/logo1.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Profile</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --text-color: #2c3e50;
            --light-gray: #f5f6fa;
            --border-color: #dcdde1;
            --success-color: #27ae60;
            --error-color: #e74c3c;
        }

        /* Profile specific styles */
        .profile-container {
            display: flex;
            align-items: flex-start;
            gap: 3rem;
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .profile-pic {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--secondary-color);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .drag-drop-area {
            border: 2px dashed var(--border-color);
            padding: 2rem;
            text-align: center;
            margin-bottom: 2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border-radius: 8px;
            background-color: white;
        }

        .drag-drop-area:hover {
            border-color: var(--secondary-color);
            background-color: rgba(52, 152, 219, 0.05);
        }

        .drag-drop-area.dragover {
            border-color: var(--secondary-color);
            background-color: rgba(52, 152, 219, 0.1);
        }

        .user-info {
            flex: 1;
        }

        .user-info div {
            margin-bottom: 1.5rem;
            padding: 1rem;
            background-color: var(--light-gray);
            border-radius: 8px;
        }

        #profile-form {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        #profile-form div {
            margin-bottom: 1.5rem;
        }

        #profile-form label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        #profile-form input[type="text"],
        #profile-form input[type="email"],
        #profile-form input[type="password"],
        #profile-form input[type="date"] {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid var(--border-color);
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        #profile-form input:focus {
            outline: none;
            border-color: var(--secondary-color);
        }

        .gender {
            display: flex;
            gap: 2rem;
            margin-top: 0.5rem;
        }

        .gender div {
            display: flex;
            align-items: center;
            margin-bottom: 0;
            background: none;
            padding: 0;
        }

        .gender input[type="radio"] {
            display: none;
        }

        .gender label {
            position: relative;
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            cursor: pointer;
            user-select: none;
            font-weight: normal;
            border: 2px solid var(--border-color);
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .gender label:hover {
            border-color: var(--secondary-color);
            background-color: rgba(52, 152, 219, 0.05);
        }

        .gender label::before {
            content: "";
            position: absolute;
            left: 0.8rem;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            border: 2px solid var(--border-color);
            border-radius: 50%;
            background-color: white;
            transition: all 0.3s ease;
        }

        .gender input[type="radio"]:checked + label {
            border-color: var(--secondary-color);
            background-color: rgba(52, 152, 219, 0.1);
        }

        .gender input[type="radio"]:checked + label::before {
            border-color: var(--secondary-color);
            background-color: var(--secondary-color);
        }

        .gender input[type="radio"]:checked + label::after {
            content: "";
            position: absolute;
            left: 1.1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: white;
        }

        button[type="submit"] {
            background-color: var(--secondary-color);
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        button[type="submit"]:hover {
            background-color: #2980b9;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .profile-container {
                flex-direction: column;
                align-items: center;
                gap: 2rem;
                padding: 1rem;
            }

            .profile-pic {
                width: 150px;
                height: 150px;
            }

            .gender {
                flex-direction: column;
                gap: 1rem;
            }

            h1 {
                font-size: 2rem;
            }

            h2 {
                font-size: 1.5rem;
            }
        }

        .error-message {
            color: var(--error-color);
            background-color: rgba(231, 76, 60, 0.1);
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
        }

        .success-message {
            color: var(--success-color);
            background-color: rgba(39, 174, 96, 0.1);
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
        }
    </style>
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
                    <li><a href="./index.html" title="Go to Homepage">Home</a></li>
                    <li><a href="./Products.php" title="View Products">Products</a></li>
                    <li><a href="./About.html" title="Learn About Us">About</a></li>
                    <li><a href="./Contact.html" title="Contact Us">Contact</a></li>
                </ul>
            </nav>
            <div class="header-utils">
                <div id="user-account" class="user-account hidden">
                    <button id="profile-button" class="nav-button"> 
                        <i class="fa fa-user"></i> My Account 
                    </button>
                    <div id="account-dropdown" class="dropdown hidden">
                        <a href="cart.html">My orders</a>
                        <button id="logout-button">Logout</button>
                    </div>
                </div>
                <button id="login-button" class="nav-button">Login</button>
            </div>
        </div>
    </header>

    <div class="container">
        <h1>Your Profile</h1>
        <div class="drag-drop-area" id="drag-drop-area">
            <p>Drag & Drop your profile picture here</p>
            <input type="file" id="file-input" style="display: none;">
        </div>
        <div class="user-info" id="user-info">
            <h2>Profile Information</h2>
            <div id="display-name"></div>
            <div id="display-lastname"></div>
            <div id="display-username"></div>
            <div id="display-email"></div>
            <div id="display-birthdate"></div>
            <div id="display-gender"></div>
        </div>

        <?php if ($errorMessage): ?>
            <p style="color: red;"><?php echo $errorMessage; ?></p>
        <?php endif; ?>

        <img src="default-profile.png" alt="Profile Picture" class="profile-pic" id="profile-pic">
        <form id="profile-form" method="POST" action="">
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div>
                <label for="lastname">Lastname:</label>
                <input type="text" id="lastname" name="lastname" required>
            </div>
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password must be at least 8 characters long, include at least one uppercase letter, one lowercase letter, and one number.">
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="birthdate">Birthdate:</label>
                <input type="date" id="birthdate" name="birthdate" required>
            </div>
            <div>
                <label for="gender">Gender:</label>
                <div class="gender">
                    <div>
                        <input type="radio" id="male" name="gender" value="male" required>
                        <label for="male">Male</label>
                    </div>
                    <div>
                        <input type="radio" id="female" name="gender" value="female" required>
                        <label for="female">Female</label>
                    </div>
                </div>
            </div>
            <button type="submit">Save</button>
        </form>
    </div>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && !$errorMessage): ?>
        <h2>Profile Information</h2>
        <p>Name: <?php echo $userData['name']; ?></p>
        <p>Lastname: <?php echo $userData['lastname']; ?></p>
        <p>Username: <?php echo $userData['username']; ?></p>
        <p>Email: <?php echo $userData['email']; ?></p>
        <p>Birthdate: <?php echo $userData['birthdate']; ?></p>
        <p>Gender: <?php echo $userData['gender']; ?></p>
    <?php endif; ?>
    

    <script>
        const dragDropArea = document.getElementById('drag-drop-area');
        const fileInput = document.getElementById('file-input');
        const profilePic = document.getElementById('profile-pic');
        const loginButton = document.getElementById('login-button');
        const userAccount = document.getElementById('user-account');
        const profileButton = document.getElementById('profile-button');
        const accountDropdown = document.getElementById('account-dropdown');
        const profileForm = document.getElementById('profile-form');
        const userInfo = document.getElementById('user-info');

        const isLoggedIn = true;

        if (isLoggedIn) {
            loginButton.classList.add('hidden');
            userAccount.classList.remove('hidden');
        } else {
            loginButton.classList.remove('hidden');
            userAccount.classList.add('hidden');
        }

        dragDropArea.addEventListener('click', () => fileInput.click());

        dragDropArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            dragDropArea.classList.add('dragover');
        });

        dragDropArea.addEventListener('dragleave', () => {
            dragDropArea.classList.remove('dragover');
        });

        dragDropArea.addEventListener('drop', (e) => {
            e.preventDefault();
            dragDropArea.classList.remove('dragover');
            const file = e.dataTransfer.files[0];
            handleFile(file);
        });

        fileInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            handleFile(file);
        });

        function handleFile(file) {
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    profilePic.src = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                alert('Please upload a valid image file.');
            }
        }

        profileButton.addEventListener('click', () => {
            console.log("My Account clicked!");
            accountDropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', (e) => {
            if (!profileButton.contains(e.target) && !accountDropdown.contains(e.target)) {
                accountDropdown.classList.add('hidden');
            }
        });
        profileForm.addEventListener('submit', (e) => {
            e.preventDefault();
            document.getElementById('display-name').innerText = `Name: ${document.getElementById('name').value}`;
            document.getElementById('display-lastname').innerText = `Lastname: ${document.getElementById('lastname').value}`;
            document.getElementById('display-username').innerText = `Username: ${document.getElementById('username').value}`;
            document.getElementById('display-email').innerText = `Email: ${document.getElementById('email').value}`;
            document.getElementById('display-birthdate').innerText = `Birthdate: ${document.getElementById('birthdate').value}`;
            const gender = document.querySelector('input[name="gender"]:checked').value;
            document.getElementById('display-gender').innerText = `Gender: ${gender}`;
        });
    </script>
</body>
</html>