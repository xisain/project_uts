<?php
require('../config.php');
$sql = "SELECT customer_id, customer_name, jenis_kelamin, nomor_telepon, address  FROM customer";
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
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>Customer</title>
</head>

<body class="bg-gray-100">
<header class="text-gray-600 body-font">
      <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
        <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0" href="../index.php">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10 text-white p-2 bg-indigo-500 rounded-full" viewBox="0 0 24 24">
            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
          </svg>
          <span class="ml-3 text-xl">SAIN SHOP</span>
        </a>
        <nav class="md:ml-auto flex flex-wrap items-center text-base justify-center">
          <a class="mr-5 hover:text-gray-900" href="../barang/view.php">Barang</a>
          <a class="mr-5 hover:text-gray-900 active" href="#">Customer</a>
          <a class="mr-5 hover:text-gray-900"href="../user/view.php">User</a>
          
        </nav>
        <button onclick="logout()" class="inline-flex items-center bg-gray-100 border-0 py-1 px-3 focus:outline-none hover:bg-gray-200 rounded text-base mt-4 md:mt-0">
    Logout
    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-1" viewBox="0 0 24 24">
        <path d="M5 12h14M12 5l7 7-7 7"></path>
    </svg>
</button>
      </div>
    </header>
    <div class="container mx-auto p-8">
    <a href="add.php" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
            Add User
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
        <table id="example" class="table-auto min-w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2">Customer ID</th>
                    <th class="px-4 py-2">Customer Name</th>
                    <th class="px-4 py-2">Jenis Kelamin</th>
                    <th class="px-4 py-2">Nomor Telepon</th>
                    <th class="px-4 py-2">Address</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) :
                    $cust_name = $row['customer_name'];
                    $cust_id = $row['customer_id'];
                    $cust_gender =  $row['jenis_kelamin'];
                    $cust_nomor_telepon = $row['nomor_telepon'];
                    $cust_address = $row['address'];
                    $gender = ($cust_gender == 1) ? 'Perempuan' : 'Laki-laki'; 
                    ?>
                    <tr>
                        <td class="border px-4 py-2"><?= $cust_id; ?></td>
                        <td class="border px-4 py-2"><?= $cust_name; ?></td>
                        <td class="border px-4 py-2"><?= $gender; ?></td>
                        <td class="border px-4 py-2"><?= $cust_nomor_telepon; ?></td>
                        <td class="border px-4 py-2"><?= $cust_address; ?></td>
                        <td class="border px-4 py-2">
                        <a href='edit.php?id=<?= $cust_id; ?>' class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                        <a href='delete.php?id=<?=$cust_id;?>' class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <canvas id="genderChart" width="400" height="200"></canvas>
    </div>

    <script>
        $(document).ready(function () {
        // Initialize DataTable
        $('#example').DataTable();

        // Fetch gender data for the chart
        let genderData = <?php
            $maleCount = 0;
            $femaleCount = 0;
            mysqli_data_seek($result, 0); // Reset pointer to the beginning
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['jenis_kelamin'] == 0) {
                    $maleCount++;
                } else {
                    $femaleCount++;
                }
            }
            echo json_encode([$maleCount, $femaleCount]);
        ?>;

        // Create a bar chart
        var ctx = document.getElementById('genderChart').getContext('2d');
        var genderChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    label: "Gender",
                    data: genderData,
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

      $('#toggleWidget').click(function () {
            // Toggle the visibility of the chart
            var chartContainer = $('#genderChart');
            chartContainer.toggle();
        });
    });
    </script>
</body>

</html>
