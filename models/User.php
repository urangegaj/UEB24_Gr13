<?php
class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $first_name;
    public $last_name;
    public $username;
    public $password;
    public $email;
    public $birthdate;
    public $gender;
    public $created_at;
    public $profile_picture;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($first_name, $last_name, $username, $password, $email, $birthdate, $gender) {
        try {
            if ($this->usernameExists($username)) {
                return false;
            }

            if ($this->emailExists($email)) {
                return false;
            }

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO " . $this->table_name . " 
                      (first_name, last_name, username, password, email)
                      VALUES 
                      (?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($this->conn, $query);

            $first_name = htmlspecialchars(strip_tags($first_name));
            $last_name = htmlspecialchars(strip_tags($last_name));
            $username = htmlspecialchars(strip_tags($username));
            $email = htmlspecialchars(strip_tags($email));

            mysqli_stmt_bind_param($stmt, "sssss", $first_name, $last_name, $username, $hashed_password, $email);

            return mysqli_stmt_execute($stmt);
        } catch (Exception $e) {
            error_log("Create error in User class: " . $e->getMessage());
            return false;
        }
    }

    public function login($username, $password) {
        try {
            error_log("Login attempt for user: " . $username);
            
            $query = "SELECT user_id, username, first_name, last_name, email, password, profile_picture FROM users WHERE username = ? LIMIT 1";
            $stmt = mysqli_prepare($this->conn, $query);
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);
                error_log("User found in database: " . print_r($row, true));
                
                // Log the password verification attempt
                error_log("Attempting to verify password for user: " . $username);
                error_log("Stored hash: " . $row['password']);
                error_log("Provided password: " . $password);
                
                if (password_verify($password, $row['password'])) {
                    error_log("Password verified for user: " . $username);
                    
                    // Set object properties
                    $this->id = (int)$row['user_id'];
                    $this->first_name = $row['first_name'];
                    $this->last_name = $row['last_name'];
                    $this->email = $row['email'];
                    $this->username = $row['username'];
                    $this->profile_picture = $row['profile_picture'];
                    
                    // Create user data array with explicit user_id
                    $userData = [
                        'user_id' => (int)$row['user_id'], // Ensure it's an integer
                        'username' => $this->username,
                        'first_name' => $this->first_name,
                        'last_name' => $this->last_name,
                        'email' => $this->email,
                        'profile_picture' => $this->profile_picture
                    ];
                    
                    error_log("Returning user data: " . print_r($userData, true));
                    return $userData;
                } else {
                    error_log("Password verification failed for user: " . $username);
                    error_log("Password verification details:");
                    error_log("Stored hash: " . $row['password']);
                    error_log("Provided password: " . $password);
                }
            } else {
                error_log("No user found with username: " . $username);
            }
            return false;
        } catch (Exception $e) {
            error_log("Login error in User class: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

    private function usernameExists($username) {
        $query = "SELECT user_id FROM " . $this->table_name . " WHERE username = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_num_rows($result) > 0;
    }

    private function emailExists($email) {
        $query = "SELECT user_id FROM " . $this->table_name . " WHERE email = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_num_rows($result) > 0;
    }

    public function update($user_id, $data) {
        try {
            error_log("Updating user profile for ID: " . $user_id);
            error_log("Update data: " . print_r($data, true));

            // Get current user data
            $query = "SELECT username, email, profile_picture FROM " . $this->table_name . " WHERE user_id = ?";
            $stmt = mysqli_prepare($this->conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $current_user = mysqli_fetch_assoc($result);

            if (!$current_user) {
                error_log("User not found with ID: " . $user_id);
                return false;
            }

            // Check if username is being changed and if it already exists
            if (isset($data['username']) && $data['username'] !== $current_user['username']) {
                $query = "SELECT user_id FROM " . $this->table_name . " WHERE username = ? AND user_id != ?";
                $stmt = mysqli_prepare($this->conn, $query);
                mysqli_stmt_bind_param($stmt, "si", $data['username'], $user_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result) > 0) {
                    error_log("Username already exists: " . $data['username']);
                    return false;
                }
            }

            // Check if email is being changed and if it already exists
            if (isset($data['email']) && $data['email'] !== $current_user['email']) {
                $query = "SELECT user_id FROM " . $this->table_name . " WHERE email = ? AND user_id != ?";
                $stmt = mysqli_prepare($this->conn, $query);
                mysqli_stmt_bind_param($stmt, "si", $data['email'], $user_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result) > 0) {
                    error_log("Email already exists: " . $data['email']);
                    return false;
                }
            }

            // Build the update query
            $query = "UPDATE " . $this->table_name . " SET ";
            $params = array();
            $types = "";

            foreach ($data as $key => $value) {
                if ($key === 'password') {
                    $query .= "password = ?, ";
                } else if ($key === 'profile_picture') {
                    // If there's an existing profile picture, delete it
                    if (!empty($current_user['profile_picture'])) {
                        $old_picture_path = __DIR__ . '/../' . $current_user['profile_picture'];
                        if (file_exists($old_picture_path)) {
                            unlink($old_picture_path);
                        }
                    }
                    $query .= "profile_picture = ?, ";
                } else {
                    $query .= $key . " = ?, ";
                }
                $params[] = $value;
                $types .= "s";
            }

            // Remove trailing comma and space
            $query = rtrim($query, ", ");
            $query .= " WHERE user_id = ?";
            $params[] = $user_id;
            $types .= "i";

            $stmt = mysqli_prepare($this->conn, $query);
            if (!$stmt) {
                error_log("Prepare statement failed: " . mysqli_error($this->conn));
                return false;
            }

            mysqli_stmt_bind_param($stmt, $types, ...$params);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                error_log("Profile update successful for user ID: " . $user_id);
                // Update object properties
                foreach ($data as $key => $value) {
                    if (property_exists($this, $key)) {
                        $this->$key = $value;
                    }
                }
                return true;
            } else {
                error_log("Profile update failed: " . mysqli_error($this->conn));
                return false;
            }
        } catch (Exception $e) {
            error_log("Error in update method: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }
}
?>
