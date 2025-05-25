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

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($first_name, $last_name, $username, $password, $email, $birthdate, $gender) {
        // Check if username exists
        if ($this->usernameExists($username)) {
            return false;
        }

        // Check if email exists
        if ($this->emailExists($email)) {
            return false;
        }

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO " . $this->table_name . "
                (first_name, last_name, username, password, email, birthdate, gender)
                VALUES
                (:first_name, :last_name, :username, :password, :email, :birthdate, :gender)";

        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $first_name = htmlspecialchars(strip_tags($first_name));
        $last_name = htmlspecialchars(strip_tags($last_name));
        $username = htmlspecialchars(strip_tags($username));
        $email = htmlspecialchars(strip_tags($email));
        $birthdate = htmlspecialchars(strip_tags($birthdate));
        $gender = htmlspecialchars(strip_tags($gender));

        // Bind parameters
        $stmt->bindParam(":first_name", $first_name);
        $stmt->bindParam(":last_name", $last_name);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":birthdate", $birthdate);
        $stmt->bindParam(":gender", $gender);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function login($username, $password) {
        try {
            // First check if the database connection is valid
            if (!$this->conn) {
                error_log("Database connection is null");
                return false;
            }

            // Prepare and execute the query
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
            if (!$stmt) {
                error_log("Failed to prepare statement: " . print_r($this->conn->errorInfo(), true));
                return false;
            }

            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                error_log("No user found with username: " . $username);
                return false;
            }

            if (!password_verify($password, $user['password'])) {
                error_log("Password verification failed for user: " . $username);
                return false;
            }

            // Set user properties
            $this->id = $user['user_id'];
            $this->username = $user['username'];
            $this->email = $user['email'];
            $this->first_name = $user['first_name'];
            $this->last_name = $user['last_name'];
            
            error_log("Login successful for user: " . $username);
            return true;
        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            return false;
        }
    }

    private function usernameExists($username) {
        $query = "SELECT id FROM " . $this->table_name . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    private function emailExists($email) {
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function update($user_id, $data) {
        try {
            $query = "UPDATE " . $this->table_name . " SET ";
            $params = [];
            
            foreach ($data as $key => $value) {
                if ($key !== 'user_id') {
                    $query .= "$key = :$key, ";
                    $params[":$key"] = $value;
                }
            }
            
            // Remove trailing comma and space
            $query = rtrim($query, ", ");
            $query .= " WHERE id = :user_id";
            $params[':user_id'] = $user_id;
            
            $stmt = $this->conn->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            return false;
        }
    }
}
?> 