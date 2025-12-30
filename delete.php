<?php
include_once 'config/Database.php';
include_once 'classes/Product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$id = isset($_GET['id']) ? $_GET['id'] : die('ID tidak valid.');
$product->id = $id;

if ($product->delete()) {
    header("Location: index.php");
} else {
    $message = "Gagal menghapus barang.";
}
