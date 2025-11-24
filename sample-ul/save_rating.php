<?php
session_start();
include '../db/connection.php';

if (!isset($_SESSION['uid'])) {
    echo "User not logged in";
    exit();
}

$uid = $_SESSION['uid'];
$bid = isset($_POST['bid']) ? intval($_POST['bid']) : 0;
$rate = isset($_POST['rating']) ? intval($_POST['rating']) : 0;

if ($bid > 0 && $rate >= 1 && $rate <= 5) {
    // Check if feedback already exists
    $check = mysqli_query($con, "SELECT * FROM feedback_tb WHERE uid='$uid' AND bid='$bid'");
    if (mysqli_num_rows($check) > 0) {
        echo "Already rated";
    } else {
        $date = date('Y-m-d'); // Get current date in YYYY-MM-DD

        $sql = "INSERT INTO feedback_tb (uid, bid, rating, feedback_date) 
        VALUES ('$uid', '$bid', '$rating', '$date')";

        if ($insert) {
            echo "Success";
        } else {
            echo "Database Error: " . mysqli_error($con);
        }
    }
} else {
    echo "Invalid data";
}
?>
