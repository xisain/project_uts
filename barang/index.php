<?php
require('../config.php');
$sql = "SELECT * FROM product";
$result = mysqli_query($conn, $sql);

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" integrity="sha512-o6qFk2dQgK6v1MkNXZGUlTTd7T2PsvpZKP97Kb8CTQ1oLJSta5BZsb3IbQdz0Jh6KuJwPIER5I4S3g7JHFw+5g==" crossorigin="anonymous" />

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
         .hidden {
            display: none;
        }
    </style>
    <title>Item Storage</title>
</head>

<body class="bg-gray-100">
<nav class="text-gray-600 body-font transition duration-300 ease-in-out fixed top-0 w-full bg-white z-50 shadow-md sticky top-0">
      <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
        <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0" href="../index.php">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10 text-white p-2 bg-indigo-500 rounded-full" viewBox="0 0 24 24">
            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
          </svg>
          <span class="ml-3 text-xl">SAIN SHOP</span>
        </a>
        <nav class="md:ml-auto flex flex-wrap items-center text-base justify-center">
          <a class="mr-5 hover:text-gray-900" href="./barang/view.php">Barang</a>
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
    </nav>
    <div class="container mx-auto p-8">



    
       <div class="animate__animated animate__fadeIn__delay-2s">
       <a href="add.php" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
            Add Product
        </a>
        <button id="toggleWidget" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
            Toggle Chart
        </button>
        <a href="form.php" class="bg-violet-500 hover:bg-violet-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
            Import
        </a>
        <a href="proses.php" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
            Export
        </a>
       </div>
       
        <table id="example" class="table-auto min-w-full">
            <thead class="">
                <tr>
                    <th class="px-4 py-2">Product ID</th>
                    <th class="px-4 py2">Product Brand</th>
                    <th class="px-4 py2">Product Type</th>
                    <th class="px-4 py-2">Product Name</th>
                    <th class="px-4 py-2">Stock</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) :
                    $brand_id = $row['brand_id']; 
                    $brand_query = "SELECT brand_name FROM brand WHERE brand_id = $brand_id";
                    $brand_result = mysqli_query($conn, $brand_query);
                    $brand_row = mysqli_fetch_assoc($brand_result);
                    $brand_name = $brand_row ? $brand_row['brand_name'] : '';

                    $category_id = $row['category_id'];
                    $category_query = "SELECT category_name FROM category WHERE category_id = $category_id";
                    $category_result = mysqli_query($conn, $category_query);
                    $category_row = mysqli_fetch_assoc($category_result);
                    $category_name = $category_row ? $category_row['category_name'] : '';
                    
                    ?>
                    <tr>
                        <td class="border px-4 py-2"><?= $row['product_id']; ?></td>
                        <td class="border px-4 py-2"><?= $brand_name; ?></td>
                        <td class="border px-4 py-2"><?= $category_name; ?></td>
                        <td class="border px-4 py-2"><?= $row['product_name']; ?></td>
                        <td class="border px-4 py-2"><?= $row['stock']; ?></td>
                        <td class="border px-4 py-2">
                        <a href='edit.php?id=<?= $row['product_id']; ?>' class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                        <a href='delete.php?id=<?= $row['product_id']; ?>' class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div id="widgetContainer" class="h-screen flex items-center justify-center hidden">
            <?php
            include("../widgets/barang/index.php");
            ?>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
        // script for chart
        document.addEventListener("DOMContentLoaded", function () {
            var widgetContainer = document.getElementById("widgetContainer");
            var toggleWidgetButton = document.getElementById("toggleWidget");

            toggleWidgetButton.addEventListener("click", function () {
                console.log("work")
                if (widgetContainer.classList.contains("hidden")) {
                    widgetContainer.classList.remove("hidden");
                } else {
                    widgetContainer.classList.add("hidden");
                }
            });
        });
    </script>
</body>

</html>
