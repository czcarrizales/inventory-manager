<?php
require_once('functions.php');
require_once('database.class.php');
$database = new Database();
$product_id = $_GET['product_id'];
$company_id = $_GET['company_id'];
$categories = getAllCategories($database, $company_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="editProduct.js" defer></script>
</head>
<body>
    <form method="POST" action="updateProduct.php">
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        <div>
        <label for="">Name</label>
        <input type="text" name="product_name" id="editProductName">
        </div>
        <div>
        <label for="">Description</label>
        <input type="text" name="description" id="editProductDescription">
        </div>
        <div>
        <label for="">Price</label>
        <input type="number" name="price" id="editProductPrice">
        </div>
        <div>
        <label for="">Category</label>
        <?php
            echo '<select name="category_id" id="editProductCategory">';
            foreach($categories as $category) {
                $category_id = $category['category_id'];
                echo "<option value='$category_id'>";
                echo $category['category_name'];
                echo "</option>";
            };
            echo '</select>';
        ?>
        // FIGURE OUT HOW TO POPULATE THE INPUTS WITH THE STUFF THAT WAS ALREADY THERE
        </div>
        <input type="submit">
    </form>
    <p><?php echo $product_id ?></p>
</body>
</html>