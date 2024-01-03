<?php
require('../config.php');
$sql_categories = "SELECT * FROM category";
$result_categories = mysqli_query($conn, $sql_categories);

$sql_brand = "SELECT * FROM brand";
$result_brand = mysqli_query($conn, $sql_brand);

if (isset($_GET['id'])) {
    $UserID = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM product WHERE product_id=$UserID");
    $user_data = mysqli_fetch_array($result);
}
if(isset($_POST['update'])){
  $product_id = $_POST['product_id'];
  $product_name = $_POST['product_name'];
  $category_id = $_POST['category'];
  $brand_id = $_POST['brand_id'];
  $stock = $_POST['stock'];
  $price = $_POST['price'];


  $update_query = "UPDATE product SET 
                  product_name = '$product_name',
                  category_id = '$category_id',
                  brand_id = '$brand_id',
                  stock = '$stock',
                  price = '$price'
                  WHERE product_id = $product_id";

  $update_result = mysqli_query($conn, $update_query);

  if($update_result){
    header("Location: index.php");
  } else {
      echo "Error updating product: " . mysqli_error($conn);
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>Edit Product</title>
</head>
<body class="p-4">

    <form action="" method="POST" class="max-w-md mx-auto bg-white p-8 rounded-md shadow-md">

        <input type="hidden" name="product_id" value="<?php echo $user_data['product_id']; ?>">

        <div class="mb-4">
            <label for="product_name" class="block text-gray-700 font-bold mb-2">Product Name:</label>
            <input type="text" name="product_name" id="product_name" value="<?php echo $user_data['product_name']; ?>" class="border-2 border-gray-300 p-2 w-full rounded-md" required>
        </div>

        <div class="mb-4">
    <label for="category" class="block text-gray-700 font-bold mb-2">Category:</label>
    <select name="category" id="category" class="w-full border rounded-md py-2 px-3 focus:outline-none focus:border-blue-500">
        <option value="" disabled>Select Category</option>
        <?php
        while ($row_category = mysqli_fetch_assoc($result_categories)) {
            $selected = ($row_category['category_id'] == $user_data['category_id']) ? 'selected' : '';
            echo "<option value='" . $row_category['category_id'] . "' $selected>" . $row_category['category_name'] . "</option>";
        }
        ?>
    </select>
</div>


<div class="mb-4">
    <label for="brand_id" class="block text-gray-700 font-bold mb-2">Brand:</label>
    <select name="brand_id" id="brand_id" class="w-full border rounded-md py-2 px-3 focus:outline-none focus:border-blue-500">
        <option value="" disabled>Select Brand</option>
        <?php
        // Loop through brands to generate options
        while ($row_brand = mysqli_fetch_assoc($result_brand)) {
            $selected = ($row_brand['brand_id'] == $user_data['brand_id']) ? 'selected' : '';
            echo "<option value='" . $row_brand['brand_id'] . "' $selected>" . $row_brand['brand_name'] . "</option>";
        }
        ?>
    </select>
</div>

        <div class="mb-4">
            <label for="stock" class="block text-gray-700 font-bold mb-2">Stock:</label>
            <input type="number" name="stock" id="stock" value="<?php echo $user_data['stock']; ?>" class="border-2 border-gray-300 p-2 w-full rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="price" class="block text-gray-700 font-bold mb-2">Price:</label>
            <input type="number" name="price" id="price" value="<?php echo $user_data['price']; ?>" class="border-2 border-gray-300 p-2 w-full rounded-md" required>
        </div>

        <button type="submit" name="update" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Product</button>

    </form>

</body>
</html>
