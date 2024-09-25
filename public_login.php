<?php
session_start();
include('includes/db_connect.php');

if (isset($_POST['signin'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Assuming passwords are stored using MD5

    // Check in tbl_admin
    $sql_admin = "SELECT * FROM tbl_admin WHERE email = '$username' AND password = '$password'";
    $query_admin = mysqli_query($conn, $sql_admin);
    if (mysqli_num_rows($query_admin) > 0) {
        $row = mysqli_fetch_assoc($query_admin);
        $_SESSION['user_id'] = $row['admin_id'];
        $_SESSION['user_role'] = 'Admin';
        $_SESSION['user_name'] = $row['first_name'] . ' ' . $row['last_name'];

        // Redirect to admin dashboard
        echo "<script type='text/javascript'> document.location = 'Admin_Module/admin_dashboard.php'; </script>";
        exit;
    }

    // Check in tbl_staffs
    $sql_staff = "SELECT * FROM tbl_staffs WHERE email = '$username' AND password = '$password'";
    $query_staff = mysqli_query($conn, $sql_staff);
    if (mysqli_num_rows($query_staff) > 0) {
        $row = mysqli_fetch_assoc($query_staff);
        $_SESSION['user_id'] = $row['staff_id'];
        $_SESSION['user_role'] = 'Staff';
        $_SESSION['user_name'] = $row['first_name'] . ' ' . $row['last_name'];

        // Redirect to staff dashboard
        echo "<script type='text/javascript'> document.location = 'staff/index.php'; </script>";
        exit;
    }

    // Check in tbl_customers
    $sql_customer = "SELECT * FROM tbl_customers WHERE email = '$username' AND password = '$password'";
    $query_customer = mysqli_query($conn, $sql_customer);
    if (mysqli_num_rows($query_customer) > 0) {
        $row = mysqli_fetch_assoc($query_customer);
        $_SESSION['user_id'] = $row['customer_id'];
        $_SESSION['user_role'] = 'Customer';
        $_SESSION['user_name'] = $row['first_name'] . ' ' . $row['last_name'];

        // Redirect to customer portal
        echo "<script type='text/javascript'> document.location = 'customer/index.php'; </script>";
        exit;
    }

    // If login fails
    echo "<script>alert('Invalid Credentials');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>MBDF Management Information System</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="vendors/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="vendors/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="vendors/images/favicon-16x16.png">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="vendors/styles/core.css">
    <link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="vendors/styles/style.css">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-119386393-1');
    </script>
</head>
<body class="login-page">
    <div class="login-header box-shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <a href="login.html">
                    <img src="vendors/images/deskapp-logo-svg.pn" alt="">
                </a>
            </div>
        </div>
    </div>
    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7">
                    <img src="vendors/images/login.png" alt="">
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <div class="login-title">
                            <h2 class="text-center text-primary">Welcome To Munting Bukirin Duck Farm</h2>
                        </div>
                        <form name="signin" method="post">
                            <div class="input-group custom">
                                <input type="text" class="form-control form-control-lg" placeholder="Email ID" name="username" id="username" required>
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                                </div>
                            </div>
                            <div class="input-group custom">
                                <input type="password" class="form-control form-control-lg" placeholder="**********" name="password" id="password" required>
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                </div>
                            </div>
                            <div class="row pb-30" >
                                <div class="col-6">
                                    <div class="forgot-password"><a href="forgot-password.html">Forgot Password?</a></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group mb-0">
                                        <input class="btn btn-primary btn-lg btn-block" name="signin" id="signin" type="submit" value="Sign In">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="vendors/scripts/core.js"></script>
    <script src="vendors/scripts/script.min.js"></script>
    <script src="vendors/scripts/process.js"></script>
    <script src="vendors/scripts/layout-settings.js"></script>
</body>
</html>
