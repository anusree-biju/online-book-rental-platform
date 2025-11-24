<?php
session_start();
include '../db/connection.php';

if (!isset($_SESSION['uid'])) {
    echo "<script>alert('Login first'); window.location.href='../mainlogin/login.html';</script>";
    exit();
}

$uid = $_SESSION['uid']; // Get the logged-in user's ID

if (isset($_POST['submit'])) {
    $oldp = $_POST['current_password'];
    $np = $_POST['new_password'];
    $np1 = $_POST['confirm_password'];

    if ($np !== $np1) {
        echo "<script>alert('Passwords do not match.');</script>";
    } else {
        // Fetch current password from DB
        $query = "SELECT password FROM user_tb WHERE uid='$uid'";
        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $db_password = $row['password'];

            if ($oldp === $db_password) {
                $update = "UPDATE user_tb SET password='$np' WHERE uid='$uid'";
                if (mysqli_query($con, $update)) {
                    echo "<script>alert('Password changed successfully'); window.location.href='sampleui.php';</script>";
                } else {
                    echo "<script>alert('Error updating password.');</script>";
                }
            } else {
                echo "<script>alert('Incorrect current password.');</script>";
            }
        } else {
            echo "<script>alert('User not found.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Change Password</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .change-password-container {
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-top: 10px;
    }

    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    button {
      margin-top: 20px;
      width: 100%;
      padding: 10px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
    }

    button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>

  <div class="change-password-container">
    <h2>Change Password</h2>
    <form method="POST">
      <label for="current_password">Current Password:</label>
      <input type="password" id="current_password" name="current_password" required>

      <label for="new_password">New Password:</label>
      <input type="password" id="new_password" name="new_password" required>

      <label for="confirm_password">Confirm New Password:</label>
      <input type="password" id="confirm_password" name="confirm_password" required>

      <button type="submit" name="submit">Change Password</button>
    </form>
  </div>

</body>
</html>