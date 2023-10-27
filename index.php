<?php
session_start();

require_once('database.php');
require_once('functions.php');
require('auth.php');
require_once('database.class.php');

$database = new Database();
$database->query("SELECT company_name FROM companies WHERE company_id=1");
$companyName = $database->single();

if (!isAuthenticated()) {
    header('Location: registration.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./index.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="index.js" defer></script>
    <title>Inventory Manager</title>
</head>

<body>
    <?php include('navbar.php') ?>
    <h1 id="companyNameTitle"></h1>
    <div id="search-tools">
        <div>
            <h1>Choose Company</h1>
            <select name="" id="selectCompaniesDropdown">
            </select>
        </div>

        <form action="get" id="searchByKeywordForm">
            <h2>Search for Product By Name</h2>
            <label for="">Keyword</label>
            <input type="text" id="keyword">
            <input type="submit">
        </form>
        <form method="get" id="sortItemsForm">
            <h2>Sort Products By Category</h2>
            <label for="">Category</label>
            <select name="category" id="selectCategoriesDropdown">
                <option value="">All</option>
            </select>
            <input type="submit" name="sortItems">
        </form>
        <form method="post" id="addProductToDatabaseForm">
            <h2>Add Product To Database</h2>
            <div>
                <label for="">Name</label>
                <input type="text" name="name" id="addProductName" required>
            </div>
            <div>
                <label for="">Description</label>
                <input type="text" name="description" id="addProductDescription">
            </div>
            <div>
                <label for="">Price</label>
                <input type="number" step="0.01" name="price" id="addProductPrice" required>
            </div>
            <div>
                <label for="">Category</label>
                <select name="category" id="addProductCategorySelect">
                </select>
            </div>
            <input type="submit" value="Add Product">
        </form>
        
    </div>
    <form action="" id="addToInventoryForm">
        <h2>Add To Inventory By Product</h2>
        <select name="" id="addToInventorySelect"></select>
        <input type="number" id="addToInventoryQuantity" min="1" value="1">
        <input type="submit">
    </form>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Category</th>
            </tr>
        </thead>
        <tbody id="inventoryTableBody">

        </tbody>
    </table>
</body>

</html>