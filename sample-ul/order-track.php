<?php
session_start();
include '../db/connection.php';

if (!isset($_SESSION['uid'])) {
    echo "<script>alert('Please login first'); window.location.href='../mainlogin/login.html';</script>";
    exit();
}

if (!isset($_GET['rid'])) {
    die("Invalid Request");
}

$rid = $_GET['rid'];
$uid = $_SESSION['uid'];

// Fetch rental using RID (unique)
$q = mysqli_query($con, "SELECT * FROM rental_tb WHERE rid='$rid' AND uid='$uid'");
$data = mysqli_fetch_assoc($q);

if (!$data) {
    die("Order not found");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Tracking</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .step { padding: 10px; margin: 10px 0; border-left: 4px solid gray; }
        .done { border-color: green; font-weight: bold; }
        .back-btn {
            padding: 8px 16px;
            background: #444;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .back-btn:hover {
            background: #333;
        }
    </style>
</head>
<body>

<h2>Order Tracking</h2>
<p><strong>Order Status:</strong> <?php echo $data['order_status']; ?></p>

<div class="step <?php if($data['order_status']!='Pending') echo 'done'; ?>">Order Placed</div>
<div class="step <?php if(in_array($data['order_status'], ['Approved', 'Shipped', 'Out for Delivery', 'Delivered'])) echo 'done'; ?>">Approved</div>
<div class="step <?php if(in_array($data['order_status'], ['Shipped', 'Out for Delivery', 'Delivered'])) echo 'done'; ?>">Shipped</div>
<div class="step <?php if(in_array($data['order_status'], ['Out for Delivery', 'Delivered'])) echo 'done'; ?>">Out for Delivery</div>
<div class="step <?php if($data['order_status']=='Delivered') echo 'done'; ?>">Delivered</div>

<a href="order.php" class="back-btn">Go Back</a>

</body>
</html>
