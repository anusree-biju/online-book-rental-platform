<?php
include "../db/connection.php";
session_start();

// ✅ Use your actual session variable
$user_id = $_SESSION['uid']; // Change if your session variable is named differently

// ✅ Fetch user’s books reviewed by admin
$query = mysqli_query($con, "
    SELECT title, approval_status 
    FROM book_tb 
    WHERE uid = '$user_id' 
      AND approval_status IN ('approved', 'rejected')
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Notifications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            padding: 20px;
        }
        .notification-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .notification-approved {
            border-left: 6px solid #28a745;
        }
        .notification-rejected {
            border-left: 6px solid #dc3545;
        }
        .back-btn {
            display: inline-block;
            padding: 10px 16px;
            background: #14191fff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin-top: 15px;
        }
        .back-btn:hover {
            background: #1a242eff;
        }
        h3 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<!-- ✅ Back Button -->
<a href="sampleui.php" class="back-btn">⬅ Back to Dashboard</a>

<h1>Your Book Notifications</h1>

<?php
if (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
        $title = htmlspecialchars($row['title']);
        $status = $row['approval_status'];

        if ($status == 'approved') {
            echo "
            <div class='notification-card notification-approved'>
                ✅ Your book <b>$title</b> has been <b>approved</b> by the admin.
            </div>";
        } elseif ($status == 'rejected') {
            echo "
            <div class='notification-card notification-rejected'>
                ❌ Your book <b>$title</b> has been <b>rejected</b> by the admin.
            </div>";
        }
    }
} else {
    echo "<p>No notifications yet. Your posted books may still be pending.</p>";
}
?>
<?php
// ==========================
//  PERMANENT RENTAL NOTICES
// ==========================

$rent = mysqli_query($con, "
    SELECT 
        b.title,
        r.rental_date,
        r.return_date,
        u.username AS owner_name,
        u.email AS owner_email
    FROM rental_tb r
    INNER JOIN book_tb b ON r.bid = b.bid
    INNER JOIN user_tb u ON b.uid = u.uid   -- GET OWNER FROM book_tb
    WHERE r.uid = '$user_id'                -- GET RENTALS OF LOGGED-IN USER
");

if (mysqli_num_rows($rent) > 0) {
    echo "<h1>Your Rental Notifications</h1>";

    while ($r = mysqli_fetch_assoc($rent)) {
        echo "
        <div class='notification-card' style='border-left:6px solid #007bff; padding:10px; margin-bottom:10px; border-radius:6px; background:#f7faff'>
            <h4 style='margin-top:0;'>📘 Book Rented Successfully</h4>
            <p><b>Book:</b> {$r['title']}</p>
            <p><b>Owner Name:</b> {$r['owner_name']}</p>
            <p><b>Owner Email:</b> {$r['owner_email']}</p>
            <p><b>Rental Date:</b> {$r['rental_date']}</p>
            <p><b>Return Date:</b> {$r['return_date']}</p>
        </div>";
    }
}
?>



<!-- ✅ Back Button -->
<a href="sampleui.php" class="back-btn">⬅ Back to Dashboard</a>

</body>
</html>
