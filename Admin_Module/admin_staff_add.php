<?php include('includes/header.php')?>
<?php include('../includes/check_login.php')?>

<?php
if(isset($_POST['add_staff']))
{
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];   
    $username = $_POST['username'];
    $email = $_POST['email']; 
    $password = md5($_POST['password']); 
    $phone_number = $_POST['phone_number']; 
    $profile_picture = 'default-profile.png'; // Assuming a default profile picture
    $role = $_POST['role']; // Staff role, e.g., 'admin' or 'staff'
    $status = 'Online'; // Default status for the staff

    // Check if staff with the same email already exists
    $query = mysqli_query($conn, "SELECT * FROM tbl_staffs WHERE email = '$email'") or die(mysqli_error($conn));
    $count = mysqli_num_rows($query);

    if ($count > 0) { ?>
        <script>
        alert('Staff with this email already exists');
        </script>
    <?php
    } else {
        // Insert staff record
        mysqli_query($conn, "INSERT INTO tbl_staffs (first_name, last_name, username, email, password, phone_number, profile_picture, role, created_at, status) 
        VALUES ('$first_name', '$last_name', '$username', '$email', '$password', '$phone_number', '$profile_picture', '$role', NOW(), '$status')") 
        or die(mysqli_error($conn)); ?>
        <script>alert('Staff records successfully added');</script>
        <script>
        window.location = "admin_staff_manage.php"; // Redirect to a page showing the list of staff members
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
                                <h4>Staff Portal</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Staff Module</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Staff Information</h4>
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
                                            <label>Last Name :</label>
                                            <input name="last_name" type="text" class="form-control" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Username :</label>
                                            <input name="username" type="text" class="form-control wizard-required" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
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
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Phone Number :</label>
                                            <input name="phone_number" type="text" class="form-control" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Role :</label>
                                            <select name="role" class="form-control" required>
                                                <option value="">Select Role</option>
                                                <option value="Maintenance Worker">Maintenance Worker</option>
                                                <option value="Caretaker/Harvester">Caretaker/Harvester</option>
                                                <!-- Add more roles as needed -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <!-- Blank or space area -->
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="modal-footer justify-content-center">
                                                <button class="btn btn-primary" name="add_staff" id="add_staff" data-toggle="modal">Add Staff</button>
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
