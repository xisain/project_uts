<?php
// Load file koneksi.php
include "../config.php";

// Load file autoload.php
require '../vendor/autoload.php';

// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

if(isset($_POST['import'])){ 
	$nama_file_baru = $_POST['namafile'];
    $path = 'tmp/' . $nama_file_baru; 

    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    $spreadsheet = $reader->load($path); // Load file yang tadi diupload ke folder tmp
    $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

	$numrow = 1;
	foreach($sheet as $row){
		
		$nama = $row['B']; 
		$jenis_kelamin = $row['C'];
		$telp = $row['D']; 
		$alamat = $row['E'];
		$price = $row['F'];

		if($numrow > 1){
			$query = "INSERT INTO product (category_id, brand_id, product_name, stock,price) VALUES ( '$nama', '$jenis_kelamin', '$telp', '$alamat', '$price')";

			mysqli_query($conn, $query);
		}

		$numrow++; // Tambah 1 setiap kali looping
	}	

    unlink($path); 
}
header('location: ./'); // Redirect ke halaman awal
