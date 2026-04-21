<?php
session_start();
session_destroy();
require_once '../../app/core/Helper.php';
Helper::redirect("home.php");
exit;
?>