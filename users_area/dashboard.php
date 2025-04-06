<?php
// Start the session
session_start();
// Check if the logout link is clicked
if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    // Destroy all session variables and the session itself
    session_unset();
    session_destroy();

    // Redirect the user to the login page after logging out
    header("Location: index-4.php"); // Replace 'login.php' with your actual login page
    exit();
}



// Now, you can use $_SESSION['username'] for the logged-in user's username
// Check if the user is logged in by verifying the session variable
if (isset($_SESSION['username'])) {
    // Display the username if logged in
    echo "Welcome, " . $_SESSION['username'];
} else {
    // If the user is not logged in, you can display a message or leave it blank
    echo "Please log in to continue.";
}
?>
<?php
include('../includes/connect.php');
include('../functions/common_function.php');
include('update_shipping.php');

?>
<?php
// Fetch user data from the database
$user_id = $_SESSION['user_id']; // Assuming user is logged in
$query = "SELECT shipping_address FROM user_table WHERE user_id = '$user_id'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

// Check if the shipping address exists
$shipping_address = !empty($row['shipping_address']) ? $row['shipping_address'] : null;
?>

<?php
// Assuming you have already started the session

$user_id = $_SESSION['user_id']; // Get the logged-in user ID



// Query to fetch user data based on user_id
$query = "SELECT * FROM user_table WHERE user_id = '$user_id'";
$result = mysqli_query($con, $query);

// Check if the user exists
if (mysqli_num_rows($result) > 0) {
    // Fetch the user data
    $user_data = mysqli_fetch_assoc($result);

    // Assign the fetched data to variables
    $user_full_name = $user_data['user_full_name'];
    $user_email = $user_data['user_email'];
    $username = $user_data['username'];
    $user_mobile = $user_data['user_mobile'];
    $user_country_name = $user_data['user_country_name'];
    $user_street_name = $user_data['user_street_name'];
    $user_town_city = $user_data['user_town_city'];
    $user_state_country = $user_data['user_state_country'];
    $user_post_zip = $user_data['user_post_zip'];
    // You can add more variables as needed
} else {
    echo "No user data found!";
}
?>

<!DOCTYPE html>
<html lang="en">


<!-- molla/dashboard.html  22 Nov 2019 10:03:13 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Molla - Bootstrap eCommerce Template</title>
    <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="Molla - Bootstrap eCommerce Template">
    <meta name="author" content="p-themes">
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/icons/favicon-16x16.png">
    <link rel="manifest" href="../assets/images/icons/site.html">
    <link rel="mask-icon" href="../assets/images/icons/safari-pinned-tab.svg" color="#666666">
    <link rel="shortcut icon" href="../assets/images/icons/favicon.ico">
    <meta name="apple-mobile-web-app-title" content="Molla">
    <meta name="application-name" content="Molla">
    <meta name="msapplication-TileColor" content="#cc9966">
    <meta name="msapplication-config" content="../assets/images/icons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="../assets/css/style.css">
	<style>
    .table.borderless td, .table.borderless th {
        border: none;
		padding: 3px;
    }

    .product-col {
        width: 20%; /* Adjust the width percentage as per your design */
    }

    .price-col {
        width: 10%; /* Adjust the width percentage as per your design */
    }
</style>
<style>
    .table-borderless td, .table-borderless th {
        border: none;
    }

    /* Adjust the horizontal line */
    .table-borderless hr {
        height: 1px; /* Make the line thinner */
        border: none;
        background-color: #ccc; /* Line color */
        margin: 2px 0; /* Reduce space above and below the line */
    }

    /* Reduce the height of the row */
    .table-borderless tr {
        height: 20px; /* Adjust this value to reduce row height */
    }
	
</style>




</head>

