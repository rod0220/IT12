<?php include('includes/header.php')?>
<?php include('../includes/check_login.php')?>
<?php $get_id = $_GET['edit']; ?>

<?php
if (isset($_POST['update'])) {
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $customer_id = $_POST['customer_id'];

    $query = "UPDATE tbl_customers SET 
        first_name = '$first_name', 
        middle_name = '$middle_name', 
        last_name = '$last_name', 
        username = '$username', 
        phone_number = '$phone_number', 
        email = '$email', 
        address = '$address'
        WHERE customer_id = '$get_id'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Record Successfully Updated');</script>";
        echo "<script type='text/javascript'> document.location = 'admin_customer_manage.php'; </script>";
    } else {
        die(mysqli_error($conn));
    }
}
?>

<body>
    <div class="pre-loader">
        <div class="pre-loader-box">
            <div class="loader-logo"></div>
            <div class='loader-progress' id="progress_div">
                <div class='bar' id='bar1'></div>
            </div>
            <div class='percent' id='percent1'>0%</div>
            <div class="loading-text">
                Loading...
            </div>
        </div>
    </div>

    <?php include('includes/navbar.php')?>
    <?php include('includes/right_sidebar.php')?>
    <?php include('includes/left_sidebar.php')?>
    <div class="mobile-menu-overlay"></div>
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Customer Portal</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="admin_customer_manage.php">Customer Manage</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Customer Edit</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Edit Customer</h4>
                            <p class="mb-20"></p>
                        </div>
                    </div>
                    <div class="wizard-content">
                        <form method="post" action="">
                            <section>
                                <?php
                                $query = mysqli_query($conn, "SELECT * FROM tbl_customers WHERE customer_id = '$get_id'");
                                if ($query && mysqli_num_rows($query) > 0) {
                                    $row = mysqli_fetch_array($query);
                                ?>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>First Name :</label>
                                            <input name="first_name" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo htmlspecialchars($row['first_name']); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Middle Name :</label>
                                            <input name="middle_name" type="text" class="form-control" autocomplete="off" value="<?php echo htmlspecialchars($row['middle_name']); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Last Name :</label>
                                            <input name="last_name" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo htmlspecialchars($row['last_name']); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Username :</label>
                                            <input name="username" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo htmlspecialchars($row['username']); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Phone Number :</label>
                                            <input name="phone_number" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo htmlspecialchars($row['phone_number']); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Email :</label>
                                            <input name="email" type="email" class="form-control" required="true" autocomplete="off" value="<?php echo htmlspecialchars($row['email']); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Address :</label>
                                            <input name="address" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo htmlspecialchars($row['address']); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <!-- Empty column for spacing -->
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="modal-footer justify-content-center">
                                                <button class="btn btn-primary" name="update" id="update" type="submit">Update Customer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="customer_id" value="<?php echo htmlspecialchars($row['customer_id']); ?>">
                                <?php
                                } else {
                                    echo "<p>No customer found with the given ID.</p>";
                                }
                                ?>
                            </section>
                        </form>
                    </div>
                </div>
            </div>
            <?php include('includes/footer.php'); ?>
        </div>
    </div>
    <!-- js -->
    <?php include('includes/scripts.php')?>
</body>
</html>
