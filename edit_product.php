<?php
require('config.php');

if (isset($_GET['id'])) {
    $UserID = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM product WHERE product_id=$UserID");
    $user_data = mysqli_fetch_array($result);
}
if(isset($_POST['update'])){
  $product_id = $_POST['product_id'];
  $product_name = $_POST['product_name'];
  $category_id = $_POST['category_id'];
  $brand_id = $_POST['brand_id'];
  $stock = $_POST['stock'];
  $price = $_POST['price'];

  // Update the product information in the database
  $update_query = "UPDATE product SET 
                  product_name = '$product_name',
                  category_id = '$category_id',
                  brand_id = '$brand_id',
                  stock = '$stock',
                  price = '$price'
                  WHERE product_id = $product_id";

  $update_result = mysqli_query($conn, $update_query);

  if($update_result){
      echo "Product updated successfully.";
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

    <form action="edit_product.php" method="POST" class="max-w-md mx-auto bg-white p-8 rounded-md shadow-md">

        <input type="hidden" name="product_id" value="<?php echo $user_data['product_id']; ?>">

        <div class="mb-4">
            <label for="product_name" class="block text-gray-700 font-bold mb-2">Product Name:</label>
            <input type="text" name="product_name" id="product_name" value="<?php echo $user_data['product_name']; ?>" class="border-2 border-gray-300 p-2 w-full rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="category_id" class="block text-gray-700 font-bold mb-2">Category ID:</label>
            <input type="text" name="category_id" id="category_id" value="<?php echo $user_data['category_id']; ?>" class="border-2 border-gray-300 p-2 w-full rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="brand_id" class="block text-gray-700 font-bold mb-2">Brand ID:</label>
            <input type="text" name="brand_id" id="brand_id" value="<?php echo $user_data['brand_id']; ?>" class="border-2 border-gray-300 p-2 w-full rounded-md" required>
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
