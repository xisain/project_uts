<?php
require('./config.php');
if (isset($_GET['id'])) {
    $UserID = $_GET['id'];
    $result = mysqli_query($conn, "Delete FROM ordertable WHERE order_id=$UserID");
    header("Location: index.php");
}
?>
