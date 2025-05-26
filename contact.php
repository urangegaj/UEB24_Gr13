<?php
require_once 'session_handler.php';


$config = [
    'smtp_host' => 'smtp.gmail.com',  
    'smtp_port' => 587,              
    'smtp_username' => 'your-email@gmail.com',  
    'smtp_password' => 'your-app-password',     
    'recipient_email' => 'recipient@example.com' 
];


function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = ['success' => false, 'message' => ''];
    

    $name = sanitize_input($_POST['name'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $message = sanitize_input($_POST['message'] ?? '');
    

    if (empty($name) || empty($email) || empty($message)) {
        $response['message'] = 'All fields are required';
    } elseif (!validate_email($email)) {
        $response['message'] = 'Invalid email format';
    } else {

        $to = $config['recipient_email'];
        $subject = "New Contact Form Submission from $name";
        

        $headers = [
            'From' => $email,
            'Reply-To' => $email,
            'X-Mailer' => 'PHP/' . phpversion(),
            'Content-Type' => 'text/html; charset=UTF-8'
        ];
        

        $email_body = "
            <html>
            <body>
                <h2>New Contact Form Submission</h2>
                <p><strong>Name:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Message:</strong><br>$message</p>
            </body>
            </html>
        ";
        

        try {

            $mail_sent = mail($to, $subject, $email_body, implode("\r\n", $headers));
            
            if ($mail_sent) {
                $response['success'] = true;
                $response['message'] = 'Thank you for your message. We will get back to you soon!';
            } else {
                $response['message'] = 'Failed to send email. Please try again later.';
            }
        } catch (Exception $e) {
            $response['message'] = 'An error occurred: ' . $e->getMessage();
        }
    }
    

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

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
            top: 20px;
            right: 20px;
            background: <?php echo $themeStyles['accent-color']; ?>;
            padding: 12px 24px;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            z-index: 1001;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 16px;
            font-weight: bold;
            white-space: nowrap;
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
            position: relative;
        }

        .background-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
        }

        .background-section h1 {
            color: white;
            font-size: 3.5rem;
            text-transform: uppercase;
            font-weight: bold;
            margin: 0;
            padding-left: 20px;
            position: relative;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
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
            background: <?php echo $themeStyles['theme'] === 'dark' ? '#2a2a2a' : '#ffffff'; ?>;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            border: 1px solid <?php echo $themeStyles['theme'] === 'dark' ? '#444' : '#e0e0e0'; ?>;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .contact-form:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.2);
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 12px;
            font-weight: 600;
            color: <?php echo $themeStyles['theme'] === 'dark' ? '#ffffff' : '#333333'; ?>;
            font-size: 16px;
            transition: color 0.3s ease;
        }

        input, textarea {
            width: 100%;
            padding: 16px;
            border: 2px solid <?php echo $themeStyles['theme'] === 'dark' ? '#444' : '#e0e0e0'; ?>;
            border-radius: 10px;
            font-size: 16px;
            background: <?php echo $themeStyles['theme'] === 'dark' ? '#333333' : '#ffffff'; ?>;
            color: <?php echo $themeStyles['theme'] === 'dark' ? '#ffffff' : '#333333'; ?>;
            transition: all 0.3s ease;
        }

        input::placeholder, textarea::placeholder {
            color: <?php echo $themeStyles['theme'] === 'dark' ? '#cccccc' : '#999999'; ?>;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: <?php echo $themeStyles['accent-color']; ?>;
            box-shadow: 0 0 0 4px <?php echo $themeStyles['theme'] === 'dark' ? 'rgba(0, 123, 255, 0.3)' : 'rgba(0, 123, 255, 0.15)'; ?>;
            background: <?php echo $themeStyles['theme'] === 'dark' ? '#3a3a3a' : '#ffffff'; ?>;
            color: <?php echo $themeStyles['theme'] === 'dark' ? '#ffffff' : '#333333'; ?>;
        }


        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        textarea:-webkit-autofill,
        textarea:-webkit-autofill:hover,
        textarea:-webkit-autofill:focus {
            -webkit-text-fill-color: <?php echo $themeStyles['theme'] === 'dark' ? '#ffffff' : '#333333'; ?>;
            -webkit-box-shadow: 0 0 0px 1000px <?php echo $themeStyles['theme'] === 'dark' ? '#333333' : '#ffffff'; ?> inset;
            transition: background-color 5000s ease-in-out 0s;
        }

        textarea {
            height: 150px;
            resize: none;
            line-height: 1.5;
        }

        button {
            width: 100%;
            padding: 18px;
            background-color: <?php echo $themeStyles['accent-color']; ?>;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
        }

        button:hover {
            opacity: 0.95;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        button:active {
            transform: translateY(0);
        }

        #formMessage {
            margin-top: 25px;
            padding: 16px;
            border-radius: 10px;
            text-align: center;
            font-weight: 600;
            background: <?php echo $themeStyles['theme'] === 'dark' ? '#333333' : '#f8f9fa'; ?>;
            color: <?php echo $themeStyles['theme'] === 'dark' ? '#ffffff' : '#333333'; ?>;
            border: 1px solid <?php echo $themeStyles['theme'] === 'dark' ? '#444' : '#e0e0e0'; ?>;
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateY(-10px);
        }

        #formMessage.show {
            opacity: 1;
            transform: translateY(0);
        }


        #formMessage.success {
            background-color: #4CAF50;
            color: white;
            border-color: #45a049;
        }

        #formMessage.error {
            background-color: #f44336;
            color: white;
            border-color: #e53935;
        }


        @media (max-width: 768px) {
            .contact-form {
                margin: 20px;
                padding: 25px;
            }

            .background-section h1 {
                font-size: 2.5rem;
            }

            input, textarea {
                padding: 14px;
            }

            button {
                padding: 16px;
            }

            .theme-switcher {
                padding: 10px 20px;
                font-size: 14px;
                right: 10px;
                top: 10px;
            }
        }

        @font-face {
            font-family: 'Custom Font';
            src: url('Montserrat-Italic-VariableFont_wght.ttf') format('woff'),
                 url('Montserrat-Italic-VariableFont_wght.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        .footer {
            background-color: <?php echo $themeStyles['theme'] === 'dark' ? '#1a1a1a' : '#ffffff'; ?>;
            padding: 20px 0;
            margin-top: 60px;
            border-top: 1px solid <?php echo $themeStyles['theme'] === 'dark' ? '#333' : '#e0e0e0'; ?>;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        }

        .footer .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            text-align: center;
        }

        .footer p {
            color: <?php echo $themeStyles['theme'] === 'dark' ? '#ffffff' : '#333333'; ?>;
            margin: 0;
            font-size: 14px;
            font-weight: 500;
        }


        @media (max-width: 768px) {
            .footer {
                margin-top: 40px;
                padding: 15px 0;
            }
        }

        .header {
            position: relative;
        }

        .header .container {
            position: relative;
        }
    </style>
