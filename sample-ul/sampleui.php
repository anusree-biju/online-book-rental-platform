
<?php
  session_start();
include '../db/connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Online Book Rental</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
      background: #0b93ddff;
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
  background-color: #107befff;
  color: white;
  border: none;
}

/* sidebar */
 

   .sidebar {
  position: fixed;
  top: 0;
  left: 0;
  width: 40px;
  height: 100vh;
  background-color: #2c3e50;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding-top: 100px;
}

    .sidebar:hover {
      width: 200px;
    }

    .sidebar a {
  display: flex;
  align-items: left;
  padding: 12px 15px;
  color: white;
  text-decoration: none;
  white-space: nowrap;
  overflow: hidden;
  transition: background 0.3s ease;
}


    .sidebar a:hover {
      background-color: #34495e;
    }

    .sidebar i {
      display: inline-block;
      width: 30px;
      text-align: center;
      margin-right: 10px;
    }

    .logo {
      padding: 20px;
      font-weight: bold;
      text-align: center;
    }

    .content {
      margin-left: 60px;
      padding: 20px;
      transition: margin-left 0.3s ease;
      width: 100%;
    }

    .sidebar:hover ~ .content {
      margin-left: 200px;
    }
    .menu-item {
  position: relative;
  margin: 25px 0;
  text-decoration: none;
}
.dot {
  width: 14px;
  height: 14px;
  background-color: #ecf0f1;
  border-radius: 50%;
  display: block;
  transition: background-color 0.3s;
}

.menu-item:hover .dot {
  background-color: #1abc9c;
}

.label {
  margin-left: 12px;
  color: white;
  font-family: sans-serif;
  font-size: 14px;
  display: none;
}


.menu-item:hover .label {
  opacity: 1;
  left: 70px;
}
.menu-item {
  display: flex;
  align-items: center;
  justify-content: start;
  position: relative;
}

.menu-item .label {
  display: none;
}

.sidebar:hover .menu-item .label {
  display: inline-block;
  opacity: 1;
  margin-left: 12px;
}

  </style>
</head>
<body>
  <!-- Header and Navbar -->
  <header>
    <h1>📚 Book Rental</h1>
    <nav>
      <a onclick="showSection('home')">Home</a>
      <a href="profile.php">Profile</a>
      <a href="postbook.php">Post Book</a>
      <a href="rental.php"> Rental books</a>
      <a href="myrental.php"> My books</a>
      <a href="cart.php">Cart</a>
      <a href="payment.php">Payments</a>
      <a href="notifications.php">🔔</a>
      <button><a href="logout.php">logout</a></botton>
    </nav>
  </header>


  <!-- side bar-->
 <div class="sidebar">
  <a href="sampleui.php" class="menu-item">
    <span class="dot"></span>
    <span class="label">Home</span>
  </a>
  <a href="book.php" class="menu-item">
    <span class="dot"></span>
    <span class="label">Books status</span>
  </a>
  <a href="messages.php" class="menu-item">
    <span class="dot"></span>
    <span class="label">Messages</span>
  </a>
  <a href="order.php" class="menu-item">
    <span class="dot"></span>
    <span class="label">orders</span>
  </a>
  <a href="rental-status.php" class="menu-item">
    <span class="dot"></span>
    <span class="label">rental status</span>
  </a>
  <a href="logout.php" class="menu-item">
    <span class="dot"></span>
    <span class="label">Logout</span>
  </a>
</div>




  <!-- Search Bar -->
<form class="search-bar" method="GET" action="search.php">
  <input type="text" name="query" placeholder="Search for books...">
  <button type="submit" name="search">Search</button>
</form>

<?php
{
  $query = "SELECT * FROM book_tb where approval_status='approved'";
  $result = mysqli_query($con, $query);
}
?>

  <!-- Home Section -->
<section id="home" class="active">
  <h2>Featured Books</h2>
  
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
        <form method="POST" action="rental.php">
        <input type="hidden" name="bid" value="<?php echo $row['bid']; ?>">
          <button type="submit" name="cart">go to rental</button>
        </form>
      </div>
    <?php
     }
     ?>
  </div>
</section>

  

  <!-- Cart Section -->
  <section id="cart">
    <div class="cart-box">
      <h2>Your Cart</h2>
      <p>📖 Book Title 1 - ₹50</p>
      <p>📖 Book Title 2 - ₹70</p>
      <hr>
      <p><strong>Total: ₹120</strong></p>
    </div>
  </section>

  <!-- Payment Section -->
  <section id="payment">
    <div class="payment-box">
      <h2>Payment</h2>
      <p>Select a payment method:</p>
      <input type="radio" name="payment" /> UPI <br/>
      <input type="radio" name="payment" /> Credit/Debit Card <br/>
      <input type="radio" name="payment" /> Cash on Delivery <br/><br/>
      <button>Pay Now</button>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    &copy; 2025 Online Book Rental. All rights reserved.
  </footer>

  <!-- Section Switcher Script -->
  <script>
    function showSection(id) {
      document.querySelectorAll('section').forEach(section => {
        section.classList.remove('active');
      });
      document.getElementById(id).classList.add('active');
    }
  </script>
</body>
</html>
