<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include '../db/connection.php';

if (!isset($_SESSION['uid'])) {
    echo "<script>alert('Please login first'); window.location.href='../mainlogin/login.html';</script>";
    exit();
}

$uid = $_SESSION['uid'];
$rid = $_GET['rid'] ?? null;

// ❌ If no RID found → invalid access
if (!$rid) {
    echo "<script>alert('Invalid Request'); window.location.href='order.php';</script>";
    exit();
}

// ✅ Fetch rental data using rid
$rental_q = mysqli_query($con, "SELECT * FROM rental_tb WHERE rid='$rid'");
$rental = mysqli_fetch_assoc($rental_q);

if (!$rental) {
    echo "<script>alert('Rental Not Found'); window.location.href='order.php';</script>";
    exit();
}

$bid = $rental['bid']; // IMPORTANT

// ❌ Prevent duplicate feedback
$check_feedback = mysqli_query($con, "SELECT * FROM feedback_tb WHERE rid='$rid'");
if (mysqli_num_rows($check_feedback) > 0) {
    echo "<script>alert('Feedback already submitted!'); window.location.href='order.php';</script>";
    exit();
}


// ---------------------------------------------------------
// 📌 Handle Feedback Submission
// ---------------------------------------------------------
if (isset($_POST['submit'])) {

    $feedback = mysqli_real_escape_string($con, $_POST['comment']);
    $rating = (int) $_POST['rating'];

    if ($rating < 1 || $rating > 5) {
        echo "<script>alert('Please select a rating');</script>";
    } else {

        // ⭐ Insert feedback using RID + BID + UID
        $query = "INSERT INTO feedback_tb (rid, uid, bid, comment, rating, date)
                  VALUES ('$rid', '$uid', '$bid', '$feedback', '$rating', NOW())";

        if (mysqli_query($con, $query)) {
            echo "<script>alert('Thanks for your feedback!'); window.location.href='order.php';</script>";
        } else {
            echo "Database Error: " . mysqli_error($con);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Rental Feedback</title>

  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f2f2f2;
      padding: 40px;
    }
    .feedback-box {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      max-width: 500px;
      margin: auto;
      box-shadow: 0 0 10px rgba(0,0,0,0.15);
    }
    .feedback-box h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    textarea {
      width: 100%;
      height: 120px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      resize: none;
      font-size: 16px;
    }

    .rating-stars {
      text-align: center;
      margin: 15px 0;
    }

    .star {
      font-size: 35px;
      cursor: pointer;
      color: #ccc;
      margin: 5px;
      transition: 0.2s;
    }

    .submit-btn {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 8px;
      background: #0058a3;
      color: white;
      font-size: 16px;
      cursor: pointer;
      margin-top: 10px;
    }
    .submit-btn:hover {
      background: #003f75;
    }

    .back-btn {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 8px;
      background: #6c757d;
      color: white;
      font-size: 16px;
      cursor: pointer;
      margin-top: 10px;
    }
    .back-btn:hover {
      background: #565e64;
    }
  </style>
</head>

<body>

<div class="feedback-box">
  <h2>How was your rental experience?</h2>

  <form method="POST">

    <textarea name="comment" placeholder="Write your experience here..." required></textarea>

    <!-- ⭐ Rating -->
    <div class="rating-stars" id="starContainer">
      <span class="star" data-value="1">★</span>
      <span class="star" data-value="2">★</span>
      <span class="star" data-value="3">★</span>
      <span class="star" data-value="4">★</span>
      <span class="star" data-value="5">★</span>
    </div>

    <input type="hidden" name="rating" id="ratingInput" value="0">

    <button type="submit" name="submit" class="submit-btn">Submit Feedback</button>
    <button type="button" onclick="window.location.href='order.php'" class="back-btn">
      Back
    </button>

  </form>
</div>

<script>
const stars = document.querySelectorAll(".star");
const ratingInput = document.getElementById("ratingInput");

stars.forEach(star => {
  star.addEventListener("click", () => {
    const rating = parseInt(star.getAttribute("data-value"));
    ratingInput.value = rating;

    stars.forEach(s => {
      s.style.color = (parseInt(s.getAttribute("data-value")) <= rating) ? "#ffc107" : "#ccc";
    });
  });

  star.addEventListener("mouseover", () => {
    const hoverVal = parseInt(star.getAttribute("data-value"));
    stars.forEach(s => {
      s.style.color = (parseInt(s.getAttribute("data-value")) <= hoverVal) ? "#ffc107" : "#ccc";
    });
  });

  star.addEventListener("mouseout", () => {
    const rating = parseInt(ratingInput.value);
    stars.forEach(s => {
      s.style.color = (parseInt(s.getAttribute("data-value")) <= rating) ? "#ffc107" : "#ccc";
    });
  });
});
</script>

</body>
</html>
