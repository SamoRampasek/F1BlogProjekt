<?php
require_once '../../app/core/Helper.php';

class AdminCheck
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function loginCheck()
    {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            Helper::redirect("login.php");
            exit;
        }
    }
}