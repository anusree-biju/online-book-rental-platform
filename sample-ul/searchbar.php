<?php
include '../db/connection.php'; // adjust the path as per your file structure

if (isset($_GET['search'])) {
    $searchTerm = mysqli_real_escape_string($con, $_GET['search']);

    $query = "SELECT * FROM book_tb 
              WHERE title LIKE '%$searchTerm%' 
                 OR author LIKE '%$searchTerm%' 
                 OR category LIKE '%$searchTerm%'";

    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<h2>Search Results:</h2>";
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>Title</th><th>Author</th><th>Category</th><th>Price</th><th>Image</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".$row['title']."</td>";
            echo "<td>".$row['author']."</td>";
            echo "<td>".$row['category']."</td>";
            echo "<td>".$row['price']."</td>";
            echo "<td><img src='".$row['image']."' width='80'></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No books found matching your search.</p>";
    }
} else {
    echo "<p>Please enter a search term.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background: #f5f5f5;
      color: #333;
    }

    header {
      background: #2c3e50;
      padding: 15px 30px;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
    }

    header h1 {
      font-size: 24px;
    }

    nav a {
      color: white;
      margin: 0 10px;
      text-decoration: none;
      font-weight: 500;
      cursor: pointer;
    }

    nav a:hover {
      text-decoration: underline;
    }

    .search-bar {
      margin: 20px auto;
      max-width: 600px;
      display: flex;
    }

    .search-bar input {
      flex: 1;
      padding: 10px;
      border: 1px solid #ccc;
      border-right: none;
      border-radius: 5px 0 0 5px;
    }

    .search-bar button {
      padding: 10px 15px;
      border: none;
      background: #3498db;
      color: white;
      border-radius: 0 5px 5px 0;
      cursor: pointer;
    }

    section {
      display: none;
      padding: 30px;
    }

    section.active {
      display: block;
    }

    .book-list {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 20px;
    }

    .book-card {
      background: white;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .book-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .book-card h3 {
      margin: 10px 0 5px;
    }

    .book-card p {
      font-size: 14px;
      margin-bottom: 10px;
    }

    .book-card button {
      background: #2ecc71;
      color: white;
      border: none;
      padding: 8px 12px;
      border-radius: 5px;
      cursor: pointer;
    }

    .form-box, .cart-box,.profile-box, .payment-box {
      max-width: 600px;
      margin: 30px auto;
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .form-box input, .form-box textarea {
      width: 100%;
      margin: 10px 0;
      padding: 10px;
    }

    .form-box button {
      background: #3498db;
      color: white;
      padding: 10px 15px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    footer {
      text-align: center;
      padding: 20px;
      background: #2c3e50;
      color: white;
      margin-top: 40px;
    }

    h2 {
      margin-bottom: 20px;
      text-align: center;
    }
  
form {
  display: flex;
  gap: 10px;
  justify-content: center;
}
input[type="text"] {
  padding: 8px;
  width: 250px;
}
button {
  padding: 8px 15px;
  background-color: #007bff;
  color: white;
  border: none;
}



    
  </style>
</head>
<body>
     <!-- Search Bar -->
  <div class="search-bar">
    <input type="text" placeholder="Search for books...">
    <button type="submit" name="search">Search</button>
  </div>

</body>
</html>