<body>
    <div class="page-wrapper"> 
        <!-- //include header// -->
    <?php include("../includes/header.php")?>

        <main class="main">
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">My Account<span>Shop</span></h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Shop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Account</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
            	<div class="dashboard">
	                <div class="container">
	                	<div class="row">
	                		<aside class="col-md-4 col-lg-3">
	                			<ul class="nav nav-dashboard flex-column mb-3 mb-md-0" role="tablist">
								    <li class="nav-item">
								        <a class="nav-link active" id="tab-dashboard-link" data-toggle="tab" href="#tab-dashboard" role="tab" aria-controls="tab-dashboard" aria-selected="true">Dashboard</a>
								    </li>
								    <li class="nav-item">
								        <a class="nav-link" id="tab-orders-link" data-toggle="tab" href="#tab-orders" role="tab" aria-controls="tab-orders" aria-selected="false">Orders</a>
								    </li>
								    <li class="nav-item">
								        <a class="nav-link" id="tab-downloads-link" data-toggle="tab" href="#tab-downloads" role="tab" aria-controls="tab-downloads" aria-selected="false">Delete Account</a>
								    </li>
								    <li class="nav-item">
								        <a class="nav-link" id="tab-address-link" data-toggle="tab" href="#tab-address" role="tab" aria-controls="tab-address" aria-selected="false">Adresses</a>
								    </li>
								    <li class="nav-item">
								        <a class="nav-link" id="tab-account-link" data-toggle="tab" href="#tab-account" role="tab" aria-controls="tab-account" aria-selected="false">Account Edit</a>
								    </li>
                                    <li class="nav-item">
                                    <a class="nav-link" href="?logout=true">Sign Out</a>
                                    </li>

								</ul>
	                		</aside><!-- End .col-lg-3 -->

	                		<div class="col-md-8 col-lg-9">
	                			<div class="tab-content">
								    <div class="tab-pane fade show active" id="tab-dashboard" role="tabpanel" aria-labelledby="tab-dashboard-link">
								    	<p>Hello <span class="font-weight-normal text-dark">User</span> (not <span class="font-weight-normal text-dark">User</span>? <a href="#">Log out</a>) 
								    	<br>
								    	From your account dashboard you can view your <a href="#tab-orders" class="tab-trigger-link link-underline">recent orders</a>, manage your <a href="#tab-address" class="tab-trigger-link">shipping and billing addresses</a>, and <a href="#tab-account" class="tab-trigger-link">edit your password and account details</a>.</p>
								    </div><!-- .End .tab-pane -->

								    <?php
$user_id = $_SESSION['user_id']; // Assuming user is logged in
$query = "SELECT * FROM user_orders WHERE user_id = '$user_id'";
$result = mysqli_query($con, $query);
?>

<div class="tab-pane fade" id="tab-orders" role="tabpanel" aria-labelledby="tab-orders-link">
    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="table-responsive ">
            <table class="table borderless ">
                <thead>
                    <tr>
                        
                        <th>Products</th>
                        <th>Amount Due</th>
                        <th>Invoice Number</th>
                        <th>Order Date</th>
                        <th>Payment </th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
    <td class='product-col' style="font-size: small;">
        <div class='product'>
            <h3 class='product-title' style="font-size: small;">
                <?php echo $row['products_name']; ?>
            </h3>
        </div>
    </td>
    <td class='price-col' style="font-size: small;">$<?php echo $row['amount_due']; ?></td>
    <td style="font-size: small;"><?php echo $row['invoice_number']; ?></td>
    <td style="font-size: small;"><?php echo $row['order_date']; ?></td>
    <td style="font-size: small;"><?php echo $row['payment_method']; ?></td>
    <td style="font-size: small;"><?php echo ucfirst($row['order_status']); ?></td>
</tr>
                        <tr><td colspan="7"><hr></td></tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>No order has been made yet.</p>
        <a href="category.html" class="btn btn-outline-primary-2">
            <span>GO SHOP</span>
            <i class="icon-long-arrow-right"></i>
        </a>
    <?php endif; ?>
</div>

<style>
    .table.borderless td, .table.borderless th {
        border: none;
    }
</style>


								    <div class="tab-pane fade" id="tab-downloads" role="tabpanel" aria-labelledby="tab-downloads-link">
								    	<p>Are you sure you want to delete the account ,once deleted can not recovered.</p>
								    	<a href="category.html" class="btn btn-outline-primary-2"><span>CONFIRM DELETE</span><i class="icon-long-arrow-right"></i></a>
								    </div><!-- .End .tab-pane -->

								    <div class="tab-pane fade" id="tab-address" role="tabpanel" aria-labelledby="tab-address-link">
								    	<p>The following addresses will be used on the checkout page by default.</p>

								    	<?php
// Assuming you have a valid database connection
$user_id = $_SESSION['user_id']; // Get user_id from session (assuming user is logged in)
$query = "SELECT username, user_email, user_mobile, user_street_name, user_town_city, user_state_country, user_post_zip, user_country_name FROM user_table WHERE user_id = '$user_id'";
$result = mysqli_query($con, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $username = $row['username'];
    $email = $row['user_email'];
    $mobile = $row['user_mobile'];
    $street_name = $row['user_street_name'];
    $town_city = $row['user_town_city'];
    $state_country = $row['user_state_country'];
    $post_zip = $row['user_post_zip'];
    $country = $row['user_country_name'];
} else {
    // Handle case if no user data is found
    $username = "N/A";
    $email = "N/A";
    $mobile = "N/A";
    $street_name = "N/A";
    $town_city = "N/A";
    $state_country = "N/A";
    $post_zip = "N/A";
    $country = "N/A";
}
?>

