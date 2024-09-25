<?php include('includes/header.php')?>
<?php include('../includes/check_login.php')?>

<?php
// Handle delete request
if (isset($_GET['delete'])) {
    $delete = intval($_GET['delete']); // Ensure the ID is an integer
    $sql = "DELETE FROM tbl_customers WHERE customer_id = $delete";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "<script>alert('Customer deleted Successfully');</script>";
        echo "<script type='text/javascript'> document.location = 'admin_customer_manage.php'; </script>"; // Redirect to the same page
    }
}

// Handle search request
$search = isset($_POST['search']) ? mysqli_real_escape_string($conn, $_POST['search']) : '';
$search_query = $search ? "WHERE CONCAT(first_name, ' ', last_name) LIKE '%$search%' OR email LIKE '%$search%' OR phone_number LIKE '%$search%' OR address LIKE '%$search%'" : '';
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
                                    <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Customer Module</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

            <!-- Card Box with Search and Table -->
            <div class="card-box mb-30">
                <div class="pd-20">
                    <h2 class="text-blue h4">All Customers</h2>
                </div>
                <!-- Search Box -->
                <div class="pb-20">
                    <form method="POST" action="admin_customer_manage.php" class="search-box">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search Customers..." value="<?php echo htmlentities($search); ?>">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- Table -->
                <div class="pb-20">
                    <table class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th class="table-plus">Full Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Address</th>
                                <th class="datatable-nosort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $customer_query = mysqli_query($conn, "SELECT * FROM tbl_customers $search_query ORDER BY customer_id") or die(mysqli_error($conn));
                            while ($row = mysqli_fetch_array($customer_query)) {
                                $id = $row['customer_id'];
                            ?>
                                <tr>
                                    <td class="table-plus">
                                        <div class="name-avatar d-flex align-items-center">
                                            <div class="avatar mr-2 flex-shrink-0">
                                                <img src="<?php echo (!empty($row['location'])) ? '../uploads/'.$row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg';  ?>" class="border-radius-100 shadow" width="40" height="40" alt="">
                                            </div>
                                            <div class="txt">
                                                <div class="weight-600"> <?php echo htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['phone_number']); ?></td>
                                    <td><?php echo htmlspecialchars($row['address']); ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                <i class="dw dw-more"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                <a class="dropdown-item" href="admin_customer_edit.php?edit=<?php echo $row['customer_id']; ?>"><i class="dw dw-edit2"></i> Edit</a>
                                                <a class="dropdown-item" href="admin_customer_manage.php?delete=<?php echo $row['customer_id']; ?>"><i class="dw dw-delete-3"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>  
                        </tbody>
                    </table>
                </div>
            </div>

            <?php include('includes/footer.php'); ?>
        </div>
    </div>
    <!-- js -->
    <?php include('includes/scripts.php')?>
</body>
<style>
    .search-box {
        max-width: 400px; /* Adjust as needed */
        margin-bottom: 10px;
        margin-left: 30px
    }
</style>
</html>
