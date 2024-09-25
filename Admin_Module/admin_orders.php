<?php include('includes/header.php'); ?>
<?php include('../includes/check_login.php'); ?>
<?php include('includes/right_sidebar.php'); ?>
<?php include('includes/scripts.php'); ?>

<?php
// Handle order addition
if (isset($_POST['add_order'])) {
    $customer_id = $_POST['customer_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    
    // Fetch product price
    $product_query = mysqli_query($conn, "SELECT price_per_unit FROM tbl_products WHERE product_id = '$product_id'") or die(mysqli_error($conn));
    $product = mysqli_fetch_assoc($product_query);
    $price_per_unit = $product['price_per_unit'];
    
    // Calculate total price
    $total_price = $quantity * $price_per_unit;
    
    // Insert the new order into the database
    $query = mysqli_query($conn, "INSERT INTO tbl_orders (customer_id, product_id, quantity, total_price, order_date, status) 
        VALUES ('$customer_id', '$product_id', '$quantity', '$total_price', CURDATE(), 'Pending')") or die(mysqli_error($conn));

    echo "<script>alert('Order added successfully');</script>";
    echo "<script type='text/javascript'> document.location = 'admin_orders.php'; </script>";
}

// Fetch all order records
$order_query = "SELECT o.*, 
                CONCAT(c.first_name, ' ', c.middle_name, ' ', c.last_name) AS customer_name, 
                p.product_name 
                FROM tbl_orders o 
                LEFT JOIN tbl_customers c ON o.customer_id = c.customer_id
                LEFT JOIN tbl_products p ON o.product_id = p.product_id
                ORDER BY o.order_date DESC";
$order_result = mysqli_query($conn, $order_query);
?>

<body>
    <?php include('includes/navbar.php'); ?>
    <?php include('includes/left_sidebar.php'); ?>
    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Order Management</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Orders</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Add Order Form -->
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-30">
                        <div class="pd-20 card-box mb-30" style="background-color: white;">
                            <div class="clearfix">
                                <div class="pull-left">
                                    <h4 class="text-blue h4">Add New Order</h4>
                                    <p class="mb-20"></p>
                                </div>
                            </div>
                            <form method="post" action="">
                                <div class="form-group">
                                    <label>Customer ID</label>
                                    <input name="customer_id" type="number" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Product ID</label>
                                    <input name="product_id" type="number" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input name="quantity" type="number" class="form-control" required>
                                </div>
                                <div class="text-right">
                                    <input class="btn btn-primary" type="submit" value="Add Order" name="add_order">
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Display Existing Orders -->
                    <div class="col-lg-8 col-md-6 col-sm-12 mb-30">
                        <div class="pd-20 card-box mb-30" style="background-color: white;">
                            <h4 class="text-blue h4">Orders</h4>
                            <br>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Order Date</th>
                                        <th>Customer Name</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Total Price</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($order = mysqli_fetch_assoc($order_result)) { ?>
                                        <tr>
                                            <td><?php echo htmlentities($order['order_date']); ?></td>
                                            <td><?php echo htmlentities($order['customer_name']); ?></td>
                                            <td><?php echo htmlentities($order['product_name']); ?></td>
                                            <td><?php echo htmlentities($order['quantity']); ?></td>
                                            <td><?php echo htmlentities($order['total_price']); ?></td>
                                            <td><?php echo htmlentities($order['status']); ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('includes/footer.php'); ?>
        
        </div>
    </div>
</body>

</html>
