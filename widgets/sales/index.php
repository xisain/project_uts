<?php
include("../../config.php");
$sqlproduct = "SELECT product_id, product_name FROM product";
$resultproduct = mysqli_query($conn, $sqlproduct);

$sqlsales = "SELECT MONTH(order_date) AS month, SUM(quantity) AS total_quantity, product_id FROM ordertable GROUP BY MONTH(order_date), product_id";
$resultsales = mysqli_query($conn, $sqlsales);

$chartData = [];
while ($row = mysqli_fetch_assoc($resultsales)) {
    $chartData[$row['product_id']]['labels'][] = date('F', mktime(0, 0, 0, $row['month'], 1));
    $chartData[$row['product_id']]['data'][] = $row['total_quantity'];
}

$chartDataJson = json_encode($chartData);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Bar Chart Example</title>
</head>
<body>
    <h1>Bar Chart Example</h1>

    <!-- Your chart container -->
    <div style="width: 80%; margin: auto;">
        <canvas id="myBarChart"></canvas>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Get the data from the PHP script
            const chartData = <?php echo $chartDataJson; ?>;

            // Get product names for legend labels
            const productNames = <?php echo json_encode(mysqli_fetch_all($resultproduct, MYSQLI_ASSOC)); ?>;
            const legendLabels = productNames.map(product => `Product ${product.product_id} - ${product.product_name}`);

            // Create arrays for labels and datasets
            const labels = chartData[Object.keys(chartData)[0]].labels;
            const datasets = Object.keys(chartData).map(productId => {
                return {
                    label: legendLabels[productId - 1], // Subtracting 1 as product_id starts from 1
                    data: chartData[productId].data,
                    backgroundColor: `rgba(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, 0.7)`,
                    borderColor: `rgba(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, 1)`,
                    borderWidth: 1,
                };
            });

            // Create the bar chart
            const ctx = document.getElementById("myBarChart").getContext("2d");
            const myBarChart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: datasets,
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                },
            });
        });
    </script>
</body>
</html>
