<?php
require('../config.php');

if (isset($_POST["submit"])) {
    // Retrieve form data
    $customer_name = $_POST['customer_name'];

    // Use prepared statement to avoid SQL injection
    $sql_insert = "INSERT INTO customer (customer_name) VALUES (?)";
    
    // Create a prepared statement
    $stmt = mysqli_prepare($conn, $sql_insert);
    
    // Bind the parameter
    mysqli_stmt_bind_param($stmt, "s", $customer_name);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        header("location:view.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <title>Add Customer</title>
  </head>
  <body class="bg-gray-100">

    <div class="container mx-auto my-8 p-8 bg-white shadow-lg rounded-lg">
        <h1 class="text-2xl font-bold mb-8">Add Customer</h1>
        <form action="" method="post">
            <div class="mb-4">
                <label for="customer_name" class="block text-gray-600 font-bold">Customer Name</label>
                <input type="text" name="customer_name" id="customer_name" class="w-full p-2 border rounded-md">
            </div>

            <button type="submit" name="submit" class="bg-blue-500 text-white p-2 rounded-md hover:bg-blue-700">Submit</button>
        </form>
    </div>

  </body>
</html>
