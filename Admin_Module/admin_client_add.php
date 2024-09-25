<?php include('includes/header.php'); ?>
<?php include('../includes/check_login.php'); ?>
<?php include('includes/right_sidebar.php'); ?>
<?php include('includes/scripts.php'); ?>

<?php
if (isset($_POST['add_client'])) {
    $client_name = mysqli_real_escape_string($conn, $_POST['client_name']);
    $contact_person = mysqli_real_escape_string($conn, $_POST['contact_person']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $query = "INSERT INTO tbl_keyclients (client_name, contact_person, contact_number, email, address) 
              VALUES ('$client_name', '$contact_person', '$contact_number', '$email', '$address')";
    mysqli_query($conn, $query) or die(mysqli_error($conn));

    echo "<script>alert('Key Client added successfully');</script>";
    echo "<script type='text/javascript'> document.location = 'admin_keyclient_manage.php'; </script>";
}
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
                                <h4>Add Key Client</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Add Key Client</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- Add Key Client Form -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 mb-30">
                        <div class="pd-20 card-box mb-30">
                            <form method="post">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Client Name</label>
                                            <input type="text" name="client_name" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Contact Person</label>
                                            <input type="text" name="contact_person" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Contact Number</label>
                                            <input type="text" name="contact_number" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Address :</label>
                                            <input name="address" type="text" class="form-control" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label style="font-size:16px;"><b></b></label>
                                            <div class="modal-footer justify-content-center">
                                                <button class="btn btn-primary" name="add_client" id="add_client" data-toggle="modal">Add Customer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            <?php include('includes/footer.php'); ?>
        </div>
    </div>
</body>
</html>
