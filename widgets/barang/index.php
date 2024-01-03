<?php

$sqlcount = "SELECT COUNT(*) FROM product";
$resultcount = mysqli_query($conn, $sqlcount);

if ($resultcount) {
    $row = mysqli_fetch_array($resultcount);
    $totalRows = $row[0]; // Retrieve the count
} else {
    echo "Error: " . mysqli_error($conn);
}

$sql_product = "SELECT product_name, stock FROM product";
$result_product = mysqli_query($conn, $sql_product);

$products = [];
while ($row_product = mysqli_fetch_assoc($result_product)) {
    $products[] = $row_product;
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"> </script>
    <title>Barang Stock</title>
  </head>
  <body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="w-full h-full max-w-screen-md">
      <canvas id="doughnutChart" class="w-full h-full"></canvas>
    </div>

    <script>
      // Extract product names and stock levels from PHP
      var productNames = <?php echo json_encode(array_column($products, 'product_name')); ?>;
      var stockLevels = <?php echo json_encode(array_column($products, 'stock')); ?>;

      // Doughnut Chart configuration
      var ctx = document.getElementById("doughnutChart").getContext("2d");
      var myDoughnutChart = new Chart(ctx, {
        type: "doughnut",
        data: {
          labels: productNames,
          datasets: [
            {
              data: stockLevels,
              backgroundColor: [
                "#4CAF50", "#FF5733", "#3498db", "#e74c3c", "#2ecc71", "#f39c12",
              ],
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          title: {
            display: true,
            text: "Item Stock"
         },
          legend: {
            position: "top",
          },
        },
      });
    </script>
  </body>
</html>
