<?php
session_start();
include '../db/connection.php';

// ✅ Get book id and weeks from URL
$week = $_GET['weeks'];
$bid = $_GET['bid'];
$uid = $_SESSION['uid'];

// ✅ Fetch book details including price & security
$bookQuery = mysqli_query($con, "SELECT title, price, security FROM book_tb WHERE bid='$bid'");
$bookData = mysqli_fetch_assoc($bookQuery);

if (!$bookData) {
    die("Book not found!");
}

$price = $bookData['price'];           // base price per week
$security = $bookData['security']; // security deposit
$shipping = 20; // flat shipping cost

// ✅ Calculate total amounts
$subtotal = $price * $week;
$total = $subtotal + $security + $shipping;

// ✅ Handle checkout form submission
if (isset($_POST['checkout'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $district = $_POST['district'];
    $address = $_POST['address'];
    $pin = $_POST['pin'];
    $credit = $_POST['credit'];  // ✅ added line to get credit card number
    $payment_status = 'Paid';
    $date = date('Y-m-d H:i:s');

    // ✅ Calculate return date
    $returnDate = new DateTime($date);
    $returnDate->add(new DateInterval('P'.$week.'W'));
    $returnDateFormatted = $returnDate->format('Y-m-d H:i:s');
    
   $sql = mysqli_query($con, "
INSERT INTO rental_tb (bid, uid, week, status, rental_date, return_date, paid)
VALUES ('$bid', '$uid', '$week', 'rented', '$date', '$returnDateFormatted', '$total')
");


if ($sql) {
    $rid = mysqli_insert_id($con);

   // Insert into payment table
$q = mysqli_query($con, "
INSERT INTO payment_tb 
(rid, uid, amount, payment_status, payment_date, name, phno, district, address, postal_code, credit)
VALUES 
('$rid', '$uid', '$total', '$payment_status', '$date', '$name', '$phone', '$district', '$address', '$pin', '$credit')
");


    if (!$q) {
        echo "Error: " . mysqli_error($con);
    } else {
        mysqli_query($con, "UPDATE book_tb SET status = 'rented' WHERE bid = '$bid'");

              
            // Fetch owner and book details
                $ownerQuery = mysqli_query($con, "
                    SELECT b.title, u.username AS owner_name, u.email AS owner_email
                    FROM book_tb b
                    JOIN user_tb u ON b.uid = u.uid
                    WHERE b.bid = '$bid'
                ");
                $ownerData = mysqli_fetch_assoc($ownerQuery);

                $title = $ownerData['title'];
                $ownerName = $ownerData['owner_name'];
                $ownerEmail = $ownerData['owner_email'];

                // Insert permanent notification
               
            // ✅ Notify owner via message
            $bookQuery = mysqli_query($con, "
                SELECT b.title, b.uid AS owner_id, u.username AS owner_name
                FROM book_tb b
                JOIN user_tb u ON b.uid = u.uid
                WHERE b.bid = '$bid'
            ");
            $bookData = mysqli_fetch_assoc($bookQuery);

            if ($bookData) {
                $ownerId = $bookData['owner_id'];     
                $bookTitle = $bookData['title'];
                $ownerName = $bookData['owner_name'];

                // ✅ Prepare message with rental and return dates
                $message = "Hi $ownerName,\n\n"
                . "Your book \"$bookTitle\" has been successfully rented.\n\n"
                . "Renter Details:\n"
                . "- Name: $name\n"
                . "- Phone: $phone\n"
                . "- District: $district\n"
                . "- Address: $address\n"
                . "- Postal Code: $pin\n\n"
                . "Rental Date: $date\n"
                . "Return Date: $returnDateFormatted\n\n"
                . "Thank you!";


                mysqli_query($con, "
                    INSERT INTO messages_tb (receiver_id, owner_id, message, date)
                    VALUES ('$uid', '$ownerId', '".mysqli_real_escape_string($con, $message)."', '$date')
                ");
            }

            echo "<script>alert('✅ Rented! within one day it will delevered otherwise Please contact the seller.');window.location.href='rental.php';</script>";
        }

    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Checkout</title>
<link href="bootstrap.min.css" rel="stylesheet">
<link href="global.css" rel="stylesheet">
<link href="checkout.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="font-awesome.min.css" />
<link href="https://fonts.googleapis.com/css?family=Amaranth&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Alata&display=swap" rel="stylesheet">
<script src="js/jquery-2.1.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</head>

<body>
<section id="center" class="center_shop clearfix">
 <div class="container">
  <div class="row">
    <div class="center_shop_1 clearfix">
     <div class="col-sm-12">
      <h5 class="mgt">
       <a href="#">Home <i class="fa fa-long-arrow-right"></i> </a>
       <a href="#">Checkout</a>
      </h5>
     </div>
    </div>
  </div>
 </div>
</section>

<section id="checkout" class="clearfix">
 <div class="container">
  <div class="row">
   <div class="checkout_1 clearfix">
    <div class="col-sm-8">
      <div class="checkout_1l clearfix">
        <form method="post" id="checkoutForm">
       <h3 class="mgt">Make Your Checkout Here</h3>
       <p>Please fill out the form to complete your checkout</p>
      </div><br>

      <!-- FORM FIELDS -->
      <div class="checkout_1l1 clearfix">
       <div class="col-sm-6 space_left">
        <h5>Name<span class="col_3">*</span></h5>
        <input class="form-control" type="text" name="name" required>
       </div>
      </div>
      <div class="checkout_1l1 clearfix">
       <div class="col-sm-6 space_left">
        <h5>Phone Number <span class="col_3">*</span></h5>
        <input class="form-control" type="text" name="phone" id="phone" required>
       </div>
      </div>
      <div class="checkout_1l1 clearfix">
       <div class="col-sm-6 space_left">
        <h5>District<span class="col_3">*</span></h5>
        <input class="form-control" type="text" name="district" required>
       </div>
      </div>
      <div class="checkout_1l1 clearfix">
       <div class="col-sm-6 space_left">
        <h5>Address <span class="col_3">*</span></h5>
        <input class="form-control" type="text" name="address" required>
       </div>
      </div>
      <div class="checkout_1l1 clearfix">
       <div class="col-sm-6 space_left">
        <h5>Postal Code <span class="col_3">*</span></h5>
        <input class="form-control" type="text" name="pin" required>
       </div>
      </div>

      <!-- ✅ Added Credit Card Field -->
      <div class="checkout_1l1 clearfix">
       <div class="col-sm-6 space_left">
        <h5>Credit Card Number <span class="col_3">*</span></h5>
        <input class="form-control" type="text" name="credit" maxlength="16" required>
       </div>
      </div>
    </div>

    <!-- TOTALS SECTION -->
     <div class="col-sm-4">
       <div class="checkout_1r clearfix">
         <h4 class="mgt">TOTALS</h4>
         <hr class="hr_1">
        <h5>Price (<?php echo $week; ?> weeks) <span class="pull-right">₹<?php echo number_format($subtotal, 2); ?></span></h5>
        <h5>Security <span class="pull-right">₹<?php echo number_format($security, 2); ?></span></h5>
        <h5>Shipping <span class="pull-right">₹<?php echo number_format($shipping, 2); ?></span></h5>
        <hr> 
        <h5><b>Total</b> <span class="pull-right"><b>₹<?php echo number_format($total, 2); ?></b></span></h5><br>
         
         <h6><button type="submit" class="button" name="checkout">PROCEED TO CHECKOUT</button></h6>
         <h6><a class="button" href="sampleui.php">GO BACK</a></h6>
         </form>
       </div>
      </div>
   </div>
  </div>
 </div>
</section>

<!-- ✅ Add this script just before closing body -->
<script>
document.getElementById('checkoutForm').addEventListener('submit', function(e) {

  // -----------------------
  // 📌 Phone Number (10 digits)
  // -----------------------
  const phoneInput = document.getElementById('phone').value.trim();
  const phonePattern = /^[0-9]{10}$/;

  if (!phonePattern.test(phoneInput)) {
    e.preventDefault();
    alert('Please enter a valid 10-digit phone number.');
    document.getElementById('phone').focus();
    return;
  }

  // -----------------------
  // 📌 Postal Code (6 digits)
  // -----------------------
  const postalInput = document.querySelector('input[name="pin"]').value.trim();
  const postalPattern = /^[0-9]{6}$/;

  if (!postalPattern.test(postalInput)) {
    e.preventDefault();
    alert('Please enter a valid 6-digit Postal Code.');
    document.querySelector('input[name="pin"]').focus();
    return;
  }

  // -----------------------
  // 📌 Credit Card Number (16 digits)
  // -----------------------
  const creditInput = document.querySelector('input[name="credit"]').value.trim();
  const creditPattern = /^[0-9]{16}$/;

  if (!creditPattern.test(creditInput)) {
    e.preventDefault();
    alert('Please enter a valid 16-digit Credit Card Number.');
    document.querySelector('input[name="credit"]').focus();
    return;
  }
});
</script>


</body>
</html>