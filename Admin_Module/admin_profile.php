<?php include('includes/header.php')?>
<?php include('../includes/check_login.php')?>
<?php
if (isset($_POST['update'])) {
    $admin_id = $session_id;
    $first_name = $_POST['fname'];
    $last_name = $_POST['lastname'];
    $email = $_POST['email'];
    $phone_number = $_POST['phonenumber'];
    $profile_picture = $_POST['profile_picture']; // Assuming you have a way to handle this

    $result = mysqli_query($conn, "UPDATE tbl_admin SET 
        first_name = '$first_name', 
        last_name = '$last_name', 
        email = '$email', 
        phone_number = '$phone_number' 
        WHERE admin_id = '$admin_id'") or die(mysqli_error($conn));

    if ($result) {
        echo "<script>alert('Your records have been successfully updated.');</script>";
        echo "<script type='text/javascript'>document.location = 'admin_profile.php';</script>";
    } else {
        die(mysqli_error($conn));
    }
}

if (isset($_POST['update_image'])) {
    $image = $_FILES['image']['name'];

    if (!empty($image)) {
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $image);
        $location = $image;

        $result = mysqli_query($conn, "UPDATE tbl_admin SET 
            profile_picture = '$location' 
            WHERE admin_id = '$session_id'") or die(mysqli_error($conn));

        if ($result) {
            echo "<script>alert('Profile picture updated successfully.');</script>";
            echo "<script type='text/javascript'>document.location = 'admin_profile.php';</script>";
        } else {
            die(mysqli_error($conn));
        }
    } else {
        echo "<script>alert('Please select a picture to update.');</script>";
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
                        <div class="col-md-12 col-sm-12">
                            <div class="title">
                                <h4>Profile</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
                        <div class="pd-20 card-box height-100-p">

                            <?php 
                            $query = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE admin_id = '$session_id'") or die(mysqli_error($conn));
                            $row = mysqli_fetch_array($query);
                            ?>

                            <div class="profile-photo">
                                <a href="modal" data-toggle="modal" data-target="#modal" class="edit-avatar"><i class="fa fa-pencil"></i></a>
                                <img src="<?php echo (!empty($row['profile_picture'])) ? '../uploads/' . $row['profile_picture'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>" alt="" class="avatar-photo">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="weight-500 col-md-12 pd-5">
                                                    <div class="form-group">
                                                        <div class="custom-file">
                                                            <input name="image" id="file" type="file" class="custom-file-input" accept="image/*" onchange="validateImage('file')">
                                                            <label class="custom-file-label" for="file" id="selector">Choose file</label>        
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="submit" name="update_image" value="Update" class="btn btn-primary">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <h5 class="text-center h5 mb-0"><?php echo $row['first_name'] . " " . $row['last_name']; ?></h5>
                            <p class="text-center text-muted font-14"><?php echo $row['phone_number']; ?></p>
                            <div class="profile-info">
                                <h5 class="mb-20 h5 text-blue">Contact Information</h5>
                                <ul>
                                    <li>
                                        <span>Email Address:</span>
                                        <?php echo $row['email']; ?>
                                    </li>
                                    <li>
                                        <span>Phone Number:</span>
                                        <?php echo $row['phone_number']; ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
					<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
    <div class="card-box height-100-p overflow-hidden">
        <div class="profile-tab height-100-p">
            <div class="tab height-100-p">
                <ul class="nav nav-tabs customtab" role="tablist">
                    <!-- Remove the Leave Records tab -->
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#setting" role="tab">Profile Settings</a>
                    </li>
                    <li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#password" role="tab">Password Settings</a>
										</li>
                </ul>
                <div class="tab-content">
                  
                    <!-- Setting Tab start -->
                    <div class="tab-pane fade height-100-p show active" id="setting" role="tabpanel">
                        <div class="profile-setting">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="profile-edit-list row">
                                    <div class="col-md-12"><h4 class="text-blue h5 mb-20">Edit Your Personal Settings</h4></div>

                                    <?php
                                    $query = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE admin_id = '$session_id'") or die(mysqli_error($conn));
                                    $row = mysqli_fetch_array($query);
                                    ?>
                                    <div class="weight-500 col-md-6">
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input name="fname" class="form-control form-control-lg" type="text" required="true" autocomplete="off" value="<?php echo $row['first_name']; ?>">
                                        </div>
                                    </div>
                                    <div class="weight-500 col-md-6">
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input name="lastname" class="form-control form-control-lg" type="text" required="true" autocomplete="off" value="<?php echo $row['last_name']; ?>">
                                        </div>
                                    </div>
                                    <div class="weight-500 col-md-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input name="email" class="form-control form-control-lg" type="email" required="true" autocomplete="off" value="<?php echo $row['email']; ?>">
                                        </div>
                                    </div>
                                    <div class="weight-500 col-md-6">
                                        <div class="form-group">
                                            <label>Phone Number</label>
                                            <input name="phonenumber" class="form-control form-control-lg" type="text" required="true" autocomplete="off" value="<?php echo $row['phone_number']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center mt-4">
                                    <input type="submit" name="update" class="btn btn-primary" value="Save Changes">
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Setting Tab End -->
                    <!-- Password Tab start -->
<div class="tab-pane fade" id="password" role="tabpanel">
        <div class="profile-timeline">
            <h4 class="text-blue h5 mb-20">Change Password</h4>
            <form method="POST" enctype="multipart/form-data">
                <div class="profile-edit-list row">
                    <div class="weight-500 col-md-6">
                        <div class="form-group">
                            <label>Current Password</label>
                            <input name="current_password" class="form-control form-control-lg" type="password" required="true" autocomplete="off">
                        </div>
                    </div>
                    <div class="weight-500 col-md-6">
                        <div class="form-group">
                            <label>New Password</label>
                            <input name="new_password" class="form-control form-control-lg" type="password" required="true" autocomplete="off">
                        </div>
                    </div>
                    <div class="weight-500 col-md-6">
                        <div class="form-group">
                            <label>Confirm New Password</label>
                            <input name="confirm_password" class="form-control form-control-lg" type="password" required="true" autocomplete="off">
                        </div>
                    </div>
                </div><br>
                <div class="col-md-12 text-center mt-4">
                    <input type="submit" name="update_password" class="btn btn-primary" value="Change Password">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Password Tab End -->

<?php
if (isset($_POST['update_password'])) {
    $admin_id = $session_id;
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch the current password from the database
    $query = mysqli_query($conn, "SELECT password FROM tbl_admin WHERE admin_id = '$admin_id'") or die(mysqli_error($conn));
    $row = mysqli_fetch_array($query);

    // Check if the current password matches
    if (md5($current_password) === $row['password']) {
        // Check if new password and confirm password match
        if ($new_password === $confirm_password) {
            // Update the password
            $hashed_new_password = md5($new_password);
            $update_result = mysqli_query($conn, "UPDATE tbl_admin SET password = '$hashed_new_password' WHERE admin_id = '$admin_id'") or die(mysqli_error($conn));

            if ($update_result) {
                echo "<script>alert('Password changed successfully.');</script>";
            } else {
                die(mysqli_error($conn));
            }
        } else {
            echo "<script>alert('New password and confirm password do not match.');</script>";
        }
    } else {
        echo "<script>alert('Current password is incorrect.');</script>";
    }
}
?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('includes/footer.php')?>
			</div>
	</div>
	<!-- js -->
	<?php include('includes/scripts.php')?>

	<script type="text/javascript">
		var loader = function(e) {
			let file = e.target.files;

			let show = "<span>Selected file : </span>" + file[0].name;
			let output = document.getElementById("selector");
			output.innerHTML = show;
			output.classList.add("active");
		};

		let fileInput = document.getElementById("file");
		fileInput.addEventListener("change", loader);
	</script>
	<script type="text/javascript">
		 function validateImage(id) {
		    var formData = new FormData();
		    var file = document.getElementById(id).files[0];
		    formData.append("Filedata", file);
		    var t = file.type.split('/').pop().toLowerCase();
		    if (t != "jpeg" && t != "jpg" && t != "png") {
		        alert('Please select a valid image file');
		        document.getElementById(id).value = '';
		        return false;
		    }
		    if (file.size > 1050000) {
		        alert('Max Upload size is 1MB only');
		        document.getElementById(id).value = '';
		        return false;
		    }

		    return true;
		}
	</script>
</body>
</html>