<?php
session_start();
include '../db/connection.php';

if (!isset($_SESSION['uid'])) {
    echo "<script>alert('Please login first'); window.location.href='../login.php';</script>";
    exit;
}

if (isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $author = mysqli_real_escape_string($con, $_POST['author']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $security = mysqli_real_escape_string($con, $_POST['security']);
    $uid = $_SESSION['uid'];
    $approval_status="pending";

    // Check for duplicate title
    $checkuid = mysqli_query($con, "SELECT * FROM book_tb WHERE title='$title' AND uid='$uid'");
    if (mysqli_num_rows($checkuid) > 0) {
        echo "<script>alert('Book already exists');</script>";
        echo "<script>window.location.href='sampleui.php';</script>";
      exit;
    }

    // Handle image upload
    $directory = "uploads/";
    $filename = "";

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $filename = $directory . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $filename);
    }

    // Insert into database
    if (!empty($filename)) {
        $query = "INSERT INTO book_tb (uid, title, author, category, description, price,security, image,approval_status)
                  VALUES ('$uid', '$title', '$author', '$category', '$description', '$price','$security','$filename','$approval_status')";
    } else {
        $query = "INSERT INTO book_tb (uid, title, author, category, description, price,security,approval_status)
                  VALUES ('$uid', '$title', '$author', '$category', '$description', '$price','$security','$approval_status')";
    }

    $insert = mysqli_query($con, $query);

    if ($insert) {
        echo "<script>alert('Book posted successfully!after admin approval it will displayed'); window.location.href='sampleui.php';</script>";
    } else {
        echo "<script>alert('Database Error: " . mysqli_error($con) . "');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Online Book Rental</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
  
  body {
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #fff7f0, #ffe3e3);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }

  .form-box {
    background: #ffffff;
    padding: 30px 25px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    width: 400px;
    animation: fadeIn 0.6s ease-in-out;
  }

  .form-box h2 {
    text-align: center;
    color: #333;
    margin-bottom: 25px;
    font-weight: bold;
  }

  .form-box input[type="text"],
  .form-box input[type="number"],
  .form-box input[type="file"],
  .form-box textarea {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 14px;
    background-color: #fafafa;
    transition: border-color 0.3s ease;
  }

  .form-box input:focus,
  .form-box textarea:focus {
    border-color: #f28b82;
    outline: none;
    background-color: #fff;
  }

  .form-box textarea {
    resize: vertical;
    height: 100px;
  }

  .form-box input[type="submit"] {
    background-color: #f28b82;
    color: white;
    font-weight: bold;
    border: none;
    padding: 12px;
    margin-top: 15px;
    width: 100%;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  .form-box input[type="submit"]:hover {
    background-color: #e06757;
  }

  .form-box  {
    display: block;
    text-align: center;
    margin-top: 15px;
    color: #333;
    background: #eee;
    padding: 10px;
    text-decoration: none;
    border-radius: 8px;
    transition: background 0.3s;
  }

  .form-box  {
    background: #ddd;
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
<!-- Post Book Section -->
  <form action="" method="post" enctype="multipart/form-data">
  <div class="form-box">
    <h2>Post Your Book</h2>
    <input type="text" placeholder="Book Title" name="title" required />
    <input type="text" placeholder="Author" name="author" required />
    <input type="text" placeholder="Category" name="category" required />
    <textarea placeholder="Description" name="description" required></textarea>
    <input type="number" placeholder="Rent Price (₹)" name="price" required />
    <input type="number" placeholder="security Price (₹)" name="security" required />
    <input type="file" name="image" required />
    <input type="submit" name="submit" value="Submit" />
    <a class="logout-btn" href="sampleui.php">back</a>
  </div>
</form>
</body>
</html>