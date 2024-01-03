<?php
require('../config.php');

if (isset($_GET['id'])) {
    $customer_id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT customer_id,customer_name FROM customer WHERE customer_id=$customer_id");
    $customer_data = mysqli_fetch_array($result);
}

if(isset($_POST['update'])){
    $customerid = $_GET['id'];
    $customer_name = $_POST['customer_name'];
    
    $update_query = "UPDATE customer SET 
                    customer_name = '$customer_name' WHERE customer_id = $customerid";

    $update_result = mysqli_query($conn, $update_query);

    if($update_result){
        header("Location: view.php");
    } else {
        echo "Error updating customer: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>Edit Customer</title>
</head>
<body class="p-4">

    <form action="" method="POST" class="max-w-md mx-auto bg-white p-8 rounded-md shadow-md">

        <div class="mb-4">
            <label for="customer_id" class="block text-gray-600 font-bold">Customer ID</label>
            <input type="number" name="customer_id" id="customer_id" value="<?= $customer_data['customer_id'] ?>" class="w-full p-2 border rounded-md" disabled>
        </div>

        <div class="mb-4">
            <label for="customer_name" class="block text-gray-600 font-bold">Customer Name</label>
            <input type="text" name="customer_name" id="customer_name" value="<?= $customer_data['customer_name'] ?>" class="w-full p-2 border rounded-md">
        </div>

        <button type="submit" name="update" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Customer</button>

    </form>

</body>
</html>
