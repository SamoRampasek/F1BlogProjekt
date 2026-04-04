<?php

class Login
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // handling ak je admin uz loginnuty
    public function checkSession()
    {
        if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
            header("Location: admin.php");
            exit;
        }
    }

    // login form
    public function processForm()
    {
        $error = '';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $admin = $this->authenticate($username, $password);

            if ($admin) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username'] = $admin['username'];
                header("Location: admin.php");
                exit;
            } else {
                $error = "Invalid username or password.";
            }
        }

        return $error;
    }

    public function authenticate($username, $password)
    {
        try {
            $prikaz = $this->db->prepare("SELECT admin_id, username, password_hash FROM admins WHERE username = :username");
            $prikaz->execute(['username' => $username]);
            $admin = $prikaz->fetch();

            if ($admin && password_verify($password, $admin['password_hash'])) {
                return $admin;
            }
        } catch (PDOException $e) {
            return false;
        }

        return false;
    }
}
?>