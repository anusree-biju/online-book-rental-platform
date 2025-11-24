<?php
session_start();
include '../db/connection.php';

if (!isset($_SESSION['uid'])) {
    echo "<script>alert('Please login first'); window.location.href='../mainlogin/login.html';</script>";
    exit();
}

$user_id = $_SESSION['uid'];
$check_rental = mysqli_query($con, "SELECT * FROM rental_tb WHERE uid = '$user_id' AND status = 'rented'");

if (mysqli_num_rows($check_rental) > 0) {
    echo "<script>alert('You have already rented a book. Please return it before renting another.'); window.location.href='rental.php';</script>";
    exit();
}

// 🟡 1. Handle Add to Cart logic
if (isset($_POST['cart'])) {
    $book_id = intval($_POST['bid']);

    // Check if already in cart
    $check = mysqli_query($con, "SELECT * FROM cart_tb WHERE uid='$user_id' AND bid='$book_id'");
    if (mysqli_num_rows($check) == 0) {
        $insert = mysqli_query($con, "INSERT INTO cart_tb (uid, bid) VALUES ('$user_id', '$book_id')");

        if (!$insert) {
            die("Error adding to cart: " . mysqli_error($con));
        }
    }
}

// 🟢 2. Fetch Cart Items
if (isset($_GET['bid'])) {
    $bid = intval($_GET['bid']);
    $cart_query = "SELECT book_tb.bid, book_tb.title, book_tb.author, book_tb.price, book_tb.image, book_tb.security
               FROM book_tb
               WHERE book_tb.bid = $bid
               LIMIT 1";
} else {
    $cart_query = "SELECT cid, book_tb.bid, book_tb.title, book_tb.author, book_tb.price, book_tb.image, book_tb.security
               FROM cart_tb 
               JOIN book_tb ON cart_tb.bid = book_tb.bid 
               WHERE cart_tb.uid = '" . mysqli_real_escape_string($con, $user_id) . "'
               LIMIT 1";
}
$cart_result = mysqli_query($con, $cart_query);

if (!$cart_result) {
    die("Query failed: " . mysqli_error($con));
}

if (isset($_POST['delete']) && isset($_POST['cid'])) {
    $cid = intval($_POST['cid']);
    $delete_query = "DELETE FROM cart_tb WHERE cid = $cid ";
    $i = mysqli_query($con, $delete_query);
    if (!$i) {
        echo mysqli_error($con);
    } else {
        echo "<script>alert('successfully deleted'); window.location.href='cart.php';</script>";
    }
    exit();
}

// Default shipping fee (you had ₹20 hardcoded)
$shipping_fee = 20.00;

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Shop On</title>
<link href="bootstrap.min.css" rel="stylesheet">
<link href="global.css" rel="stylesheet">
<link href="cart.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="font-awesome.min.css" />
<link href="https://fonts.googleapis.com/css?family=Amaranth&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Alata&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="js/jquery-2.1.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<style>
/* Style for delete form */
.delete-form {
  display: inline-block;
  margin-top: 10px;
}
/* Style for delete button */
.delete-btn {
  background-color: #100f0fff;
  color: white;
  border: none;
  padding: 6px 10px;
  border-radius: 6px;
  cursor: pointer;
  font-size: 14px;
  transition: background-color 0.3s ease;
}
.delete-btn:hover {
  background-color: #0e0e0eff;
}
.delete-btn i { pointer-events: none; }
</style>
</head>
<body>

<section id="center" class="center_shop clearfix">
 <div class="container">
  <div class="row">
    <div class="center_shop_1 clearfix">
     <div class="col-sm-12">
      <h5 class="mgt">
       <a href="#">Home <i class="fa fa-long-arrow-right"></i> </a>
       <a href="#">order</a>
      </h5>
     </div>
    </div>
  </div>
 </div>
</section>

