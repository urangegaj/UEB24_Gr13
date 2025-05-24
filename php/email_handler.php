<?php
// Email configuration
$config = [
    'smtp_host' => 'smtp.gmail.com',  // Replace with your SMTP host
    'smtp_port' => 587,              // Replace with your SMTP port
    'smtp_username' => 'your-email@gmail.com',  // Replace with your email
    'smtp_password' => 'your-app-password',     // Replace with your password
    'recipient_email' => 'recipient@example.com' // Replace with recipient email
];

// Function to sanitize input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to validate email
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Check if it's a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = ['success' => false, 'message' => ''];
    
    // Get and sanitize form data
    $name = sanitize_input($_POST['name'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $message = sanitize_input($_POST['message'] ?? '');
    
    // Validate inputs
    if (empty($name) || empty($email) || empty($message)) {
        $response['message'] = 'All fields are required';
    } elseif (!validate_email($email)) {
        $response['message'] = 'Invalid email format';
    } else {
        // Prepare email content
        $to = $config['recipient_email'];
        $subject = "New Contact Form Submission from $name";
        
        // Prepare email headers
        $headers = [
            'From' => $email,
            'Reply-To' => $email,
            'X-Mailer' => 'PHP/' . phpversion(),
            'Content-Type' => 'text/html; charset=UTF-8'
        ];
        
        // Prepare email body
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
        
        // Try to send email
        try {
            // Using mail() function
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
    
    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?> 