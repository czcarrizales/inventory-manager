<?php

require_once('database.php');
require 'database.class.php';

$database = new Database();
$product_id = $_POST['product_id'];
$product_name = $_POST['product_name'];
$description = $_POST['description'];
$price = $_POST['price'];
$category_id = $_POST['category_id'];

$database->query("UPDATE products SET product_name = :product_name, description = :description, price = :price, category_id = :category_id WHERE product_id = :product_id");
$database->bind(":product_id", $product_id);
$database->bind(":product_name", $product_name);
$database->bind(":description", $description);
$database->bind(":price", $price);
$database->bind(":category_id", $category_id);
$database->execute();
header('Location: index.php');
?>