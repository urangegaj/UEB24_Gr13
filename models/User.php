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
        try {
            if ($this->usernameExists($username)) {
                return false;
            }

            if ($this->emailExists($email)) {
                return false;
            }

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO " . $this->table_name . " 
                      (first_name, last_name, username, password, email, birthdate, gender)
                      VALUES 
                      (:first_name, :last_name, :username, :password, :email, :birthdate, :gender)";

            $stmt = $this->conn->prepare($query);

            $first_name = htmlspecialchars(strip_tags($first_name));
            $last_name = htmlspecialchars(strip_tags($last_name));
            $username = htmlspecialchars(strip_tags($username));
            $email = htmlspecialchars(strip_tags($email));
            $birthdate = htmlspecialchars(strip_tags($birthdate));
            $gender = htmlspecialchars(strip_tags($gender));

            $stmt->bindParam(":first_name", $first_name);
            $stmt->bindParam(":last_name", $last_name);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password", $hashed_password);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":birthdate", $birthdate);
            $stmt->bindParam(":gender", $gender);

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function login($username, $password) {
        try {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":username", $username);
            $stmt->execute();

            if ($stmt->rowCount() === 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($password, $row['password'])) {
                    session_regenerate_id(true);

                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['first_name'] = $row['first_name'];
                    $_SESSION['last_name'] = $row['last_name'];
                    $_SESSION['email'] = $row['email'];

                    return true;
                }
            }
            return false;
        } catch (PDOException $e) {
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
}
?>
