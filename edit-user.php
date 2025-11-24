<?php
include '../db/connection.php';

if (isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
    $q = mysqli_query($con, "SELECT * FROM user_tb WHERE uid = '$edit_id'");
    $data = mysqli_fetch_assoc($q);
}

if (isset($_POST['update'])) {
    $uid = $_POST['uid'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    

    mysqli_query($con, "UPDATE user_tb SET username='$username',email='$email', password='$password',  WHERE uid='$uid'");
    echo "<script>alert('user details updated successfully'); window.location.href='table-footable.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit user details</title>
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
<h4><a class="button" href="table-footable.php">GO BACK</a></h4>
<form class="edit-form" method="POST" action="">
    <h2>Edit user details</h2>
    <input type="hidden" name="uid" value="<?php echo $data['uid']; ?>">

    <label for="title">username</label>
    <input type="text" name="username" value="<?php echo $data['username']; ?>" required>

    <label for="author">email</label>
    <input type="text" name="email" value="<?php echo $data['email']; ?>" required>

    <label for="category">password</label>
    <input type="text" name="password" value="<?php echo $data['password']; ?>" required>


    <button type="submit" name="update">Update</button>
    
</form>

</body>
</html>
