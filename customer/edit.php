<?php
require('../config.php');

if (isset($_GET['id'])) {
    $customer_id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT customer_id, customer_name, jenis_kelamin, nomor_telepon, address  FROM customer WHERE customer_id=$customer_id");
    $customer_data = mysqli_fetch_array($result);
}

if (isset($_POST['update'])) {
    $customerid = $_GET['id'];
    $customer_name = $_POST['customer_name'];

    $update_query = "UPDATE customer SET 
                    customer_name = '$customer_name' WHERE customer_id = $customerid";

    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
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

<body class="p-10 ">
<h1 class="font-bold max-w-md mx-auto">Form Edit Customers</h1>
    <form action="" method="POST" class="max-w-md mx-auto bg-white p-5 rounded-md shadow-md ">
        
        <div class="mb-4">
            <label for="customer_id" class="block text-gray-600 font-bold">Customer ID</label>
            <input type="number" name="customer_id" id="customer_id" value="<?= $customer_data['customer_id'] ?>" class="w-full p-2 border rounded-md" disabled>
        </div>

        <div class="mb-4">
            <label for="customer_name" class="block text-gray-600 font-bold">Customer Name</label>
            <input type="text" name="customer_name" id="customer_name" value="<?= $customer_data['customer_name'] ?>" class="w-full p-2 border rounded-md">
        </div>
        <div class="mb-4">
            <label for="gender" class="block text-gray-600 font-bold">Gender</label>
            <select name="gender" id="gender" class="w-full p-2 border rounded-md">
                <option value="0" <?= $customer_data['jenis_kelamin'] == 0 ? 'selected' : '' ?>>Laki Laki</option>
                <option value="1" <?= $customer_data['jenis_kelamin'] == 1 ? 'selected' : '' ?>>Perempuan</option>
            </select>
            </select>

        </div>

        <div class="mb-4">
            <label for="nomor_telepon" class="block text-gray-600 font-bold">No Telp</label>
            <input type="text" name="nomor_telepon" id="nomor_telepon" value="<?= $customer_data['nomor_telepon'] ?>" class="w-full p-2 border rounded-md">
        </div>

        <div class="mb-4">
            <label for="address" class="block text-gray-600 font-bold">Addres</label>
            <input type="text" name="address" id="address" value="<?= $customer_data['address'] ?>" class="w-full p-2 border rounded-md">
        </div>
        <div class="action">
        <button type="submit" name="update" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Customer</button>
        <a href="view.php" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Back</a
        </div>
       
        
    </form>

</body>

</html>