<section id="cart" class="clearfix">
 <div class="container">
  <div class="row">
    <div class="cart_1 clearfix">
     <div class="col-sm-2"><div class="cart_1i clearfix"><h4 class="mgt col">PRODUCT</h4></div></div>
     <div class="col-sm-2"><div class="cart_1i clearfix"><h4 class="mgt col">NAME</h4></div></div>
     <div class="col-sm-2"><div class="cart_1i clearfix"><h4 class="mgt col">RENTAL</h4></div></div>
     <div class="col-sm-2"><div class="cart_1i clearfix"><h4 class="mgt col">SECURITY</h4></div></div>
     <div class="col-sm-2"><div class="cart_1i clearfix"><h4 class="mgt col">WEEK</h4></div></div>
     <div class="col-sm-2"><div class="cart_1i clearfix"><h4 class="mgt col">TOTAL</h4></div></div>
    </div>

<?php if (mysqli_num_rows($cart_result) > 0) {
    $row = mysqli_fetch_assoc($cart_result);
    // sanitize outputs
    $bid = intval($row['bid']);
    $title = htmlspecialchars($row['title']);
    $author = htmlspecialchars($row['author']);
    $image = htmlspecialchars($row['image']);
    $weekly_price = floatval($row['price']); // price per week
    $security = floatval($row['security']);
    // initial week count
    $initial_weeks = 1;
    // compute initial amounts
    $subtotal = $weekly_price * $initial_weeks;
    $payable = $security + $shipping_fee + $subtotal;
?>
    <div class="cart_2 clearfix">
     <div class="col-sm-2">
       <div class="cart_2i clearfix">
        <img src="<?php echo $image; ?>" height="100" alt="Book Image">
       </div>
     </div>
     <div class="col-sm-2">
       <div class="cart_2i clearfix">
        <h4 class="mgt"><?php echo $title; ?></h4>
        <p>Author: <?php echo $author; ?></p>
       </div>
     </div>
     <div class="col-sm-2">
       <div class="cart_2i clearfix">
         <p> Price (per week): ₹<?php echo number_format($weekly_price, 2); ?></p>
       </div>
     </div>
     <div class="col-sm-2">
       <div class="cart_2i clearfix">
         <p> Security: ₹<?php echo number_format($security, 2); ?></p>
       </div>
     </div>
     <div class="col-sm-2">
       <div class="cart_2i clearfix">
        <div class="input-group number-spinner">
            <span class="input-group-btn">
                <button class="btn btn-default" data-dir="dwn" type="button"><span class="glyphicon glyphicon-minus"></span></button>
            </span>
            <input type="text" class="form-control text-center week-input" value="<?php echo $initial_weeks; ?>"
                    data-price="<?php echo $weekly_price; ?>" readonly> 
            <span class="input-group-btn">
                <button class="btn btn-default" data-dir="up" type="button"><span class="glyphicon glyphicon-plus"></span></button>
            </span>
        </div>
       </div>
     </div>
     <div class="col-sm-2">
       <div class="cart_2i clearfix">
         <p id="subtotal">₹<?php echo number_format($subtotal, 2); ?></p>
       </div>
     </div>
    </div>
<?php } else { ?>
    <div class="cart_2 clearfix">
      <div class="col-sm-12">
        <p>Your cart is empty.</p>
      </div>
    </div>
<?php } ?>

    <div class="col-sm-4 space_left">
      <div class="cart_3i clearfix"></div>
    </div>

<?php
// If no $row set, set defaults for display
if (!isset($row)) {
    $subtotal = 0.00;
    $security = 0.00;
    $payable = $shipping_fee;
    $weekly_price = 0.00;
    $bid = 0;
    $initial_weeks = 1;
}
?>

