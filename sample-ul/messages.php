<?php
session_start();
include '../db/connection.php';

if (!isset($_SESSION['uid'])) {
    header("Location: login.php");
    exit;
}

$uid = $_SESSION['uid'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Messages</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="font-awesome.min.css">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            margin-top: 40px;
        }
        .card {
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .card-header {
            font-weight: bold;
            font-size: 18px;
            background: #007BFF;
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .card-body {
            padding: 20px;
        }
        .card-footer {
            background-color: #f9f9f9;
            font-size: 0.9em;
            color: #555;
            text-align: right;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }
        .empty-msg {
            text-align: center;
            margin-top: 60px;
            font-size: 1.2em;
            color: #888;
        }
         .button {
    background-color: #1a1c1eff;
    color: white;
    padding: 10px 15px;
    text-decoration: none;
    border-radius: 6px;
    font-size: 16px;
    display: block;    /* makes it take full width line */
    width: fit-content;/* keeps button size just around text */
    margin: 0 auto 0 0;/* top right bottom left → pushes it left */
}
    </style>
</head>
<body>
    <h3><a class="button" href="sampleui.php">GO BACK</a></h3>
<div class="container">
    <h2 class="mb-4"><i class="fa fa-envelope"></i> Your Notifications</h2>

    <?php
    $query = mysqli_query($con, "SELECT * FROM messages_tb WHERE owner_id= '$uid' ORDER BY date DESC");

    if (mysqli_num_rows($query) > 0) {
        while ($msg = mysqli_fetch_assoc($query)) {
            echo "<div class='card'>";
            echo "<div class='card-header'>New Message</div>";
            echo "<div class='card-body'>";
            echo "<p>" . nl2br(htmlspecialchars($msg['message'])) . "</p>";
            echo "</div>";
            echo "<div class='card-footer'>Received on " . date('d M Y, h:i A', strtotime($msg['date'])) . "</div>";
            echo "</div>";
        }
    } else {
        echo "<p class='empty-msg'><i class='fa fa-inbox'></i> You have no messages yet.</p>";
    }
    ?>
</div>
</body>
</html>
