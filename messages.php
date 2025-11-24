<?php
$con=new mysqli($sname,$user,$pass,$db);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$result = $con->query("SELECT * FROM messages1_tb ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin - Messages</title>
  <style>
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { padding: 10px; border: 1px solid #ccc; }
    th { background-color: #f2f2f2; }
  </style>
</head>
<body>
  <h2>Received Messages</h2>
  <table>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Subject</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Message</th>
      <th>Date</th>
    </tr>
    <?php while($row = $result->fetch_assoc()) { ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= htmlspecialchars($row['name']) ?></td>
      <td><?= htmlspecialchars($row['subject']) ?></td>
      <td><?= htmlspecialchars($row['email']) ?></td>
      <td><?= htmlspecialchars($row['phone']) ?></td>
      <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
      <td><?= $row['created_at'] ?></td>
    </tr>
    <?php } ?>
  </table>
</body>
</html>