<!-- Checkout / summary -->
<div class="row">
  <div class="col-sm-12 text-right">
    <div class="cart-summary-box" style="display: inline-block; text-align: left;">
      <h5>Subtotal <span class="pull-right" id="display-subtotal">₹<?php echo number_format($subtotal, 2); ?></span></h5>
      <h5>Security <span class="pull-right" id="display-security">₹<?php echo number_format($security, 2); ?></span></h5>
      <h5>Shipping Fee <span class="pull-right" id="display-shipping">₹<?php echo number_format($shipping_fee, 2); ?></span></h5>
      <hr>
      <h5>You Pay <span class="pull-right" id="display-payable">₹<?php echo number_format($payable, 2); ?></span></h5>

      <?php if (mysqli_num_rows($cart_result) > 0) { ?>
        <!-- Checkout form: weeks and payable are sent via GET -->
        <form method="get" action="checkout.php" style="display: inline;" id="checkout-form">
          <input type="hidden" name="weeks" id="form-weeks" value="<?php echo $initial_weeks; ?>">
          <input type="hidden" name="payable" id="form-payable" value="<?php echo number_format($payable, 2, '.', ''); ?>">
          <input type="hidden" name="bid" id="form-bid" value="<?php echo $bid; ?>">
          <button type="submit" class="button">CHECKOUT</button>
        </form>
        <form method="get" action="rental.php" style="display: inline;">
          <button type="submit" class="button">BACK</button>
        </form>
      <?php } ?>
    </div>
  </div>
</div>

<h5>NOTE:</h5>
<h6>your security amount will be refunded after book returning..!</h6>
<h6>Please ensure the book reaches the owner within 7 days from the return date.
If the book is not delivered to the owner within this period, your security deposit will not be refunded, and you may temporarily lose access to rent other books until the return is confirmed.Your rental status will update automatically after the owner confirms the return.</h6>

</section>

<!-- jQuery from CDN -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
 integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js"></script>

<script>
$(document).ready(function(){
    // initialize values (from PHP)
    var weeklyPrice = parseFloat('<?php echo number_format($weekly_price, 2, '.', ''); ?>') || 0.0;
    var security = parseFloat('<?php echo number_format($security, 2, '.', ''); ?>') || 0.0;
    var shipping = parseFloat('<?php echo number_format($shipping_fee, 2, '.', ''); ?>') || 0.0;
    var weeksInput = $('.week-input');
    var currentWeeks = parseInt(weeksInput.val()) || 1;

    // Helper to update UI and hidden fields
    function updateTotals(weeks) {
        var subtotal = (weeks * weeklyPrice);
        // payable includes security and shipping
        var payable = subtotal + security + shipping;

        // format to 2 decimals for display
        var subtotalText = '₹' + subtotal.toFixed(2);
        var payableText = '₹' + payable.toFixed(2);

        $('#display-subtotal').text(subtotalText);
        $('#display-payable').text(payableText);
        $('#display-security').text('₹' + security.toFixed(2));
        $('#display-shipping').text('₹' + shipping.toFixed(2));

        // Update hidden fields (payable as number)
        $('#form-weeks').val(weeks);
        $('#form-payable').val(payable.toFixed(2));
    }

    // initial display
    updateTotals(currentWeeks);

    // Number spinner functionality
    $('.number-spinner button').click(function() {
        var btn = $(this);
        var input = btn.closest('.number-spinner').find('.week-input');
        var currentVal = parseInt(input.val());
        if (isNaN(currentVal) || currentVal < 1) currentVal = 1;

        if (btn.attr('data-dir') == 'up') {
            currentVal++;
        } else {
            if (currentVal > 1) {
                currentVal--;
            }
        }

        input.val(currentVal);
        updateTotals(currentVal);
    });

    // Optional: allow manual typing if you remove readonly, then watch input change
    // $('.week-input').on('input', function(){ ... });

    /Fixed Menu*/
    var secondaryNav = $('.cd-secondary-nav'),
       secondaryNavTopPosition = (secondaryNav.length) ? secondaryNav.offset().top : 0;
    $(window).on('scroll', function(){
        if($(window).scrollTop() > secondaryNavTopPosition ) {
            secondaryNav.addClass('is-fixed');
        } else {
            secondaryNav.removeClass('is-fixed');
        }
    });
});
</script>

</body>
</html>