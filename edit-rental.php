<?php
include '../db/connection.php';

if (isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
    $q = mysqli_query($con, "SELECT * FROM rental_tb WHERE rid = '$edit_id'");
    $data = mysqli_fetch_assoc($q);
}

if (isset($_POST['update'])) {
    $rid = $_POST['rid'];
    $week = $_POST['week'];
    $status = $_POST['status'];
    $rental_date = $_POST['rental_date'];
    $return_date = $_POST['return_date'];
    $paid = $_POST['paid'];

    mysqli_query($con, "UPDATE rental_tb SET week=' $week',status='$status', rental_date='$rental_date', return_date=' $return_date',paid='$paid' WHERE rid='$rid'");
    echo "<script>alert('user details updated successfully'); window.location.href='table-footable.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit rental details</title>
    <style>
        body {
            background-color: #f2f6fc;
            font-family: 'Segoe UI', sans-serif;
            padding: 40px;
        }

        .edit-form {
            background: white;
            padding: 30px 40px;
            border-radius: 12px;
            max-width: 500px;
            margin: auto;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .edit-form h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .edit-form label {
            display: block;
            margin-bottom: 8px;
            margin-top: 20px;
            font-weight: 600;
        }

        .edit-form input[type="text"],
        .edit-form input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }

        .edit-form button {
            margin-top: 30px;
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .edit-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<form class="edit-form" method="POST" action="">
    <h2>Edit rental details</h2>
    <input type="hidden" name="rid" value="<?php echo $data['rid']; ?>">

    <label for="title">week</label>
    <input type="text" name="week" value="<?php echo $data['username']; ?>" required>

    <label for="author">email</label>
    <input type="text" name="email" value="<?php echo $data['email']; ?>" required>

    <label for="category">password</label>
    <input type="text" name="password" value="<?php echo $data['password']; ?>" required>

    <label for="price">role</label>
    <input type="text" name="role" value="<?php echo $data['role']; ?>"  required>

    <button type="submit" name="update">Update</button>
</form>

</body>
</html>

