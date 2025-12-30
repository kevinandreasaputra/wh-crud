<?php
include_once 'config/Database.php';
include_once 'classes/Auth.php';

$database = new Database();
$conn = $database->getConnection();
$auth = new Auth($conn);

$auth->logout();
header("Location: login.php");
