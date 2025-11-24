<?php
include '../db/connection.php';

if (!isset($_GET['bid'])) {
    echo "Book ID not provided.";
    exit;
}

$bid = intval($_GET['bid']);

// Fetch book + owner info
$book_query = "
    SELECT b.*, u.username AS owner_name, u.email AS owner_email 
    FROM book_tb b 
    JOIN user_tb u ON b.uid = u.uid 
    WHERE b.bid = $bid";
$book_result = mysqli_query($con, $book_query);
$book = mysqli_fetch_assoc($book_result);

if (!$book) {
    echo "Book not found.";
    exit;
}

// Fetch feedbacks with user names
$feedback_query = "
    SELECT f.rating, f.comment, f.date, u.username AS user_name 
    FROM feedback_tb f 
    JOIN user_tb u ON f.uid = u.uid 
    WHERE f.bid = $bid 
    ORDER BY f.date DESC";
$feedback_result = mysqli_query($con, $feedback_query);

// Calculate average rating
$avg_rating_query = "SELECT ROUND(AVG(rating), 1) AS avg_rating FROM feedback_tb WHERE bid = $bid";
$avg_result = mysqli_query($con, $avg_rating_query);
$avg_row = mysqli_fetch_assoc($avg_result);
$avg_rating = $avg_row['avg_rating'] ?? 'No rating';
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $book['title']; ?> - Book Details</title>
    <style>
        body { font-family: Arial; }
        .container { max-width: 700px; margin: auto; }
        img { width: 180px; height: auto; }
        .section { margin-top: 20px; }
        .feedback { border-bottom: 1px solid #ccc; padding: 8px 0; }
        .rating { color: orange; font-weight: bold; }
        
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f4f4f9;
      margin: 0;
      padding: 20px;
      color: #333;
    }

    .container {
      max-width: 800px;
      margin: auto;
      background: #fff;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    h2 {
      color: #333;
      margin-bottom: 10px;
    }

    img {
      width: 200px;
      height: auto;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    p {
      line-height: 1.6;
    }

    .section {
      margin-top: 30px;
    }

    .section h3 {
      border-left: 5px solid #4A90E2;
      padding-left: 10px;
      color: #4A90E2;
      margin-bottom: 15px;
    }

    .feedback {
      background: #f9f9f9;
      padding: 12px 15px;
      border-left: 4px solid #4A90E2;
      border-radius: 6px;
      margin-bottom: 15px;
    }

    .feedback .rating {
      color: #FFA500;
      font-weight: bold;
      margin-bottom: 5px;
    }

    button {
      background-color: #4A90E2;
      color: white;
      border: none;
      padding: 12px 20px;
      font-size: 16px;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #357ABD;
    }

    @media (max-width: 600px) {
      .container {
        padding: 15px;
      }

      img {
        width: 100%;
      }

      button {
        width: 100%;
        padding: 14px;
      }
    }
  
    </style>
</head>
<body>
<div class="container">
    <h2><?php echo $book['title']; ?></h2>
    <img src="<?php echo $book['image']; ?>" alt="Book Image">
    <p><strong>Author:</strong> <?php echo $book['author']; ?></p>
    <p><strong>Category:</strong> <?php echo $book['category']; ?></p>
    <p><strong>Description:</strong> <?php echo $book['description']; ?></p>
    <p><strong>Price:</strong> ₹<?php echo $book['price']; ?></p>
    <p><strong>Average Rating:</strong> ⭐ <?php echo $avg_rating; ?> / 5</p>

    <div class="section">
        <h3>Owner Information</h3>
        <p><strong>Name:</strong> <?php echo $book['owner_name']; ?></p>
        <p><strong>Email:</strong> <?php echo $book['owner_email']; ?></p>
    </div>

    <div class="section">
        <h3>User Feedbacks</h3>
        <?php if (mysqli_num_rows($feedback_result) > 0): ?>
            <?php while ($fb = mysqli_fetch_assoc($feedback_result)) { ?>
                <div class="feedback">
                    <p><strong><?php echo $fb['user_name']; ?></strong> 
                    on <?php echo date("d M Y", strtotime($fb['date'])); ?>:</p>
                    <p class="rating">⭐ <?php echo $fb['rating']; ?> / 5</p>
                    <p><?php echo $fb['comment']; ?></p>
                </div>
            <?php } ?>
        <?php else: ?>
            <p>No feedback available.</p>
        <?php endif; ?>
    </div>

    <div class="section">
      <input type="hidden" name="bid" value="<?php echo $book['bid']; ?>">
        <?php if($book['status']=="available")
        {
          ?>
          <button><a href="rentalorder.php?bid=<?php echo $book['bid']; ?>" name="payment" style="color: white; text-decoration: none;" >rent now</a></button>
          <?php
        }
        else{
          ?>
          <button>Not Available</button>
          <?php
        } ?>
        <div style="margin-top: 10px;">
            <button onclick="history.back()">← Go Back</button>
        </div>
    </div>
</div>
</body>
</html>
