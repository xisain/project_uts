<?php
require('../config.php');
$sql_product = "SELECT * FROM category";
$result_product = mysqli_query($conn, $sql_product);
$sql_cust = "SELECT brand_id, brand_name FROM brand";
$result_cust = mysqli_query($conn, $sql_cust);

    if (isset($_POST["submit"])) {
        // Retrieve form data
        $product_name = $_POST['product_name'];
        $category_id = $_POST['category_id'];
        $brand_id = $_POST['brand_id'];
        $stock = $_POST['stock'];
        $price = $_POST['price'];
    
        // echo "Product Name: " . $product_name . "<br>";
        // echo "Category ID: " . $category_id . "<br>";
        // echo "Brand ID: " . $brand_id . "<br>";
        // echo "Stock: " . $stock . "<br>";
        // echo "Price: " . $price . "<br>";
        // SQL statement to insert data into the product table
        $sql = "INSERT INTO product (product_name, category_id, brand_id, stock, price) 
                VALUES ('$product_name', '$category_id', '$brand_id', '$stock', '$price')";
    
        // Execute the query
        if (mysqli_query($conn, $sql)) {
            header("location:index.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Add Barang</title>
</head>
<body class="bg-gray-100">


<div class="container mx-auto my-8 p-8 bg-white shadow-lg rounded-lg">
    <form action="" method="post">
        <div class="mb-4">
            <label for="product_name" class="block text-gray-600 font-bold">Product Name</label>
            <input type="text" name="product_name" id="product_name" class="w-full p-2 border rounded-md">
        </div>

        <div class="mb-4">
            <label for="category_id" class="block text-gray-600 font-bold">Category ID</label>
            <select name="category_id" id="category_id" class="w-full p-2 border rounded-md">
                <?php
                while($datacategory = mysqli_fetch_assoc($result_product)){
                    echo "<option value='" . $datacategory['category_id'] . "'>" . $datacategory['category_name'] . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-4">
            <label for="brand_id" class="block text-gray-600 font-bold">Brand ID</label>
            <select name="brand_id" id="brand_id" class="w-full p-2 border rounded-md">
            <?php
                while($databrand = mysqli_fetch_assoc($result_cust)){
                    echo "<option value='" . $databrand['brand_id'] . "'>" . $databrand['brand_name'] . "</option>";
                }
                ?>
        </select>
        </div>

        <div class="mb-4">
            <label for="stock" class="block text-gray-600 font-bold">Stock</label>
            <input type="text" name="stock" id="stock" class="w-full p-2 border rounded-md">
        </div>

        <div class="mb-4">
            <label for="price" class="block text-gray-600 font-bold">Price</label>
            <input type="text" name="price" id="price" class="w-full p-2 border rounded-md">
        </div>

        <button type="submit" name="submit"class="bg-blue-500 text-white p-2 rounded-md hover:bg-blue-700">Submit</button>
    </form>
</div>

</body>
</html>
