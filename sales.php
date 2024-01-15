<?php
require("config.php");
session_start();
$sql_prod = "Select * from ordertable";
$result = mysqli_query($conn, $sql_prod);

if (!isset($_SESSION['username'])) {
    header("Location: login.php");

   
}

function setOrderID($number) {
    if ($number < 10) {
        return "TRS" . sprintf("%04d", $number);
    } elseif ($number < 100) {
        return "TRS" . sprintf("%03d", $number);
    } elseif ($number < 1000) {
        return "TRS" . sprintf("%02d", $number);
    } elseif ($number < 10000) {
        return "TRS" . sprintf("%01d", $number);
    } else {
        return "TRS" . $number;
    }
}
if (isset($_POST["submit"])) {
    // // Retrieve account_id from session
    $accountId = $_SESSION["account_id"];

    // Retrieve form data
    $productId = $_POST["item"];
    $quantity = $_POST["quantity"];
    $totalPrice = $_POST["total_price"];
    $customerId = $_POST["customer"];

   

    // You may need to adjust the column names and data types based on your database schema
    $sql = "INSERT INTO `ordertable`(`account_id`, `customer_id`, `product_id`, `order_date`, `quantity`, `total`) 
            VALUES ('$accountId', '$customerId', '$productId', NOW(), '$quantity', '$totalPrice')";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
       header('location:index.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    
}


$sql_product = "SELECT * FROM product";
$result_product = mysqli_query($conn, $sql_product);
$sql_cust = "SELECT customer_id, customer_name FROM customer";
$result_cust = mysqli_query($conn, $sql_cust);

function getCashierrById($mysqli, $userId) {
    $query = "SELECT username FROM account WHERE account_id = $userId";
    $userData = mysqli_query($mysqli, $query);
    $userData = mysqli_fetch_array($userData);
    return $userData['username'];

}

function getProduct($conn, $productId) {
    $query = "Select product_name from product where product_id = $productId";
    $productData = mysqli_query($conn, $query);
    $productData = mysqli_fetch_array($productData);
    return $productData['product_name'];
}
function getBuyer($conn, $custtId) {
    $query = "Select customer_name from customer where customer_id = $custtId";
    $custtData = mysqli_query($conn, $query);
    $custtData = mysqli_fetch_array($custtData);
    return $custtData['customer_name'];
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
    <script>

 
</script>
    <title>Transaksi</title>
</head>
<body>

<!-- Header -->
<header class="text-gray-600 body-font transition duration-300 ease-in-out fixed top-0 w-full bg-white z-50 shadow-md sticky top-0">
      <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
        <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0" href="index.php">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10 text-white p-2 bg-indigo-500 rounded-full" viewBox="0 0 24 24">
            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
          </svg>
          <span class="ml-3 text-xl">SAIN SHOP</span>
        </a>
        <nav class="md:ml-auto flex flex-wrap items-center text-base justify-center">
          <a class="mr-5 hover:text-gray-900" href="./barang/">Barang</a>
          <a class="mr-5 hover:text-gray-900" href="./customer/view.php">Customer</a>
          <a class="mr-5 hover:text-gray-900"href="./user/view.php">User</a>
          
        </nav>
        <button onclick="logout()" class="inline-flex items-center bg-gray-100 border-0 py-1 px-3 focus:outline-none hover:bg-gray-200 rounded text-base mt-4 md:mt-0">
    Logout
    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-1" viewBox="0 0 24 24">
        <path d="M5 12h14M12 5l7 7-7 7"></path>
    </svg>
</button>
      </div>
    </header>
<!-- End Of Header -->

<!-- Body -->
<div class="container px-5 py-24 mx-auto">
    <h2>Welcome, <?=$_SESSION['username']?></h2>
    <div class="grid grid-cols-4 gap-4">

        <div class=" p-4 col-span-3 rounded-lg">
            <!-- Grid of Cards -->
          
                <table id="example" class="table-auto min-w-full bg-white border border-gray-300 shadow-lg">
                    <thead>
                    <tr>
                        <th class="px-4 py-2">Order ID</th>
                        <th class="px-4 py-2">Cashier</th>
                        <th class="px-4 py-2">Order Date</th>
                        <th class="px-4 py-2">Customer</th>
                        <th class="px-4 py-2">Product</th>
                        <th class="px-4 py-2">Total</th>
                        <th class="px-4 py-2"><center>Action</center></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) : 
                       
                        ?>
                        <tr>
                            <td class="border px-4 py-2"><a href="print.php?id=<?=$row['order_id']?>" class="text-decoration-line: underline;" ><?= setOrderID($row['order_id']); ?></a></td>
                            <td class="border px-4 py-2"><?= getCashierrById($conn,$row['account_id']) ?></td>
                            <td class="border px-4 py-2"><?= $row['order_date']; ?></td>
                            <td class="border px-4 py-2"><?= getProduct($conn,$row['product_id']); ?></td>
                            <td class="border px-4 py-2"><?= getBuyer($conn,$row['customer_id']); ?></td>
                            <td class="border px-4 py-2"><?= $row['total']; ?></td>
                            <td class="border px-4 py-2"><center>
                            <a href='edit_product.php?id=<?= $row['order_id']; ?>' class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                        <a href='delete_product.php?id=<?= $row['order_id']; ?>' class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="">Delete</a>
                            
                        </center>
                            </td>
                        </tr>
                        
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <div class="container p-4 bg-gray-100 rounded-lg">
        <form action="" method="post" class="max-w-sm mx-auto" id="orderForm">
            <!-- Input Group for Customer Name -->
            <div class="mb-4">
                <label for="customer" class="block text-gray-700 text-sm font-bold mb-2">Customer Name</label>
                <select name="customer" id="customer" class="w-full border rounded-md py-2 px-3 focus:outline-none focus:border-blue-500">
                    <?php
                    while($data = mysqli_fetch_assoc($result_cust)){
                        echo "<option value='". $data['customer_id']."'>".$data['customer_name']."</option>";

                    }
                    
                    ?>
                </select>
            </div>
            <!-- Input Group for Item -->
            <div class="mb-4">
                <label for="item" class="block text-gray-700 text-sm font-bold mb-2">Item</label>
                <select name="item" id="item" class="w-full border rounded-md py-2 px-3 focus:outline-none focus:border-blue-500" onchange="updatePrice()">
                    <option value="" disabled selected>Select Product</option>
                    <?php
                        // Loop through products to generate options
                        while ($row_product = mysqli_fetch_assoc($result_product)) {
                            echo "<option value='" . $row_product['product_id'] . "' data-price='" . $row_product['price'] . "'>" . $row_product['product_name'] . "</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="quantity" class="block text-gray-700 text-sm font-bold mb-2">Quantity</label>
                <input type="quantity" name="quantity" id="quantity" class="w-full border rounded-md py-2 px-3 focus:outline-none focus:border-blue-500" oninput="updatePrice()">
            </div>
            <div class="mb-4">
                <label for="total_price" class="block text-gray-700 text-sm font-bold mb-2">Total Price</label>
                <input type="text" name="total_price" id="total_price" class="w-full border rounded-md py-2 px-3 focus:outline-none focus:border-blue-500" readonly>
            </div>  
            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" name="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md focus:outline-none hover:bg-blue-600">Proses</button>
            </div>
        </form>
    </div>
    </div>
</div>
<!-- End of Body -->

<!-- Footer -->
<footer class="text-gray-600 body-font">
    <!-- ... Your existing footer code ... -->
</footer>
<!-- End Of Footer -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
<script>

    $(document).ready(function () {
        $('#example').DataTable({
            "lengthMenu": [5, 10, 25, 50],
            "pageLength": 10, // Default number of rows per page
        });
    });
    function updatePrice() {
            // Get selected product price and quantity
            var selectedProduct = document.getElementById('item');
            var productPrice = selectedProduct.options[selectedProduct.selectedIndex].getAttribute('data-price');
            var quantity = document.getElementById('quantity').value;

            // Calculate total price
            var totalPrice = productPrice * quantity;

            // Update the total price input field
            document.getElementById('total_price').value = totalPrice;
        }
        function logout() {
        // Redirect to logout.php
        window.location.href = 'logout.php';
    }

     

</script>
</body>
</html>
