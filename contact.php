<?php
require_once 'session_handler.php';


$visitCount = incrementVisitCount();


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
            top: 80px;
            right: 20px;
            background: <?php echo $themeStyles['accent-color']; ?>;
            padding: 12px 24px;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            z-index: 1001;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 16px;
            font-weight: bold;
        }

        .theme-switcher i {
            font-size: 20px;
        }

        .theme-switcher:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.3);
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
            background: <?php echo $themeStyles['theme'] === 'dark' ? '#1a1a1a' : '#ffffff'; ?>;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            border: 1px solid <?php echo $themeStyles['theme'] === 'dark' ? '#333' : '#e0e0e0'; ?>;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: <?php echo $themeStyles['theme'] === 'dark' ? '#ffffff' : '#333333'; ?>;
            font-size: 16px;
        }

        input, textarea {
            width: 100%;
            padding: 14px;
            border: 2px solid <?php echo $themeStyles['theme'] === 'dark' ? '#444' : '#cccccc'; ?>;
            border-radius: 8px;
            font-size: 16px;
            background: <?php echo $themeStyles['theme'] === 'dark' ? '#2a2a2a' : '#ffffff'; ?>;
            color: <?php echo $themeStyles['theme'] === 'dark' ? '#ffffff' : '#333333'; ?>;
            transition: all 0.3s ease;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: <?php echo $themeStyles['accent-color']; ?>;
            box-shadow: 0 0 0 3px <?php echo $themeStyles['theme'] === 'dark' ? 'rgba(0, 123, 255, 0.4)' : 'rgba(0, 123, 255, 0.2)'; ?>;
            background: <?php echo $themeStyles['theme'] === 'dark' ? '#333333' : '#ffffff'; ?>;
        }

        input::placeholder, textarea::placeholder {
            color: <?php echo $themeStyles['theme'] === 'dark' ? '#888888' : '#999999'; ?>;
        }

        textarea {
            height: 120px;
            resize: none;
        }

        button {
            width: 100%;
            padding: 16px;
            background-color: <?php echo $themeStyles['accent-color']; ?>;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        button:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            background-color: <?php echo $themeStyles['theme'] === 'dark' ? '#0056b3' : '#0056b3'; ?>;
        }

        #formMessage {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            font-weight: bold;
            background: <?php echo $themeStyles['theme'] === 'dark' ? '#2a2a2a' : '#f8f9fa'; ?>;
            color: <?php echo $themeStyles['theme'] === 'dark' ? '#ffffff' : '#333333'; ?>;
            border: 1px solid <?php echo $themeStyles['theme'] === 'dark' ? '#444' : '#e0e0e0'; ?>;
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

    <div class="theme-switcher" onclick="toggleTheme()">
        <i class="fa fa-<?php echo $preferences['theme'] === 'dark' ? 'sun-o' : 'moon-o'; ?>"></i>
        <span>Switch to <?php echo $preferences['theme'] === 'dark' ? 'Light' : 'Dark'; ?> Mode</span>
    </div>


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
            
            fetch('set_preferences.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ theme: newTheme })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload the page to apply the new theme
                    window.location.reload();
                } else {
                    console.error('Failed to update theme:', data.error);
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
                        window.location.reload();
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
            

            messageDiv.style.display = 'block';
            messageDiv.style.backgroundColor = '#4CAF50';
            messageDiv.style.color = 'white';
            messageDiv.textContent = 'Thank you for your message!';
            

            form.reset();
            

            setTimeout(() => {
                messageDiv.style.display = 'none';
            }, 5000);
        }
    </script>
</body>
</html> 