<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['admin_name']; ?>!</h1>
    <!-- Rest of your admin dashboard content --></body>
</html>
<?php
include('../includes/connect.php');
?>
<body>
    <div class="page-wrapper">
        <header class="header header-intro-clearance header-4">
            <div class="header-top">
                <div class="container">
                    <div class="header-left">
                        <a href="tel:#"><i class="icon-phone"></i>Call: +0123 456 789</a>
                    </div><!-- End .header-left -->
                    <div class="header-right">
                        <ul class="top-menu">
                            <li>
                                <a href="#">Links</a>
                                <ul>
                                    <li>
                                        <div class="header-dropdown">
                                            <a href="#">English</a>
                                            <div class="header-menu">
                                                <ul>
                                                    <li><a href="#">English</a></li>
                                                    <li><a href="#">Hindi</a></li>
                                                    <li><a href="#">Tamil</a></li>
                                                </ul>
                                            </div><!-- End .header-menu -->
                                        </div>
                                    </li>
                                    <li><a href="/Ai_driven_ecommerce/admin_area/admins_registration.php" >Sign in / Sign up</a></li>
                                </ul>
                            </li>
                        </ul><!-- End .top-menu -->
                    </div><!-- End .header-right -->
                </div><!-- End .container -->
            </div><!-- End .header-top -->
            <div class="header-bottom sticky-header">
                <div class="container">
                    <div class="header-left">
                        

                        <a href="index.php" class="logo">
                            <img src="../assets/images/demos/demo-4/logo.png" alt="Molla Logo" width="105" height="25">
                        </a>
                    </div><!-- End .header-left -->


                </div><!-- End .container -->
            </div><!-- End .header-bottom sticky-header -->

        </header><!-- End .header -->

        <!-- .Second child -->
        <div>

            <div class="bg-light">
                <h3 class="text-center p-2">Manage Details</h3>
            </div>
        </div>
        <!--End .Second child -->

        <!--third-child-->
        <div class="row">
            <div class="col-md-12 bg-secondary p-1 d-flex align-items-center">
                <div class="p-3">
                    <a href="#"><img src="../assets/images/team/member-2.jpg." alt="" class=admin_image></a>
                    <p class="text=light text-center">Admin name</p>
                </div>
                <div class="button text-center">
                    <button class="my-3"><a href="insert_product.php" class="nav-link text-light bg-info my-1">Insert Product</a></button>
                    <button class="my-3"><a href="index.php?view_products"class="nav-link text-light bg-info my-1">View Product</a></button>
                    <button class="my-3"><a href="index.php?insert_categories"class="nav-link text-light bg-info my-1">Insert Categories</a></button>
                    <button class="my-3"><a href="index.php?view_categories"class="nav-link text-light bg-info my-1">View Categories</a></button>
                    <button class="my-3"><a href="index.php?insert_brands"class="nav-link text-light bg-info my-1">Insert brands</a></button>
                    <button class="my-3"><a href="index.php?view_brands"class="nav-link text-light bg-info my-1">View Brands</a></button>
                    <button class="my-3"><a href="index.php?insert_websites"class="nav-link text-light bg-info my-1">Insert website</a></button>
                    <button class="my-3"><a href="index.php?view_websites"class="nav-link text-light bg-info my-1">View website</a></button>
                    <button class="my-3"><a href="index.php?all_orders"class="nav-link text-light bg-info my-1">All orders</a></button>
                    <button class="my-3"><a href="index.php?all_payments"class="nav-link text-light bg-info my-1">AllPayments</a></button>
                    <button class="my-3"><a href="index.php?list_users"class="nav-link text-light bg-info my-1">List User</a></button>
                    <button class="my-3"><a href=""class="nav-link text-light bg-info my-1">Logout</a></button>
                    
                </div>
            </div><!--End .col-md-12 bg-secoundary p-1-->
        </div><!--End .third-child-->
       
        <!-- .Fourth child -->
         <div class="container my-3">
            <?php
            if(isset($_GET['insert_categories'])){
                include("insert_categories.php");
            }
            if(isset($_GET['insert_brands'])){
                include("insert_brands.php");
            }
            if(isset($_GET['view_products'])){
                include("view_products.php");
            }
            if(isset($_GET['edit_products'])){
                include("edit_products.php");
            }
            if(isset($_GET['view_categories'])){
                include("view_categories.php");
            }
            if(isset($_GET['view_brands'])){
                include("view_brands.php");
            }
            if(isset($_GET['insert_websites'])){
                include("insert_websites.php");
            }
            if(isset($_GET['view_websites'])){
                include("view_websites.php");
            }
            if(isset($_GET['all_orders'])){
                include("all_orders.php");
            }
            if(isset($_GET['all_payments'])){
                include("all_payments.php");
            }
            if(isset($_GET['list_users'])){
                include("list_users.php");
            }
            ?>
         </div>


    </div><!-- End .page-wrapper --></body>
<script>
        function logout() {
            let confirmLogout = confirm("Are you sure you want to log out?");
            if (confirmLogout) {
                // Replace with your logout logic
                alert("Logging out...");
                // For example, redirect to a logout URL
                window.location.href = "logout_url";
            } else {
                alert("Logout cancelled.");
            }
        }
    </script>

</html>