<?php
require_once 'config/database.php';
require_once 'models/User.php';
require_once 'includes/session.php'; // Starts session

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!isset($_POST['username']) || !isset($_POST['password'])) {
            throw new Exception("Username and password are required");
        }

        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if (empty($username) || empty($password)) {
            throw new Exception("Username and password cannot be empty");
        }

        // Attempt login
        if ($user->login($username, $password)) {
            $response['success'] = true;
            $response['message'] = "Login successful!";
            $response['user'] = array(
                'username'   => $_SESSION['username'],
                'first_name' => $_SESSION['first_name'],
                'last_name'  => $_SESSION['last_name'],
                'email'      => $_SESSION['email']
            );
        } else {
            // Clear login-related session variables only
            unset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['first_name'], $_SESSION['last_name'], $_SESSION['email']);
            $response['message'] = "Invalid username or password";
        }
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
