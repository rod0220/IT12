<?php include('includes/header.php')?>
<?php include('../includes/check_login.php')?>

<?php 
// Fetch batch ID from GET request
$batch_id = $_GET['edit'];

// Fetch batch details
$query = "SELECT * FROM tbl_batches WHERE batch_id = '$batch_id'";
$result = mysqli_query($conn, $query);
$batch = mysqli_fetch_array($result);

// Fetch pen details
$pen_query = "SELECT * FROM tbl_pens WHERE batch_id = '$batch_id'";
$pen_result = mysqli_query($conn, $pen_query);

// Handle form submission
if (isset($_POST['update'])) {
    $batch_name = $_POST['batch_name'];
    $number_of_pens = $_POST['number_of_pens'];

    // Update batch details
    $update_batch_query = "UPDATE tbl_batches SET batch_name = '$batch_name', number_of_pens = '$number_of_pens' WHERE batch_id = '$batch_id'";
    mysqli_query($conn, $update_batch_query);

    // Update pen details
    for ($i = 1; $i <= $number_of_pens; $i++) {
        $pen_id = $_POST["pen_id_$i"];
        $pen_name = $_POST["pen_name_$i"];
        $ducks_in_pen = $_POST["ducks_in_pen_$i"];

        if ($pen_id) {
            $update_pen_query = "UPDATE tbl_pens SET pen_name = '$pen_name', ducks_in_pen = '$ducks_in_pen' WHERE pen_id = '$pen_id'";
            mysqli_query($conn, $update_pen_query);
        } else {
            $insert_pen_query = "INSERT INTO tbl_pens (batch_id, pen_name, ducks_in_pen) VALUES ('$batch_id', '$pen_name', '$ducks_in_pen')";
            mysqli_query($conn, $insert_pen_query);
        }
    }

    echo "<script>alert('Batch and pens updated successfully');</script>";
    echo "<script type='text/javascript'> document.location = 'admin_batch_manage.php'; </script>";
}
?>

<body>
    <div class="pre-loader">
        <div class="pre-loader-box">
            <div class="loader-logo"><img src="../vendors/images/deskapp-logo-svg.png" alt=""></div>
            <div class='loader-progress' id="progress_div">
                <div class='bar' id='bar1'></div>
            </div>
            <div class='percent' id='percent1'>0%</div>
            <div class="loading-text">Loading...</div>
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
                                <h4>Edit Batch</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="admin_batch_manage.php">Batch Manage</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit Batch</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 mb-30">
                        <div class="card-box pd-30 pt-10 height-100-p">
                            <h2 class="mb-30 h4">Edit Batch</h2>
                            <section>
                                <form method="post">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Batch Name</label>
                                                <input name="batch_name" type="text" class="form-control" required="true" value="<?php echo htmlspecialchars($batch['batch_name']); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Number of Pens</label>
                                                <input name="number_of_pens" type="number" class="form-control" required="true" value="<?php echo htmlspecialchars($batch['number_of_pens']); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                    $pen_count = 1;
                                    while ($pen = mysqli_fetch_array($pen_result)) { 
                                    ?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Pen Name</label>
                                                <input name="pen_name_<?php echo $pen_count; ?>" type="text" class="form-control" value="<?php echo htmlspecialchars($pen['pen_name']); ?>">
                                                <input name="pen_id_<?php echo $pen_count; ?>" type="hidden" value="<?php echo htmlspecialchars($pen['pen_id']); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Ducks in Pen</label>
                                                <input name="ducks_in_pen_<?php echo $pen_count; ?>" type="number" class="form-control" value="<?php echo htmlspecialchars($pen['ducks_in_pen']); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                    $pen_count++;
                                    } 
                                    ?>
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <div class="dropdown">
                                                <input class="btn btn-primary" type="submit" value="Update Batch" name="update">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </section>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('includes/footer.php'); ?>
        </div>
    </div>

    <?php include('includes/scripts.php')?>
</body>
</html>