</head>
<body>

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
                    <li><a href="./index.php" title="Go to Homepage">Home</a></li>
                    <li><a href="./Products.php" title="View Products">Products</a></li>
                    <li><a href="./About.php" title="Learn About Us">About</a></li>
                    <li><a href="#contactForm" title="Contact Us">Contact</a></li>
                </ul>
            </nav>
            <div class="theme-switcher" onclick="toggleTheme()">
                <i class="fa fa-<?php echo $preferences['theme'] === 'dark' ? 'sun-o' : 'moon-o'; ?>"></i>
                <span>Switch to <?php echo $preferences['theme'] === 'dark' ? 'Light' : 'Dark'; ?> Mode</span>
            </div>
        </div>
    </header>

    <div class="background-section">
        <h1>Contact Us</h1>
    </div>

    <div class="grid-container">

    </div>

    <form id="contactForm" class="contact-form" method="POST">
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
    
     <!-- perdorimi i require -->
     <?php require 'footer.php'; ?>

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

        document.getElementById('contactForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const form = this;
            const messageDiv = document.getElementById('formMessage');
            const submitButton = form.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.textContent;
            
            submitButton.textContent = 'Sending...';
            submitButton.disabled = true;

            fetch(window.location.href, {
                method: 'POST',
                body: new FormData(form)
            })
            .then(response => response.json())
            .then(data => {
                messageDiv.textContent = data.message;
                messageDiv.style.display = 'block';
                messageDiv.className = data.success ? 'success' : 'error';
                messageDiv.classList.add('show');
                
                if (data.success) {
                    form.reset();
                    setTimeout(() => {
                        messageDiv.classList.remove('show');
                        setTimeout(() => {
                            messageDiv.style.display = 'none';
                        }, 300);
                    }, 5000);
                }
            })
            .catch(error => {
                messageDiv.textContent = 'An error occurred. Please try again.';
                messageDiv.style.display = 'block';
                messageDiv.className = 'error show';
            })
            .finally(() => {
                submitButton.textContent = originalButtonText;
                submitButton.disabled = false;
            });
        });
    </script>
</body>
</html> 