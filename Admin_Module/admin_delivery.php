<?php include('includes/header.php'); ?>
<?php include('../includes/check_login.php'); ?>
<?php include('includes/right_sidebar.php'); ?>
<?php include('includes/scripts.php'); ?>

<?php
// Fetch all deliveries
$delivery_query = "SELECT d.*, k.client_name, p.product_name 
                FROM tbl_deliveries d
                LEFT JOIN tbl_keyclients k ON d.client_id = k.client_id
                LEFT JOIN tbl_products p ON d.product_id = p.product_id
                ORDER BY d.delivery_date DESC";
$delivery_result = mysqli_query($conn, $delivery_query);
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
                                <h4>Manage Deliveries</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Deliveries</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- Display Deliveries -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 mb-30">
                        <div class="pd-20 card-box mb-30">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Delivery Date</th>
                                        <th>Client Name</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Total Price</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($delivery = mysqli_fetch_assoc($delivery_result)) { ?>
                                        <tr>
                                            <td><?php echo htmlentities($delivery['delivery_date']); ?></td>
                                            <td><?php echo htmlentities($delivery['client_name']); ?></td>
                                            <td><?php echo htmlentities($delivery['product_name']); ?></td>
                                            <td><?php echo htmlentities($delivery['quantity']); ?></td>
                                            <td><?php echo htmlentities($delivery['total_price']); ?></td>
                                            <td><?php echo htmlentities($delivery['status']); ?></td>
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
