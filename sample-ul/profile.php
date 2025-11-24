<?php
session_start();
include '../db/connection.php';

if (!isset($_SESSION['uid'])) {
    echo "<script>alert('Login first'); window.location.href='../mainlogin/login.html';</script>";
    exit();
}

$uid = $_SESSION['uid'];

$query = "SELECT * FROM user_tb WHERE uid='$uid'";
$result = mysqli_query($con, $query);

// Check for query errors
if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

// Check if a user was found
$row = mysqli_fetch_assoc($result);
if ($row) {
    $username = $row['username'];
    $email = $row['email'];
    $role = $row['role'];
} else {
    echo "<script>alert('User not found in the database'); window.location.href='../mainlogin/login.html';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>User Profile</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f0f2f5;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .profile-card {
      background: white;
      width: 400px;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    .profile-card h2 {
      text-align: center;
      color: #333;
      margin-bottom: 20px;
    }
    .profile-info {
      margin: 15px 0;
    }
    .profile-info label {
      font-weight: bold;
      color: #555;
    }
    .profile-info p {
      margin: 5px 0 15px 0;
      color: #222;
    }
    .logout-btn {
      background-color: #f44336;
      border: none;
      padding: 10px 20px;
      border-radius: 10px;
      color: white;
      font-weight: bold;
      cursor: pointer;
      display: block;
      margin: 20px auto 0;
      text-align: center;
      text-decoration: none;
    }
    .logout-btn:hover {
      background-color: #d32f2f;
    }
  </style>
</head>
<body>
  <div class="profile-card">
    <h2>User Profile</h2>
    <div class="profile-info">
      <label>Username:</label>
      <h3> <?php echo $username; ?></h3>
    </div>
    <div class="profile-info">
      <label>Email:</label>
      <p><?php echo $email; ?></p>
    </div>
    <div class="profile-info">
      <label>Role:</label>
      <p><?php echo ucfirst($role); ?></p>
    </div>
    <a class="logout-btn" href="changepass.php">change password</a>
    <a class="logout-btn" href="logout.php">Logout</a>
    <a class="logout-btn" href="sampleui.php">back</a>
  </div>
</body>
</html>
