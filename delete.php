<?php
include_once 'config/Database.php';
include_once 'classes/Product.php';
include_once  'classes/Auth.php';


$database = new Database();
$db = $database->getConnection();
$auth = new Auth($db);
session_start();

if (!$auth->isAdmin()) {
    header("Location: index.php");
    exit();
}

$product = new Product($db);
$id = isset($_GET['id']) ? $_GET['id'] : die('ID tidak valid.');
$product->id = $id;

if ($product->delete()) {
    header("Location: index.php");
} else {
    $message = "Gagal menghapus barang.";
}
