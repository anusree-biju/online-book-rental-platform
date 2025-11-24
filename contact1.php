<?php
session_start();
include '../db/connection.php';

// Fetch all users with role not admin and their contact info
$query = mysqli_query($con, "
    SELECT u.uid, u.username, u.email, p.phno, u.role
    FROM user_tb u
    LEFT JOIN payment_tb p ON u.uid = p.uid
    WHERE u.role != 'admin'
    GROUP BY u.uid
");

// Check for query errors
if (!$query) {
    die("Query failed: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Contact Details</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Amaranth&family=Alata&display=swap" rel="stylesheet">

<style>
  body {
    background: #f5f7fa;
    font-family: 'Alata', sans-serif;
  }

  h3 {
    font-family: 'Amaranth', sans-serif;
    color: #333;
    font-weight: bold;
  }

  .table-container {
    background: #fff;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  }

  table {
    border-radius: 10px;
    overflow: hidden;
  }

  thead {
    background-color: #343a40;
    color: #fff;
  }

  tbody tr {
    transition: 0.3s;
  }

  tbody tr:hover {
    background-color: #f0f8ff;
    transform: scale(1.01);
  }

  td, th {
    vertical-align: middle !important;
    text-align: center;
  }

  .table-striped tbody tr:nth-of-type(odd) {
    background-color: #f9f9f9;
  }

  @media (max-width: 768px) {
    .table-container {
      padding: 15px;
    }
    h3 {
      font-size: 1.5rem;
    }
  }
</style>
</head>

<body>
  <button class="btn btn-primary m-3" onclick="window.history.back();">
    <i class="fa fa-arrow-left"></i> GO BACK </button>
<section class="container mt-5">
  <div class="table-container">
    <h3 class="text-center mb-4">All Users Contact Details</h3>

    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>User Name</th>
          <th>Email</th>
          <th>Phone Number</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i = 1;
        while ($row = mysqli_fetch_assoc($query)) {
            echo "<tr>
                    <td>{$i}</td>
                    <td>{$row['username']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['phno']}</td>
                  </tr>";
            $i++;
        }
        if ($i == 1) {
            echo "<tr><td colspan='4' class='text-center'>No contact details found.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</section>
</body>
</html>
