<?php
session_start();
include '../db/connection.php';

// Check login
if (!isset($_SESSION['uid'])) {
    echo "<script>alert('Please login first'); window.location.href='../mainlogin/login.html';</script>";
    exit();
}

$uid = $_SESSION['uid'];

// ================== UPDATE ORDER STATUS ==================
if (isset($_POST['update_status'])) {
    $rid = $_POST['rid'];
    $bid = $_POST['bid'];
    $order_status = $_POST['order_status'];

    // Update rental only if book owner matches current user
    $update = "
        UPDATE rental_tb r
        JOIN book_tb b ON r.bid = b.bid
        SET r.order_status = '$order_status'
        WHERE r.rid = '$rid'
        AND r.bid = '$bid'
        AND b.uid = '$uid'
    ";

    mysqli_query($con, $update);

    echo "<script>alert('Order status updated successfully'); window.location.href='rental-status.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Order Status of My Books</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ccc; }
        select, button { padding: 6px; }
        
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
<h2><a class="button" href="sampleui.php">GO BACK</a></h2>
<h2>My Posted Books – Manage Order Status</h2>

<table>
    <tr>
        <th>Book ID</th>
        <th>Book Name</th>
        <th>Current Order Status</th>
        <th>Update</th>
    </tr>

<?php
// Fetch user-posted books
$books = mysqli_query($con, "SELECT * FROM book_tb WHERE uid='$uid'");

if (mysqli_num_rows($books) == 0) {
    echo "<tr><td colspan='4' style='text-align:center;'>You have not posted any books</td></tr>";
}

while ($book = mysqli_fetch_assoc($books)) {

    $bid = $book['bid'];

    // fetch latest rental status + rid
    $r = mysqli_query($con, 
        "SELECT rid, order_status 
         FROM rental_tb 
         WHERE bid='$bid' 
         ORDER BY rid DESC 
         LIMIT 1");

    if (mysqli_num_rows($r) == 0) {
        $current_status = "No orders yet";
        $rid = null;
    } else {
        $row = mysqli_fetch_assoc($r);
        $current_status = $row['order_status'];
        $rid = $row['rid']; // we need this for safe update
    }
?>
<tr>
    <td><?php echo $bid; ?></td>
    <td><?php echo $book['title']; ?></td>
    <td><?php echo $current_status; ?></td>

    <td>
        <?php if ($current_status !== "No orders yet") { ?>
        <form method="post">
            <input type="hidden" name="rid" value="<?php echo $rid; ?>">
            <input type="hidden" name="bid" value="<?php echo $bid; ?>">

            <select name="order_status">
                <option value="Pending"  <?php if($current_status=="Pending") echo "selected"; ?>>Pending</option>
                <option value="Approved" <?php if($current_status=="Approved") echo "selected"; ?>>Approved</option>
                <option value="Shipped" <?php if($current_status=="Shipped") echo "selected"; ?>>Shipped</option>
                <option value="Out for Delivery" <?php if($current_status=="Out for Delivery") echo "selected"; ?>>Out for Delivery</option>
                <option value="Delivered" <?php if($current_status=="Delivered") echo "selected"; ?>>Delivered</option>
            </select>

            <button type="submit" name="update_status">Update</button>
        </form>
        <?php } else { ?>
            <span style="color:gray;">No rental yet</span>
        <?php } ?>
    </td>
</tr>

<?php } ?>
</table>

</body>
</html>
