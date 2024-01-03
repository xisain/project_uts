<?php
require('../config.php');
if (isset($_GET['id'])) {
    $UserID = $_GET['id'];
    $result = mysqli_query($conn, "Delete FROM product WHERE product_id=$UserID");
    header("Location: index.php");
}
?>