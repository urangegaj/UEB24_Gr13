<?php

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
?> 