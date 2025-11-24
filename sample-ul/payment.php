<?php
session_start();
include '../db/connection.php';

if (!isset($_SESSION['uid'])) {
    echo "<script>alert('Please login first'); window.location.href='../mainlogin/login.html';</script>";
    exit();
}

$uid = $_SESSION['uid'];

$query = "SELECT 
            p.*, 
            b.title AS book_title 
          FROM payment_tb p
          JOIN rental_tb r ON p.rid = r.rid
          JOIN book_tb b ON r.bid = b.bid
          WHERE p.uid = '$uid'
          ORDER BY p.payment_date DESC";

$result = mysqli_query($con, $query);
?>

<h2><a class="button" href="sampleui.php" style="padding:8px 16px;background:#3498db;color:white;text-decoration:none;border-radius:5px;">GO BACK</a></h2>

<h2 style="text-align:center;">My Payment History</h2>
<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; text-align: left;">
  <thead style="background-color: #0058a3; color: white;">
    <tr>
      <th>name</th>  
      <th>Book Title</th>
      <th>Amount</th>
      <th>credit card num</th>
      <th>Status</th>
      <th>Date</th>
      <th>Contact</th>
      <th>District</th>
      <th>Address</th>
      <th>Postal Code</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['name']}</td>
                    <td>{$row['book_title']}</td>
                    <td>₹{$row['amount']}</td>
                    <td>{$row['credit']}</td>
                    <td>{$row['payment_status']}</td>
                    <td>{$row['payment_date']}</td>
                    <td>{$row['phno']}</td>
                    <td>{$row['district']}</td>
                    <td>{$row['address']}</td>
                    <td>{$row['postal_code']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='10' style='text-align:center;'>No payment history found.</td></tr>";
    }
    ?>
  </tbody>
</table>
