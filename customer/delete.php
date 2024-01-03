<?php
require('../config.php');
if (isset($_GET['id'])) {
    $UserID = $_GET['id'];
    $result = mysqli_query($conn, "Delete FROM customer WHERE customer_id=$UserID");
    header("Location: view.php");
}
?>