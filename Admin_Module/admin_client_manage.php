<?php include('includes/header.php'); ?>
<?php include('../includes/check_login.php'); ?>
<?php include('includes/right_sidebar.php'); ?>
<?php include('includes/scripts.php'); ?>

<?php
// Fetch all key clients
$client_query = "SELECT * FROM tbl_keyclients ORDER BY created_at DESC";
$client_result = mysqli_query($conn, $client_query);
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
                                <h4>Manage Key Clients</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Key Clients</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- Display Key Clients -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 mb-30">
                        <div class="pd-20 card-box mb-30">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Client Name</th>
                                        <th>Contact Person</th>
                                        <th>Contact Number</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($client = mysqli_fetch_assoc($client_result)) { ?>
                                        <tr>
                                            <td><?php echo htmlentities($client['client_name']); ?></td>
                                            <td><?php echo htmlentities($client['contact_person']); ?></td>
                                            <td><?php echo htmlentities($client['contact_number']); ?></td>
                                            <td><?php echo htmlentities($client['email']); ?></td>
                                            <td><?php echo htmlentities($client['address']); ?></td>
                                            <td><?php echo htmlentities($client['created_at']); ?></td>
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
