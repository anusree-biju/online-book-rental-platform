<?php
session_start();
include '../db/connection.php';

if (!isset($_SESSION['uid'])) {
    echo "<script>alert('Please login first'); window.location.href='../mainlogin/login.html';</script>";
    exit();
}

$user_id = $_SESSION['uid'];

// 🟡 1. Handle Add to Cart logic
if (isset($_POST['cart'])) {
    $book_id = $_POST['bid'];

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
$cart_query = "SELECT cid,book_tb.bid,book_tb.title, book_tb.author, book_tb.price, book_tb.image , book_tb.security 
               FROM cart_tb 
               JOIN book_tb ON cart_tb.bid = book_tb.bid 
               WHERE cart_tb.uid = '$user_id'";
$cart_result = mysqli_query($con, $cart_query);

if (!$cart_result) {
    die("Query failed: " . mysqli_error($con));
}

if (isset($_POST['delete']) && isset($_POST['cid'])) {
    $cid = intval($_POST['cid']);


    $delete_query = "DELETE FROM cart_tb WHERE cid = $cid ";
    $i=mysqli_query($con, $delete_query);
	if(!$i)
	{
		echo mysqli_error($con);
	}
	else
	{
		echo "<script>alert('successfully deleted'); window.location.href='cart.php';</script>";
	}

}


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
	<!-- Add this in the <head> of your HTML file -->
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

/* Hover effect */
.delete-btn:hover {
  background-color: #0e0e0eff;
}

/* Optional: icon style if using emoji or FontAwesome */
.delete-btn i {
  pointer-events: none;
}

	</style>
  </head>
  

	
<section id="center" class="center_shop clearfix">
 <div class="container">
  <div class="row">
    <div class="center_shop_1 clearfix">
	 <div class="col-sm-12">
	  <h5 class="mgt">
	   <a href="#">Home <i class="fa fa-long-arrow-right"></i> </a>
	   <a href="#">Cart</a>
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
	 <div class="col-sm-2">
	   <div class="cart_1i clearfix">
	    <h4 class="mgt col">PRODUCT</h4> 
	   </div>
	 </div>
	 <div class="col-sm-2">
	   <div class="cart_1i clearfix">
	    <h4 class="mgt col">NAME</h4> 
	   </div>
	 </div>
	 <div class="col-sm-2">
	   <div class="cart_1i clearfix">
	    <h4 class="mgt col">RENTAL</h4> 
	   </div>
	 </div>
	 <div class="col-sm-2">
	   <div class="cart_1i clearfix">
	    <h4 class="mgt col">SECURITY</h4> 
	   </div>
	 </div>
	 </div>
      <?php if (mysqli_num_rows($cart_result) > 0) { ?>
  <?php while ($row = mysqli_fetch_assoc($cart_result)) { ?>
	  
	</div>
	<div class="cart_2 clearfix">
	 <div class="col-sm-2">
	   <div class="cart_2i clearfix">
	    <img src="<?php echo $row['image']; ?>" height="100" alt="Book Image">
	   </div>
	 </div>
	 <div class="col-sm-2">
	   <div class="cart_2i clearfix">
	    <h4 class="mgt"><?php echo $row['title']; ?></h4>
		<p>Author: <?php echo $row['author'];?></p>
	   </div>
	 </div>
     <div class="col-sm-2">
	   <div class="cart_2i clearfix">
		<p> Price: ₹<?php echo $row['price']; ?></p>
	   </div>
	 </div>
	 <div class="col-sm-2">
	   <div class="cart_2i clearfix">
		<p> Price: ₹<?php echo $row['security']; ?></p>
	   </div>
	 </div>
	 <!-- Delete form -->
<form method="POST" action="cart.php" onsubmit="return confirm('Remove this book from cart?');" class="delete-form">
  <input type="hidden" name="cid" value= "<?php echo $row['cid']; ?>">
  <button type="submit" name="delete" class="delete-btn" title="Remove from Cart">
    <i class="fas fa-trash"></i>
  </button>
</form>
<button><a href="rentalorder.php?bid=<?php echo $row['bid']; ?>">rent now</a></botton>
	
       <?php } ?>
<?php } else { ?>
  <p>Your cart is empty.</p>
<?php } ?>
	
	

 	</div>
	
	 <div class="col-sm-4 space_left">
	  <div class="cart_3i clearfix">

	  </div>
	 </div>



<div class="col-sm-4 space_left">
  <div class="cart_3i1 clearfix">
    <h6><a class="button" href="sampleui.php">CONTINUE SHOPPING</a></h6>
  </div>
</div>



</section>

<script>
$(document).ready(function(){
	/*****Fixed Menu******/
	var secondaryNav = $('.cd-secondary-nav'),
	   secondaryNavTopPosition = secondaryNav.offset().top;
		$(window).on('scroll', function(){
			if($(window).scrollTop() > secondaryNavTopPosition ) {
				secondaryNav.addClass('is-fixed');	
			} else {
				secondaryNav.removeClass('is-fixed');
			}
		});	
		
});
</script>

<script type="text/javascript">
	$(document).on('click', '.number-spinner button', function () {    
	var btn = $(this),
		oldValue = btn.closest('.number-spinner').find('input').val().trim(),
		newVal = 0;
	
	if (btn.attr('data-dir') == 'up') {
		newVal = parseInt(oldValue) + 1;
	} else {
		if (oldValue > 1) {
			newVal = parseInt(oldValue) - 1;
		} else {
			newVal = 1;
		}
	}
	btn.closest('.number-spinner').find('input').val(newVal);
});
	</script>
</body>
 
</html>
