<?php
// Include the database connection
require_once('database.php');
require 'database.class.php';

$database = new Database();


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['function'])) {
        $functionName = $_GET['function'];
        if ($functionName === 'getProducts') {
            $category_id = $_GET['category_id'];
            $company_id = $_GET['company_id'];
            $keyword = $_GET['keyword'];
            $result = getProducts($database, $company_id, $category_id, $keyword);
            echo json_encode(['result' => $result]);
        } else if ($functionName === 'searchByKeyword') {
            if (isset($_GET['keyword'])) {
                $keyword = $_GET['keyword'];
                $company_id = $_GET['company_id'];
                $result = searchByKeyword($database, $keyword, $company_id);
                echo json_encode(['result' => $result]);
            }
        } else if ($functionName === 'getAllCompanies') {
            $result = getAllCompanies($database);
            echo json_encode(['result' => $result]);
        } else if ($functionName === 'getAllCategories') {
            $company_id = $_GET['company_id'];
            $result = getAllCategories($database, $company_id);
            echo json_encode(['result' => $result]);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['function'])) {
        $function = $_POST['function'];
        
        if ($function === 'deleteById') {
            if (isset($_POST['id'])) {
                $id = (int)$_POST['id'];
                // this is a number up above ^^^
                if (deleteById($database, $id)) {
                    echo json_encode(['message' => 'Delete success']);
                } else {
                    echo json_encode(['message' => 'delete fail']);
                }
            }
        } elseif ($function === 'addProductToDatabase') {
            $product_name = $_POST['product_name'];
            $description = $_POST['description'];
            $price= $_POST['price'];
            $category_id = $_POST['category_id'];
            $company_id = $_POST['company_id'];
            echo addProductToDatabase($database, $product_name, $description, $price, $category_id, $company_id);
            
        } else {
            echo json_encode(['message' => 'the function does not exist?']);
        }
    }
} else {
    echo json_encode(['message' => 'something went wrong or invalid request']);
}

function addProductToDatabase($database, $product_name, $description, $price, $category_id, $company_id)
{
    $database->query("INSERT INTO products (product_name, description, price, category_id, company_id) VALUES (:product_name, :description, :price, :category_id, :company_id)");
    $database->bind(':product_name', $product_name);
    $database->bind(':description', $description);
    $database->bind(':price', $price);
    $database->bind(':category_id', $category_id);
    $database->bind(':company_id', $company_id);
    if ($database->execute()) {
        return 'add product success';
    } else {
        return 'add product fail';
    }
}

function editById($database, $id)
{
    $database->query("SELECT * FROM items WHERE id=:id");
    $database->query("UPDATE items SET WHERE id=:id");
    $database->bind(":id", $id);
    $item = $database->execute();
}

function deleteById($database, $id)
{
    $database->query("DELETE FROM products WHERE product_id=:id");
    $database->bind(':id', $id);
    $database->execute();
}

function getProducts($database, $company_id, $category_id, $keyword)
{
    if ($category_id == '') {
        $database->query("SELECT company_name FROM companies WHERE company_id = $company_id");
        $company_name = $database->single();

        $database->query("SELECT * FROM products WHERE company_id = $company_id AND product_name LIKE '%$keyword%'");
        $result = $database->resultset();

        return [$company_name, $result];
    } else {
        $database->query("SELECT company_name FROM companies WHERE company_id = $company_id");
        $company_name = $database->single();

        $database->query("SELECT * FROM products WHERE company_id = $company_id AND category_id = $category_id AND product_name LIKE '%$keyword%'");
        $result = $database->resultset();
        return [$company_name, $result];
    }
}

function getAllCompanies($database)
{
    $database->query("SELECT * FROM companies");
    $result = $database->resultset();
    return $result;
}

function getAllCategories($database, $company_id)
{
    $database->query("SELECT * FROM categories WHERE company_id = $company_id");
    $result = $database->resultset();
    return $result;
}

function searchByKeyword($database, $keyword, $company_id)
{
    if ($keyword == '') {
        $database->query("SELECT * FROM products WHERE company_id = $company_id");
        $result = $database->resultset();
        return $result;
    } else {
        $database->query("SELECT * FROM products WHERE product_name LIKE '%$keyword%' AND company_id = $company_id");
        $result = $database->resultset();
        return $result;
    }
}
