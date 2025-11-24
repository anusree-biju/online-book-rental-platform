<?php
include '../db/connection.php'; // replace with your DB config
if(isset($_GET['id'])){
    $bid=$_GET['id'];
    mysqli_query($con,"UPDATE book_tb SET approval_status = 'rejected' WHERE book_tb.bid = $bid");
    header("location: index3.php");
}
?>