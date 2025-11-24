<?php
session_start();
include '../db/connection.php';

if (!isset($_SESSION['uid'])) {
    echo "<script>alert('Please log in to view payment history.'); window.location.href='login.php';</script>";
    exit();
}

$uid = $_SESSION['uid'];

$query = mysqli_query($con, "
    SELECT 
        p.*, 
        b.title   
    FROM 
        payment_tb p
    JOIN rental_tb r ON p.rid = r.rid
    JOIN book_tb b ON r.bid = b.bid
    WHERE 
        p.uid = '$uid'
    ORDER BY 
        p.payment_date DESC
");

?>

<!DOCTYPE html>
<html>
<head>
    <title>My Payment History</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <style>
        body {
            padding: 20px;
            font-family: Arial;
        }
        h2 {
            margin-bottom: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table th, table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        .btn-back {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<a href="sampleui.php" class="btn btn-secondary btn-back">← Back</a>


<div class="container mt-5">
    <h2>My Payment History</h2>
    <table class="table table-bordered table-striped mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Book Title</th>
                <th>Amount</th>
                <th>Payment Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $count = 1;
        while ($row = mysqli_fetch_assoc($query)) {
            echo "<tr>
                <td>{$count}</td>
                <td>{$row['title']}</td>
                <td>₹{$row['amount']}</td>
                <td>{$row['payment_date']}</td>
                <td><span class='badge badge-success'>{$row['payment_status']}</span></td>
            </tr>";
            $count++;
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
