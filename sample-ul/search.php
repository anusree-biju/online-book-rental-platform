<?php
{
include '../db/connection.php'; // adjust the path as needed
  $query = "SELECT * FROM book_tb WHERE  approval_status='approved'";
  $result = mysqli_query($con, $query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Search Results</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
      background: #f4f4f4;
    }

    .search-bar {
      display: flex;
      justify-content: center;
      margin-bottom: 30px;
    }

    .search-bar input[type="text"] {
      padding: 10px;
      width: 300px;
      border: 1px solid #aaa;
      border-radius: 5px 0 0 5px;
      outline: none;
    }

    .search-bar button {
      padding: 10px 20px;
      background-color: #4285f4;
      border: none;
      color: white;
      border-radius: 0 5px 5px 0;
      cursor: pointer;
    }

    .search-bar button:hover {
      background-color: #3367d6;
    }

    .book-results {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
    }

    .book-card {
      background-color: white;
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 15px;
      width: 200px;
      text-align: center;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .book-card img {
      max-width: 100%;
      height: auto;
      border-radius: 5px;
    }

    .book-card h4 {
      margin: 10px 0 5px;
      font-size: 18px;
    }

    .book-card p {
      font-size: 14px;
      color: #555;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

.book-card button {
  padding: 10px 15px;
  margin-top: 10px;
  width: 100%;
  border: none;
  border-radius: 5px;
  background-color: #28a745; /* Default: Green */
  color: white;
  font-size: 14px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.book-card button:hover {
  background-color: #218838;
}

.book-card button a {
  text-decoration: none;
  color: white;
  display: block;
  width: 100%;
  height: 100%;
}

/* Not Available button */
.book-card button[disabled] {
  background-color: #6c757d;
  cursor: not-allowed;
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
<h2><a class="button" href="sampleui.php">GO BACK</a></h2>
<!-- Search bar again for re-searching -->
<form class="search-bar" method="GET" action="search.php">
  <input type="text" name="query" placeholder="Search for books..." value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
  <button type="submit" name="search">Search</button>
</form>

<?php
if (isset($_GET['search'])) {
    $query = mysqli_real_escape_string($con, $_GET['query']);
    
    $sql = "SELECT * FROM book_tb WHERE title LIKE '%$query%' OR author LIKE '%$query%'";
    $result = mysqli_query($con, $sql);

    echo "<h2>Search Results for \"" . htmlspecialchars($query) . "\"</h2>";
    echo "<div class='book-results'>";

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="book-card">
                <img src="<?php echo $row['image']; ?>" alt="Book Image" width="100" height="150">
                <h4><?php echo $row['title']; ?></h4>
                <p>Author: <?php echo $row['author']; ?></p>

                <!-- Add to Cart Form -->
                <form method="POST" action="cart.php">
                    <input type="hidden" name="bid" value="<?php echo $row['bid']; ?>">
                    <button type="submit" name="cart">Add to Cart</button>
                </form>

                <!-- Rent Now or Not Available -->
                <?php if ($row['status'] == "available") { ?>
                    <button>
                        <a href="rentalorder.php?bid=<?php echo $row['bid']; ?>" style="text-decoration: none; color: white;">Rent Now</a>
                    </button>
                <?php } else { ?>
                    <button disabled style="background-color: gray; color: white;">Not Available</button>
                <?php } ?>
                <!-- Back Button -->
    <br>
    <a href="sampleui.php" style="text-decoration: none;">
  <button style="text-decoration: none; color: white;">Back</button>
</a>
            </div>
            <?php
        }
    } else {
        echo "<p>No books found matching your search.</p>";
    }

    echo "</div>";
}
?>


</body>
</html>
