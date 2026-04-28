<?php
session_start();
require_once '../../app/core/Database.php';
require_once '../../app/models/AdminCheck.php';
require_once '../../app/models/BlogOperations.php';
require_once '../../app/models/QueryOperations.php';
require_once '../../app/core/Helper.php';

$auth = new AdminCheck();
$auth->loginCheck();
$db = new Database();
$BlogOperations = new BlogOperations($db);
$QueryOperations = new QueryOperations($db);
?>