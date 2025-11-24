<?php
session_start();
include '../db/connection.php';

if (isset($_SESSION['uid'])) {
    $uid = (int) $_SESSION['uid']; // cast to int for safety
    $query = "SELECT * FROM book_tb WHERE uid != $uid AND approval_status = 'approved'";
    $result = mysqli_query($con, $query);
} else {
    echo "User not logged in.";
    exit;
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
      background: #012711ff;
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
  background-color: #03371aff;
  color: white;
  border: none;
}
/*a {
  padding: 8px 15px;
  background-color: #3ea56cff;
  color: white;
  border: none;
}*/
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
    
  <!-- Home Section -->
<section id="home" class="active">
  <button><a href="sampleui.php" style="color: white; text-decoration: none;">back</a></button>
  <h2>Available for Rent</h2>
  <div class="book-list">
    <?php while($row = mysqli_fetch_assoc($result)) { ?>
      <div class="book-card">
        <a href="book_details.php?bid=<?php echo $row['bid']; ?>">
          <img src="<?php echo $row['image']; ?>" width="100" height="150" alt="Book Image" />
          <h3><?php echo $row['title']; ?></h3>
        </a>
        <p>Author: <?php echo $row['author']; ?></p>
        <p>Category: <?php echo $row['category']; ?></p>
        <p>Description: <?php echo $row['description']; ?></p>
        <p>Price: ₹<?php echo $row['price']; ?></p>
        <p>security: ₹<?php echo $row['security']; ?></p>
        <form method="POST" action="cart.php">
        <input type="hidden" name="bid" value="<?php echo $row['bid']; ?>">
          <button type="submit" name="cart">Add to Cart</button><br>
        </form>

        <input type="hidden" name="bid" value="<?php echo $row['bid']; ?>">
        <?php if($row['status']=="available")
        {
          ?>
          <button><a href="rentalorder.php?bid=<?php echo $row['bid']; ?>" name="payment" style="color: white; text-decoration: none;" >rent now</a></button>
          <?php
        }
        else{
          ?>
          <button>Not Available</button>
          <?php
        } ?>
      
      </div>
    <?php
     }
     ?>
  </div>
</section>

</body>
</html>