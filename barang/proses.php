<?php
$currentDateTime = date('Y-m-d_H-i-s');
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=barang_table_ $currentDateTime.xls");
?>
<table border="1" cellpadding="5">
	<tr>
		<th>No</th>
		<th>Brand</th>
		<th>Jenis</th>
		<th>Nama Product</th>
		<th>Stock</th>
	</tr>
	<?php
	// Load file koneksi.php
	include "../config.php";
	
	// Buat query untuk menampilkan semua data siswa
	$sql = mysqli_query($conn, "SELECT * FROM product");
	
	 while ($row = mysqli_fetch_assoc($sql)) :

        ?>
        <tr>
            <td class="border px-4 py-2"><?= $row['product_id']; ?></td>
            <td class="border px-4 py-2"><?= $row['category_id']; ?></td>
            <td class="border px-4 py-2"><?= $row['brand_id']; ?></td>
            <td class="border px-4 py-2"><?= $row['product_name']; ?></td>
            <td class="border px-4 py-2"><?= $row['stock']; ?></td>
        </tr>
    <?php endwhile; ?>
</table>