<div class="row">
    <div class="col-lg-6">
        <div class="card card-dashboard">
            <div class="card-body">
                <h3 class="card-title">Billing Address</h3><!-- End .card-title -->
                <p>
                    <?php echo $username; ?><br>
                    <?php echo $street_name; ?><br>
                    <?php echo $town_city . ', ' . $state_country . ' ' . $post_zip; ?><br>
                    <?php echo $country; ?><br>
                    <?php echo $mobile; ?><br>
                    <?php echo $email; ?><br>
                    <a href="#tab-account" class="tab-trigger-link">Edit <i class="icon-edit"></i></a>
                </p>
            </div><!-- End .card-body -->
        </div><!-- End .card-dashboard -->
    </div><!-- End .col-lg-6 -->

    <div class="col-lg-6">
    <div class="card card-dashboard">
        <div class="card-body">
            <h3 class="card-title">Shipping Address</h3><!-- End .card-title -->

            <p id="shippingAddressText">
                <?php if ($shipping_address): ?>
                    <?php echo $shipping_address; ?>
                <?php else: ?>
                    You have not set up this type of address yet.
                <?php endif; ?>
            </p>

            <!-- Edit Button -->
            <a href="update_shipping.php" id="editShippingBtn"><i class="icon-edit"></i> Edit</a>

            <!-- Hidden Form for Updating Address -->
            <form id="shippingAddressForm" method="POST" action="update_shipping.php" style="display: none;">
                <input type="text" name="shipping_address" id="shippingInput" 
                    value="<?php echo htmlspecialchars($shipping_address); ?>" required>
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <button type="submit">Save</button>
            </form>
        </div><!-- End .card-body -->
    </div><!-- End .card-dashboard -->
</div><!-- End .col-lg-6 -->

<script>
    document.getElementById('editShippingBtn').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('shippingAddressText').style.display = 'none';
        document.getElementById('editShippingBtn').style.display = 'none';
        document.getElementById('shippingAddressForm').style.display = 'block';
    });
</script>
</div><!-- End .row -->

								    </div><!-- .End .tab-pane -->

								    <div class="tab-pane fade" id="tab-account" role="tabpanel" aria-labelledby="tab-account-link">
    <form action="update_account.php" method="POST" enctype="multipart/form-data">
        <div class="row">
            <!-- Full Name -->
            <div class="col-sm-6">
                <label>Full Name *</label>
                <input type="text" class="form-control" name="full_name" value="<?php echo $user_full_name; ?>" required>
            </div><!-- End .col-sm-6 -->

            <!-- Email -->
            <div class="col-sm-6">
                <label>Email Address *</label>
                <input type="email" class="form-control" name="email" value="<?php echo $user_email; ?>" required>
            </div><!-- End .col-sm-6 -->
        </div><!-- End .row -->

        <!-- Username -->
        <label>Username *</label>
        <input type="text" class="form-control" name="username" value="<?php echo $username; ?>" required>

        <!-- Mobile Number -->
        <label>Mobile Number</label>
        <input type="text" class="form-control" name="mobile" value="<?php echo $user_mobile; ?>">

        <!-- Country -->
        <label>Country</label>
        <input type="text" class="form-control" name="country" value="<?php echo $user_country_name; ?>">

        <!-- Street Name -->
        <label>Street Address</label>
        <input type="text" class="form-control" name="street_name" value="<?php echo $user_street_name; ?>">

        <!-- City -->
        <label>City</label>
        <input type="text" class="form-control" name="city" value="<?php echo $user_town_city; ?>">

        <!-- State/Province -->
        <label>State/Province</label>
        <input type="text" class="form-control" name="state" value="<?php echo $user_state_country; ?>">

        <!-- Postal Code -->
        <label>Postal Code</label>
        <input type="text" class="form-control" name="postal_code" value="<?php echo $user_post_zip; ?>">

        <!-- Profile Picture -->
        <label>Profile Picture</label>
        <input type="file" class="form-control" name="profile_image">

        <!-- Current Password (Required for Changes) -->
        <label>Current Password *</label>
        <input type="password" class="form-control" name="current_password" required>

        <!-- New Password -->
        <label>New Password (Leave blank to keep current password)</label>
        <input type="password" class="form-control" name="new_password">

        <!-- Confirm New Password -->
        <label>Confirm New Password</label>
        <input type="password" class="form-control mb-2" name="confirm_new_password">

        <button type="submit" class="btn btn-outline-primary-2">
            <span>SAVE CHANGES</span>
            <i class="icon-long-arrow-right"></i>
        </button>
    </form>
</div><!-- .End .tab-pane -->

								</div>
	                		</div><!-- End .col-lg-9 -->
	                	</div><!-- End .row -->
	                </div><!-- End .container -->
                </div><!-- End .dashboard -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->

          <!-- //include footer// -->
          <?php include("../includes/footer.php")?>

</div><!-- End .page-wrapper -->
<button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>


    <!-- Plugins JS File -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery.hoverIntent.min.js"></script>
    <script src="assets/js/jquery.waypoints.min.js"></script>
    <script src="assets/js/superfish.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <!-- Main JS File -->
    <script src="assets/js/main.js"></script></body>


<!-- molla/dashboard.html  22 Nov 2019 10:03:13 GMT -->
</html>