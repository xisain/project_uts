<?php
require('../config.php');
if (isset($_GET['id'])) {
    $account_id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM account WHERE account_id=$account_id");
    $account_data = mysqli_fetch_array($result);
}
if(isset($_POST['update'])){
    $userid = $_GET['id'];
    $account_name = $_POST['account_name'];
    
    $update_query = "UPDATE account SET 
                    username = '$account_name' WHERE account_id = $userid";

    $update_result = mysqli_query($conn, $update_query);

    if($update_result){
        header("Location: view.php");
    } else {
        echo "Error updating customer: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css"
      rel="stylesheet"
    />
    <title>Edit User</title>
  </head>
  <body>
  <form action="" method="POST" class="max-w-md mx-auto bg-white p-8 rounded-md shadow-md">

<div class="mb-4">
    <label for="account_id" class="block text-gray-600 font-bold">Customer ID</label>
    <input type="number" name="account_id" id="account_id" value="<?= $account_data['account_id'] ?>" class="w-full p-2 border rounded-md" disabled>
</div>

<div class="mb-4">
    <label for="account_name" class="block text-gray-600 font-bold">Customer Name</label>
    <input type="text" name="account_name" id="account_name" value="<?= $account_data['email'] ?>" class="w-full p-2 border rounded-md">
</div>
<div class="mb-4">
    <label for="account_name" class="block text-gray-600 font-bold">Customer Name</label>
    <input type="text" name="account_name" id="account_name" value="<?= $account_data['username'] ?>" class="w-full p-2 border rounded-md">
</div>
<button type="submit" name="update" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Customer</button>

</form>
  </body>
</html>