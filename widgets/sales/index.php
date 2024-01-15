<?php
include("config.php");



// Total item SOLD
$query_itemsold = "SELECT SUM(quantity) AS total_item from ordertable";
$result_item = mysqli_query($conn, $query_itemsold); 

if($result_item) { 
    $row = mysqli_fetch_assoc($result_item);
    $totalItem = $row['total_item'];
}

// Today Revenue
$sql = "SELECT SUM(total) AS total_sum FROM `ordertable` WHERE DAY(order_date) = DAY(NOW()) AND MONTH(order_date) = MONTH(NOW()) AND YEAR(order_date) = YEAR(NOW());";
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalSum = $row['total_sum'];

    // Format the total sum as Rupiah
    $formatted_total_sum_today = "Rp " . number_format($totalSum, 0, ',', '.');


} else {
    echo "Error in the query: " . mysqli_error($conn);
}



// Total Revenue
$sql = "SELECT SUM(total) AS total_sum FROM ordertable";
$result_total = mysqli_query($conn, $sql);
if($result_total){
    $row = mysqli_fetch_assoc($result_total);
    $total_Sum = $row['total_sum']; 
    $formatted_total_sum = "Rp " . number_format($total_Sum, 0, ',', '.');
   

}



$sqlsales = "SELECT YEAR(order_date) AS order_year, MONTH(order_date) AS order_month, SUM(total) AS total_quantity FROM ordertable GROUP BY order_year, order_month";
$resultsales = mysqli_query($conn, $sqlsales);

$chartData = [];
while ($row = mysqli_fetch_assoc($resultsales)) {
    $monthYear = $row['order_year'] . '-' . str_pad($row['order_month'], 2, '0', STR_PAD_LEFT); // Format as YYYY-MM
    $chartData['labels'][] = $monthYear;
    $chartData['data'][] = $row['total_quantity'];
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

   
    <!-- Your chart container -->
    <div style="width:60%; margin: auto;">
    <div class="flex justify-center items-center width:80%">
        <div class="box border border-gray-300 rounded-lg p-4 m-4 text-center">
            <h1>Total Item Sold </h1>
            <h1><?= $totalItem ?></h1>
        </div>

        <div class="box border border-gray-300 rounded-lg p-4 m-4 text-center">
            <h1>Today Sale</h1>
            <p><?= $formatted_total_sum_today ?></p>
        </div>

        <div class="box border border-gray-300 rounded-lg p-4 m-4 text-center">
            <h1>Total Revenue</h1>
            <p><?= $formatted_total_sum ?></p>
        </div>
    </div>
    <br>
    <center> <h1 class="">Product Sale By Month</h1></center>
       

        <canvas id="myBarChart"></canvas>
    </div>

  

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Get the data from the PHP script
        const chartData = <?php echo $chartDataJson; ?>;

        // Create arrays for labels and datasets
        const labels = chartData.labels;
        const datasets = [{
            label: 'Total Earnings',
            data: chartData.data,
            backgroundColor: `rgba(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, 0.7)`,
            borderColor: `rgba(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, 1)`,
            borderWidth: 1,
        }];

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
