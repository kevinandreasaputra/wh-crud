<?php
class Auth
{
    private $conn;
    private $table_name = "users";

    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function register($username, $password, $role)
    {
        $query = "INSERT INTO " . $this->table_name . " SET username = :username, password = :password, role = :role";
        $stmt = $this->conn->prepare($query);

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $username = htmlspecialchars(strip_tags($username));
        $role = htmlspecialchars(strip_tags($role));

        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $password_hash);
        $stmt->bindParam(":role", $role);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function login($username, $password)
    {
        $query = "SELECT id, username, password, role FROM " . $this->table_name . " WHERE username = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $row['password'])) {
                session_start();
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['username'] = $row['username'];
                return true;
            }
        }
        return false;
    }

    public function isLoggedIn()
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        }
        return false;
    }

    public function isAdmin()
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
            return true;
        }
        return false;
    }

    public function logout()
    {
        session_start();
        session_destroy();
        return true;
    }
}
