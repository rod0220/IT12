

<?php include('includes/header.php')?>
<?php include('../includes/check_login.php')?>
<body>
<?php include('includes/right_sidebar.php')?>
<?php include('includes/navbar.php')?>
<?php include('includes/left_sidebar.php')?>

<div class="mobile-menu-overlay"></div>
<br><br>
<div class="main-container" class="light-logo">

    <div class="pd-ltr-20">    
        <div class="card-box pd-20 height-100-p mb-30">
            <div class="row align-items-center">
                <div class="col-md-4 user-icon">
                <img src="../vendors/images/banner-img.png" alt="">
                </div>
                <div class="col-md-8">
                    <?php 
                    $query = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE admin_id = '$session_id'") or die(mysqli_error($conn));
                    $row = mysqli_fetch_array($query);
                    ?>
                    <h4 class="font-20 weight-500 mb-10 text-capitalize">
                        Welcome back <div class="weight-600 font-30 text-blue"><?php echo $row['first_name']. " " .$row['last_name']; ?>,</div>
                    </h4>
                    <p class="font-18 max-width-600">The Munting Bukirin Duck Farm is glad that you're here</p>
                </div>
            </div>
        </div>
        <div class="title pb-20">
        <h2 class="h3 mb-0">Data Information</h2>
</div>
<div class="row pb-10">
    <!-- Total Admins -->
    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
        <div class="card-box height-100-p widget-style3">
            <?php
            $sql = "SELECT admin_id FROM tbl_admin";
            $query = $dbh->prepare($sql);
            $query->execute();
            $adminCount = $query->rowCount();
            ?>
            <div class="d-flex flex-wrap">
                <div class="widget-data">
                    <div class="weight-700 font-24 text-dark"><?php echo($adminCount); ?></div>
                    <div class="font-14 text-secondary weight-500">Total Admins</div>
                </div>
                <div class="widget-icon">
                    <div class="icon" data-color="#00eccf"><i class="icon-copy dw dw-user-2"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Customers -->
    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
        <div class="card-box height-100-p widget-style3">
            <?php
            $sql = "SELECT customer_id FROM tbl_customers";
            $query = $dbh->prepare($sql);
            $query->execute();
            $customerCount = $query->rowCount();
            ?>
            <div class="d-flex flex-wrap">
                <div class="widget-data">
                    <div class="weight-700 font-24 text-dark"><?php echo($customerCount); ?></div>
                    <div class="font-14 text-secondary weight-500">Total Customers</div>
                </div>
                <div class="widget-icon">
                    <div class="icon" data-color="#00eccf"><i class="icon-copy dw dw-user-2"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Staffs -->
    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
        <div class="card-box height-100-p widget-style3">
            <?php
            $sql = "SELECT staff_id FROM tbl_staffs";
            $query = $dbh->prepare($sql);
            $query->execute();
            $staffCount = $query->rowCount();
            ?>
            <div class="d-flex flex-wrap">
                <div class="widget-data">
                    <div class="weight-700 font-24 text-dark"><?php echo($staffCount); ?></div>
                    <div class="font-14 text-secondary weight-500">Total Staffs</div>
                </div>
                <div class="widget-icon">
                    <div class="icon" data-color="#00eccf"><i class="icon-copy dw dw-user-2"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Batches -->
    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
        <div class="card-box height-100-p widget-style3">
            <?php
            $sql = "SELECT batch_id FROM tbl_batches";
            $query = $dbh->prepare($sql);
            $query->execute();
            $batchCount = $query->rowCount();
            ?>
            <div class="d-flex flex-wrap">
                <div class="widget-data">
                    <div class="weight-700 font-24 text-dark"><?php echo($batchCount); ?></div>
                    <div class="font-14 text-secondary weight-500">Total Batches</div>
                </div>
                <div class="widget-icon">
                    <div class="icon" data-color="#00eccf"><i class="icon-copy fa fa-box"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
            <div class="col-lg-4 col-md-6 mb-20">
                <div class="card-box height-100-p pd-20 min-height-200px">
                    <div class="d-flex justify-content-between">
                        <div class="h5 mb-0">Harvest Report</div>
                        <div class="table-actions">
                            <a title="View Harvest" href="#"><i class="icon-copy ion-disc" data-color="#17a2b8"></i></a>    
                        </div>
                    </div>
                    <br><br>
                    <!-- Canvas for the Chart -->
                    <div id=" " style="position: relative; height: 300px; width: 100%;">
                        <canvas id="harvestChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-20">
                <div class="card-box height-100-p pd-20 min-height-200px">
                    <div class="d-flex justify-content-between pb-10">
                        <div class="h5 mb-0">New Customers</div>
                        <div class="table-actions">
                            <a title="View Customers" href="admin_customer_manage.php"><i class="icon-copy ion-disc" data-color="#17a2b8"></i></a>    
                        </div>
                    </div>
                    <div class="user-list">
                        <ul>
                            <?php
                            $query = mysqli_query($conn, "SELECT * FROM tbl_customers ORDER BY customer_id DESC LIMIT 4") or die(mysqli_error($conn));
                            while ($row = mysqli_fetch_array($query)) {
                                $id = $row['customer_id'];
                            ?>
                            <li class="d-flex align-items-center justify-content-between">
                                <div class="name-avatar d-flex align-items-center pr-2">
                                    <div class="avatar mr-2 flex-shrink-0">
                                        <img src="<?php echo (!empty($row['location'])) ? '../uploads/'.$row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>" class="border-radius-100 box-shadow" width="50" height="50" alt="">
                                    </div>
                                    <div class="txt">
                                        <span class="badge badge-pill badge-sm" data-bgcolor="#e7ebf5" data-color="#265ed7"><?php echo "Customer"?></span>
                                        <div class="font-14 weight-600">&nbsp;<?php echo $row['first_name'] . " " . $row['last_name']; ?></div>
                                        <div class="font-12 weight-500" data-color="#b2b1b6">&nbsp;&nbsp;<?php echo $row['email']; ?></div>
                                    </div>
                                </div>
                                <div class="font-12 weight-500" data-color="#17a2b8"><?php echo $row['phone_number']; ?></div>
                            </li>
                            <?php }?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-20">
                <div class="card-box height-100-p pd-20 min-height-200px">
                    <div class="d-flex justify-content-between">
                        <div class="h5 mb-0">Staffs</div><br>
                        <div class="table-actions">
                            <a title="VIEW" href="admin_staff_manage.php"><i class="icon-copy ion-disc" data-color="#17a2b8"></i></a>    
                        </div>
                    </div>

                    <div class="user-list">
                        <ul>
                            <?php
                            $query = mysqli_query($conn, "SELECT * FROM tbl_staffs ORDER BY staff_id DESC LIMIT 4") or die(mysqli_error($conn));
                            while ($row = mysqli_fetch_array($query)) {
                                $id = $row['staff_id'];
                            ?>
                            <li class="d-flex align-items-center justify-content-between">
                                <div class="name-avatar d-flex align-items-center pr-2">
                                    <div class="avatar mr-2 flex-shrink-0">
                                        <img src="<?php echo (!empty($row['location'])) ? '../uploads/'.$row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>" class="border-radius-100 box-shadow" width="50" height="50" alt="">
                                    </div>
                                    <div class="txt">
                                        <span class="badge badge-pill badge-sm" data-bgcolor="#e7ebf5" data-color="#265ed7"><?php echo $row['role']; ?></span>
                                        <div class="font-14 weight-600">&nbsp;<?php echo $row['first_name'] . " " . $row['last_name']; ?></div>
                                        <div class="font-12 weight-500" data-color="#b2b1b6">&nbsp;&nbsp;<?php echo $row['email']; ?></div>
                                    </div>
                                </div>
                                <div class="font-12 weight-500" data-color="#17a2b8"><?php echo $row['phone_number']; ?></div>
                            </li>
                            <?php }?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div">


<!-- Include Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Script to create and display the chart -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Sample data - replace this with your actual data fetching logic
    var labels = ['Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday', 'Monday'];
    var data = [30, 45, 28, 60, 75, 80, 90, 100]; // Example data points

    // Create the chart
    var ctx = document.getElementById('harvestChart').getContext('2d');
    var harvestChart = new Chart(ctx, {
        type: 'line', // Change this to 'bar', 'pie', etc. for different chart types
        data: {
            labels: labels,
            datasets: [{
                label: 'Weekly Report',
                data: data,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>

		<?php include('includes/footer.php')?>
        </div>
    </div>
</div>

<?php include('includes/scripts.php')?>
</body>
</html>
