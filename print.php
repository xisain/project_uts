<?php
$currendate = date("Y-m-d-H-i-s");
require("config.php");

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
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql_product = "SELECT order_id, account_id, product_id, customer_id, order_date, quantity, total FROM ordertable WHERE order_id = $id";
    $result_product = mysqli_query($conn, $sql_product);
    if ($result_product) {
        $orderData = mysqli_fetch_assoc($result_product);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
    <title>PRINT Transaksi | <?=$orderData['order_id']."-".getProduct($conn, $orderData['product_id']) ."-". getBuyer($conn,$orderData['customer_id'])?></title>
</head>
<body class="p-4">
    <?php
   
       
    ?>
            <div class="max-w-md mx-auto bg-white p-8 shadow-md">
                <h1 class="text-2xl font-bold mb-4">Order Details</h1>
                <table class="w-full">
                    <tr>
                        <th class="py-2">Order ID</th>
                        <td class="py-2"><?php echo $orderData['order_id']; ?></td>
                    </tr>
                    <tr>
                        <th class="py-2">Product</th>
                        <td class="py-2"><?= getProduct($conn, $orderData['product_id'])?></td>
                    </tr>
                    <tr>
                        <th class="py-2">Customer</th>
                        <td class="py-2"><?php echo getBuyer($conn,$orderData['customer_id']); ?></td>
                    </tr>
                    <tr>
                        <th class="py-2">Cashier</th>
                        <td class="py-2"><?php echo getCashierrById($conn,$orderData['account_id']); ?></td>
                    </tr>
                    <tr>
                        <th class="py-2">Quantity</th>
                        <td class="py-2"><?php echo $orderData['quantity']; ?></td>
                    </tr>
                    <tr>
                        <th class="py-2">Total</th>
                        <td class="py-2"><?php echo number_format($orderData['total'], 0, ',', '.'); ?></td>
                    </tr>
                    <!-- Add more fields as needed -->
                </table>
            </div>
    <?php
        } else {
            echo "Error fetching order details.";
        }
    }
    ?>
    <script>
        window.print();
    </script>
</body>
</html>