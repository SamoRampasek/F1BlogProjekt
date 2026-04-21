<?php
require_once '../../app/core/Helper.php';

class Login
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function checkSession()
    {
        if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
            Helper::redirect("admin.php");
            exit;
        }
    }

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
                Helper::redirect("admin.php");
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
            $query = $this->db->prepare("SELECT admin_id, username, password_hash FROM admins WHERE username = :username");
            $query->execute(['username' => $username]);
            $stmt = $query->fetch();

            if ($stmt && password_verify($password, $stmt['password_hash'])) {
                return $stmt;
            }
        } catch (PDOException $e) {
            return false;
        }

        return false;
    }
}
?>