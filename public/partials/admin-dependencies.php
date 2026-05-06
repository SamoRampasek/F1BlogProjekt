<?php
session_start();
require_once '../../app/core/Database.php';
require_once '../../app/models/AdminCheck.php';
require_once '../../app/models/SQLOperations.php';
require_once '../../app/core/Helper.php';

$auth = new AdminCheck();
$auth->loginCheck();
$db = new Database();
$SQLOperations = new SQLOperations($db);
?>