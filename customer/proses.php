<?php
$currentDateTime = date('Y-m-d_H-i-s');
$filename= basename(getcwd()). "_table_" . $currentDateTime;
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=$filename.xls");

?>
<table border="1" cellpadding="5">
	<tr>
		<th>Customer ID</th>
		<th>Customer Name</th>
		<th>Jenis kelamin</th>
		<th>nomor_telepon</th>
		<th>Alamat</th>
	</tr>
	<?php
	// Load file koneksi.php
	include "../config.php";
	
	// Buat query untuk menampilkan semua data siswa
	$sql = mysqli_query($conn, "SELECT customer_id, customer_name, jenis_kelamin, nomor_telepon, address  FROM customer");
	
	 while ($row = mysqli_fetch_assoc($sql)) :

        ?>
        <tr>
            <td class="border px-4 py-2"><?= $row['customer_id']; ?></td>
            <td class="border px-4 py-2"><?= $row['customer_name']; ?></td>
            <td class="border px-4 py-2"><?= $row['jenis_kelamin']; ?></td>
            <td class="border px-4 py-2"><?= $row['nomor_telepon']; ?></td>
            <td class="border px-4 py-2"><?= $row['address']; ?></td>
        </tr>
    <?php endwhile; ?>
</table>