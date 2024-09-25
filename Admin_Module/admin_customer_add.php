<?php include('includes/header.php')?>
<?php include('../includes/check_login.php')?>

<?php
if(isset($_POST['add_customer']))
{
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];   
    $last_name = $_POST['last_name'];   
    $username = $_POST['username'];
    $email = $_POST['email']; 
    $password = md5($_POST['password']); 
    $phone_number = $_POST['phone_number']; 
    $address = $_POST['address']; 
    $profile_picture = 'default-profile.png'; // Assuming a default profile picture
    $status = 1; // Optional, if needed

    $query = mysqli_query($conn, "SELECT * FROM tbl_customers WHERE email = '$email'") or die(mysqli_error($conn));
    $count = mysqli_num_rows($query);

    if ($count > 0) { ?>
        <script>
        alert('Customer with this email already exists');
        </script>
    <?php
    } else {
        mysqli_query($conn, "INSERT INTO tbl_customers (first_name, middle_name, last_name, username, password, phone_number, email, profile_picture, address, created_at) VALUES ('$first_name', '$middle_name', '$last_name', '$username', '$password', '$phone_number', '$email', '$profile_picture', '$address', NOW())") or die(mysqli_error($conn)); ?>
        <script>alert('Customer records successfully added');</script>
        <script>
        window.location = "admin_customer_manage.php"; // Redirect to a page showing the list of customers
        </script>
    <?php
    }
}
?>

<body>
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
                                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Customer Module</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Customer Form</h4>
                            <p class="mb-20"></p>
                        </div>
                    </div>
                    <div class="wizard-content">
                        <form method="post" action="">
                            <section>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>First Name :</label>
                                            <input name="first_name" type="text" class="form-control wizard-required" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Middle Name :</label>
                                            <input name="middle_name" type="text" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Last Name :</label>
                                            <input name="last_name" type="text" class="form-control" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Username :</label>
                                            <input name="username" type="text" class="form-control wizard-required" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Email Address :</label>
                                            <input name="email" type="email" class="form-control" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Password :</label>
                                            <input name="password" type="password" placeholder="**********" class="form-control" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Phone Number :</label>
                                            <input name="phone_number" type="text" class="form-control" required="true" autocomplete="off">
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
                                                <button class="btn btn-primary" name="add_customer" id="add_customer" data-toggle="modal">Add Customer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
