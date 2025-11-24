<?php
session_start();
include '../db/connection.php';

if (!isset($_SESSION['uid'])) {
    echo "<script>alert('Please login first'); window.location.href='../mainlogin/login.html';</script>";
    exit();
}

$uid = $_SESSION['uid'];

// FIX: Added r.rid into SELECT query
$sql = "SELECT r.rid, r.rental_date, r.return_date, r.paid, r.status, 
               b.title, b.author, b.image, b.bid, u.username
        FROM rental_tb r
        JOIN book_tb b ON r.bid = b.bid
        JOIN user_tb u ON r.uid = u.uid
        WHERE r.uid = $uid
        ORDER BY r.rental_date DESC";

$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Rentals</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
        }
        .order-container {
            width: 90%;
            max-width: 1000px;
            margin: 40px auto;
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #007BFF;
            color: white;
        }
        .book-img {
            width: 60px;
            height: auto;
            border-radius: 4px;
        }
        .feedback-btn {
            background-color: #28a745;
            color: white;
            padding: 6px 10px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            display: inline-block;
            margin-bottom: 4px;
        }
        .feedback-btn:hover {
            background-color: #218838;
        }
        .btn-return {
            background-color: #ffc107;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            color: #000;
            font-size: 14px;
        }
        .btn-return:hover {
            background-color: #e0a800;
        }
        .message {
            display: none;
            margin-top: 5px;
            font-size: 13px;
            background-color: #d4edda;
            color: #155724;
            padding: 6px;
            border-radius: 4px;
            border: 1px solid #c3e6cb;
        }
        .button {
            background-color: #007BFF;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 16px;
            display: block;
            width: fit-content;
            margin: 0 auto 0 0;
        }
    </style>
</head>

<body>
    <h2><a class="button" href="sampleui.php">GO BACK</a></h2>

<div class="order-container">
    <h2>My Book Orders</h2>

    <table>
        <tr>
            <th>Username</th>
            <th>Title</th>
            <th>Author</th>
            <th>Rental Date</th>
            <th>Return Date</th>
            <th>Image</th>
            <th>Price</th>
            <th>Status</th>
            <th>Feedback</th>
            <th>Return</th>
        </tr>

        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                
                $bid = $row['bid'];
                $rid = $row['rid']; // IMPORTANT

                echo "<tr>
                        <td>{$row['username']}</td>
                        <td>{$row['title']}</td>
                        <td>{$row['author']}</td>
                        <td>{$row['rental_date']}</td>
                        <td>{$row['return_date']}</td>
                        <td><img src='{$row['image']}' class='book-img'></td>
                        <td>{$row['paid']}</td>
                        <td>{$row['status']}</td>
                        <td>";

                // FIX: Feedback check based on RID not BID
                $feedback_check = mysqli_query($con, "SELECT * FROM feedback_tb WHERE rid='$rid'");
                
                if (mysqli_num_rows($feedback_check) == 0) {
                    echo "<a href='feedback.php?rid=$rid' class='feedback-btn'>Give Feedback</a>";
                } else {
                    echo "<span style='color: green;'>✓ Feedback Given</span>";
                }

                echo "</td>
                      <td>
                        <button class='btn-return' onclick=\"showMessage('msg-$rid')\">Returned Book</button>

                        <a href='order-track.php?rid=$rid' 
                        class='track-btn' 
                        style='display:block;margin-top:6px;background:#007BFF;color:white;padding:6px 10px;border-radius:6px;text-align:center;text-decoration:none;'>
                            Track Order
                        </a>

                        <div id='msg-$rid' class='message'>
                            The security amount will be returned within 7 working days.
                        </div>
                      </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='10' style='text-align:center;'>No rentals found</td></tr>";
        }
        ?>

    </table>
</div>

<script>
function showMessage(id) {
    const msg = document.getElementById(id);
    msg.style.display = msg.style.display === "block" ? "none" : "block";
}
</script>

</body>
</html>
