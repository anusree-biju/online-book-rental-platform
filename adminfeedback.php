<?php
include "../db/connection.php";
?>
<?php
if (isset($_POST['delete'])) {
    $delete_id = $_POST['delete_id'];
    mysqli_query($con, "DELETE FROM feedback_tb WHERE fid = '$delete_id'");
    echo "<script>alert('feedback deleted successfully'); window.location.href=window.location.href;</script>";
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title>Nice admin Template - The Ultimate Multipurpose admin template</title>
    <!-- Custom CSS -->
    <link href="assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <link href="assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<style>
    .navbar {
  display: flex;
  gap: 20px;
  background-color: #f8f9fa;
  padding: 12px 20px;
  border-bottom: 1px solid #ddd;
}

.navbar a {
  text-decoration: none;
  color: #333;
  font-weight: 500;
  padding: 8px 12px;
  border-radius: 6px;
  transition: background-color 0.3s, color 0.3s;
}

.navbar a:hover {
  background-color: #e0e0e0;
  color: #000;
}

/* Style logout link as button */
.navbar .btn-link {
  background-color: #ff4d4d;
  color: #fff;
}

.navbar .btn-link:hover {
  background-color: #e60000;
}

.table-responsive table.contact-list {
    width: 100%;
    border-collapse: collapse;
    background-color: #ffffff !important;
    font-family: 'Segoe UI', sans-serif;
}

.table-responsive table.contact-list thead {
    background-color: #2c3e50 !important;
    color: white;
}

.table-responsive table.contact-list thead th {
    padding: 12px 16px;
    font-size: 16px;
    text-align: left;
}

.table-responsive table.contact-list tbody tr {
    border-bottom: 1px solid #eee;
    transition: background-color 0.2s ease-in-out;
}

.table-responsive table.contact-list tbody tr:hover {
    background-color: #f1f1f1;
}

.table-responsive table.contact-list tbody td {
    padding: 12px 16px;
    font-size: 15px;
    color: #333;
}

</style>
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                        <i class="ti-menu ti-close"></i>
                    </a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <div class="navbar-brand">
                        <a href="index.html" class="logo">
                            <!-- Logo icon -->
                            <b class="logo-icon">
                                <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                                <!-- Dark Logo icon -->
                                <img src="assets/images/logo-icon.png" alt="homepage" class="dark-logo" />
                                <!-- Light Logo icon -->
                                <img src="assets/images/logo-light-icon.png" alt="homepage" class="light-logo" />
                            </b>
                            <!--End Logo icon -->
                            <!-- Logo text -->
                            <span class="logo-text">
                                <!-- dark Logo text -->
                                <img src="assets/images/logo-text.png" alt="homepage" class="dark-logo" />
                                <!-- Light Logo text -->
                                <img src="assets/images/logo-light-text.png" class="light-logo" alt="homepage" />
                            </span>
                        </a>
                        <a class="sidebartoggler d-none d-md-block" href="javascript:void(0)" data-sidebartype="mini-sidebar">
                            <i class="mdi mdi-toggle-switch mdi-toggle-switch-off font-20"></i>
                        </a>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="ti-more"></i>
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-left mr-auto">
                        <!-- <li class="nav-item d-none d-md-block">
                            <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar">
                                <i class="mdi mdi-menu font-24"></i>
                            </a>
                        </li> -->
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <li class="nav-item search-box">
                            <a class="nav-link waves-effect waves-dark" href="javascript:void(0)">
                                <div class="d-flex align-items-center">
                                    <i class="mdi mdi-magnify font-20 mr-1"></i>
                                    <div class="ml-1 d-none d-sm-block">
                                        <span>Search</span>
                                    </div>
                                </div>
                            </a>
                            <form class="app-search position-absolute">
                                <input type="text" class="form-control" placeholder="Search &amp; enter">
                                <a class="srh-btn">
                                    <i class="ti-close"></i>
                                </a>
                            </form>
                        </li>
                    </ul>
                    <!-- ============================================================== -->
                    
                        <div class="navbar">
                            <a href="index%20.html">home</a>
                            <a href="profile.php">Profile</a>
                            <a href="logout.php">logout</a>
                            
                        </div>
                    <!-- ============================================================== -->

                   
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <i class="mdi mdi-av-timer"></i>
                                <span class="hide-menu">Dashboard </span>
                                <span class="badge badge-pill badge-info ml-auto m-r-15">3</span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level">

                                <li class="sidebar-item">
                                    <a href="index%20.html" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu"> home</span>
                                    </a>
                                </li>

                                <li class="sidebar-item">
                                    <a href="index1.php" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu"> book-list</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="index2.php" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu"> book-details </span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="index3.php" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu">requests</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                                              
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <i class="ti-bookmark"></i>
                                <span class="hide-menu">rental management</span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item">
                                    <a href="rental-list.php" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu"> rental List </span>
                                    </a>
                                </li>
                                
                                <li class="sidebar-item">
                                    <a href="adminfeedback.php" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu"> feedbacks </span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="adminpayment.php" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu"> payments </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <!--    
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <i class="mdi mdi-cart-outline"></i>
                                <span class="hide-menu">Ecommerce Pages</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item">
                                    <a href="eco-products.html" class="sidebar-link">
                                        <i class="mdi mdi-cards-variant"></i>
                                        <span class="hide-menu">Products</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="eco-products-cart.html" class="sidebar-link">
                                        <i class="mdi mdi-cart"></i>
                                        <span class="hide-menu">Products Cart</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="eco-products-edit.html" class="sidebar-link">
                                        <i class="mdi mdi-cart-plus"></i>
                                        <span class="hide-menu">Products Edit</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="eco-products-detail.html" class="sidebar-link">
                                        <i class="mdi mdi-camera-burst"></i>
                                        <span class="hide-menu">Product Details</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="eco-products-orders.html" class="sidebar-link">
                                        <i class="mdi mdi-chart-pie"></i>
                                        <span class="hide-menu">Product Orders</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="eco-products-checkout.html" class="sidebar-link">
                                        <i class="mdi mdi-clipboard-check"></i>
                                        <span class="hide-menu">Products Checkout</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    -->    
                        
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <i class="mdi mdi-account-multiple"></i>
                                <span class="hide-menu">Users</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item">
                                    <a href="table-footable.php" class="sidebar-link">
                                        <i class="mdi mdi-account-box"></i>
                                        <span class="hide-menu"> Users list</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="pages-profile.php" class="sidebar-link">
                                        <i class="mdi mdi-account-network"></i>
                                        <span class="hide-menu"> Users Profile</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="contact1.php" class="sidebar-link">
                                        <i class="mdi mdi-account-star-variant"></i>
                                        <span class="hide-menu"> User Contact</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="logout.php" aria-expanded="false">
                                <i class="mdi mdi-directions"></i>
                                <span class="hide-menu">LogOut</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-5 align-self-center">
                        <h2 class="page-title" style="margin-bottom: 10px;">Dashboard</h2>
                    </div>
                    <div class="col-7 align-self-center">
                        <div class="d-flex align-items-center justify-content-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Sales chart -->
                <!-- ============================================================== -->

                <!-- Book Summary Cards -->
                <div class="table-responsive">
    <table id="demo-foo-addrow" class="table m-t-30 no-wrap table-hover contact-list" data-page-size="10">
        <thead>
            <tr>
                <th>Feedback ID</th>
                <th>User Name</th>
                <th>Book Title</th>
                <th>Comment</th>
                <th>Rating</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include '../db/connection.php'; // Adjust path if needed

            $query = mysqli_query($con, "
                SELECT f.*, u.username, b.title 
                FROM feedback_tb f
                JOIN user_tb u ON f.uid = u.uid
                JOIN book_tb b ON f.bid = b.bid
            ");

            while ($row = mysqli_fetch_assoc($query)) {
            ?>
            <tr>
                <td><?php echo $row['fid']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['comment']; ?></td>
                <td><?php echo $row['rating']; ?></td>
                <td><?php echo $row['date']; ?></td>
                <td>
                     <!-- Delete Button -->
                    <form method="POST" action="" style="display:inline;">
                    <input type="hidden" name="delete_id" value="<?php echo $row['fid']; ?>">
                    <button type="submit" name="delete" class="btn btn-danger btn-sm" onclick="return confirm('Delete this feedback?')">delete</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>



                
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                All Rights Reserved by Nice admin. Designed and Developed by
                <a href="https://wrappixel.com">WrapPixel</a>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    
    <div class="chat-windows"></div>
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="dist/js/app.min.js"></script>
    <script src="dist/js/app.init.mini-sidebar.js"></script>
    <script src="dist/js/app-style-switcher.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="dist/js/custom.min.js"></script>
    <!--This page JavaScript -->
    <!--chartis chart-->
    <script src="assets/libs/chartist/dist/chartist.min.js"></script>
    <script src="assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <!--c3 charts -->
    <script src="assets/extra-libs/c3/d3.min.js"></script>
    <script src="assets/extra-libs/c3/c3.min.js"></script>
    <script src="assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js"></script>
    <script src="dist/js/pages/dashboards/dashboard1.js"></script>
</body>

</html>