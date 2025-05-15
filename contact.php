<?php
require_once 'session_handler.php';

// Increment visit count
$visitCount = incrementVisitCount();

// Get user preferences
$preferences = getUserPreferences();
$themeStyles = getThemeStyles();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="website icon" type="png" href="images/logo1.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Contact Us</title>

    <style>
        body {
            font-family: 'Custom Font', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: <?php echo $themeStyles['background-color']; ?>;
            color: <?php echo $themeStyles['text-color']; ?>;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .theme-switcher {
            position: fixed;
            top: 20px;
            right: 20px;
            background: <?php echo $themeStyles['accent-color']; ?>;
            padding: 10px 20px;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }

        .theme-switcher:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .visit-counter {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: <?php echo $themeStyles['accent-color']; ?>;
            padding: 10px 20px;
            border-radius: 5px;
            color: white;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        /* Keep all your existing styles here */
        .background-section {
            position: relative;
            height: 60vh;
            background: url('images/contactheader.jpg') no-repeat center center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: left;
        }

        .background-section h1 {
            color: white;
            font-size: 3rem;
            text-transform: uppercase;
            font-weight: bold;
            margin: 0;
            padding-left: 20px;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            padding: 40px;
        }

        .grid-container img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .section-content {
            max-width: 500px;
            margin: auto;
            text-align: center;
        }

        .section-content h2 {
            font-size: 28px;
            margin-bottom: 20px;
            color: <?php echo $themeStyles['accent-color']; ?>;
        }

        .section-content p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 15px 30px;
            background-color: <?php echo $themeStyles['accent-color']; ?>;
            color: #ffffff;
            text-decoration: none;
            font-size: 18px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .contact-form {
            max-width: 600px;
            margin: 40px auto;
            background: <?php echo $themeStyles['theme'] === 'dark' ? '#444' : '#ffffff'; ?>;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #cccccc;
            border-radius: 5px;
            font-size: 16px;
            background: <?php echo $themeStyles['theme'] === 'dark' ? '#555' : '#ffffff'; ?>;
            color: <?php echo $themeStyles['text-color']; ?>;
        }

        textarea {
            height: 100px;
            resize: none;
        }

        button {
            width: 100%;
            padding: 15px;
            background-color: <?php echo $themeStyles['accent-color']; ?>;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        @font-face {
            font-family: 'Custom Font';
            src: url('Montserrat-Italic-VariableFont_wght.ttf') format('woff'),
                 url('Montserrat-Italic-VariableFont_wght.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
    </style>
</head>
<body>
    <!-- Theme Switcher -->
    <div class="theme-switcher" onclick="toggleTheme()">
        <i class="fa fa-<?php echo $preferences['theme'] === 'dark' ? 'sun-o' : 'moon-o'; ?>"></i>
        <?php echo ucfirst($preferences['theme']); ?> Mode
    </div>

    <!-- Visit Counter -->
    <div class="visit-counter" onclick="resetCounter()" style="cursor: pointer;">
        <i class="fa fa-eye"></i> Visit Count: <?php echo $visitCount; ?> <i class="fa fa-refresh" style="margin-left: 5px;"></i>
    </div>

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
                    <li><a href="./About.php" title="Learn About Us">About</a></li>
                    <li><a href="#contactForm" title="Contact Us">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="background-section">
        <h1>Contact Us</h1>
    </div>

    <div class="grid-container">
        <!-- Your existing grid content -->
    </div>

    <form id="contactForm" class="contact-form" onsubmit="handleSubmit(event)">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea id="message" name="message" required></textarea>
        </div>
        <button type="submit">Send Message</button>
        <div id="formMessage" style="display: none; margin-top: 20px; padding: 10px; border-radius: 5px;"></div>
    </form>

    <script>
        function toggleTheme() {
            const currentTheme = '<?php echo $preferences['theme']; ?>';
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            const newBgColor = newTheme === 'dark' ? '#333333' : '#f8f9fa';
            
            fetch('set_preferences.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `theme=${newTheme}&bg_color=${newBgColor}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function resetCounter() {
            fetch('reset_counter.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function handleSubmit(event) {
            event.preventDefault();
            const form = document.getElementById('contactForm');
            const messageDiv = document.getElementById('formMessage');
            
            // Show success message
            messageDiv.style.display = 'block';
            messageDiv.style.backgroundColor = '#4CAF50';
            messageDiv.style.color = 'white';
            messageDiv.textContent = 'Thank you for your message! We will get back to you soon.';
            
            // Reset form
            form.reset();
            
            // Hide message after 5 seconds
            setTimeout(() => {
                messageDiv.style.display = 'none';
            }, 5000);
        }
    </script>
</body>
</html> 