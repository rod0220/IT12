<?php include('includes/header.php'); ?>
<?php include('../includes/check_login.php'); ?>

<?php
// Fetch batch details
$batch_id = isset($_GET['batch_id']) ? intval($_GET['batch_id']) : 0;
$batch_query = "SELECT * FROM tbl_batches WHERE batch_id = $batch_id";
$batch_result = mysqli_query($conn, $batch_query);
$batch = mysqli_fetch_assoc($batch_result);

// Fetch pens for the batch
$pen_query = "SELECT * FROM tbl_pens WHERE batch_id = $batch_id";
$pen_result = mysqli_query($conn, $pen_query);

// Handle batch updates
if (isset($_POST['update_batch'])) {
    $batch_name = $_POST['batch_name'];
    $creation_date = $_POST['creation_date'];
    $number_of_pens = $_POST['number_of_pens'];

    $query = mysqli_query($conn, "UPDATE tbl_batches SET batch_name = '$batch_name', creation_date = '$creation_date', number_of_pens = '$number_of_pens' WHERE batch_id = $batch_id") or die(mysqli_error($conn));
    echo "<script>alert('Batch updated successfully');</script>";
    echo "<script type='text/javascript'> document.location = 'admin_batch_manage.php?batch_id=$batch_id'; </script>";
}

// Handle pen addition
if (isset($_POST['add_pen'])) {
    $pen_name = $_POST['pen_name'];

    $query = mysqli_query($conn, "INSERT INTO tbl_pens (batch_id, pen_name) VALUES ('$batch_id', '$pen_name')") or die(mysqli_error($conn));
    echo "<script>alert('Pen added successfully');</script>";
    echo "<script type='text/javascript'> document.location = 'admin_batch_manage.php?batch_id=$batch_id'; </script>";
}

// Handle pen update
if (isset($_POST['update_pen'])) {
    $pen_id = $_POST['pen_id'];
    $pen_name = $_POST['pen_name'];

    $query = mysqli_query($conn, "UPDATE tbl_pens SET pen_name = '$pen_name' WHERE pen_id = $pen_id") or die(mysqli_error($conn));
    echo "<script>alert('Pen updated successfully');</script>";
    echo "<script type='text/javascript'> document.location = 'admin_batch_manage.php?batch_id=$batch_id'; </script>";
}

// Handle pen deletion
if (isset($_POST['delete_pen'])) {
    $pen_id = $_POST['pen_id'];
    $query = mysqli_query($conn, "DELETE FROM tbl_pens WHERE pen_id = $pen_id") or die(mysqli_error($conn));
    echo "<script>alert('Pen deleted successfully');</script>";
    echo "<script type='text/javascript'> document.location = 'admin_batch_manage.php?batch_id=$batch_id'; </script>";
}
?>

<body>
    <?php include('includes/navbar.php'); ?>
    <?php include('includes/right_sidebar.php'); ?>
    <?php include('includes/left_sidebar.php'); ?>
    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Manage Batch</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="admin_batch_add.php">Batch Management</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Manage Batch</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Container 1: Update Batch -->
                    <div class="col-lg-6 col-md-12 col-sm-12 mb-30">
                        <div class="pd-20 card-box" style="background-color: white;">
                            <h4 class="text-blue h4">Update Batch</h4>
                            <form method="post" action="">
                                <div class="form-group">
                                    <label>Batch Name</label>
                                    <input name="batch_name" type="text" class="form-control" value="<?php echo htmlentities($batch['batch_name']); ?>" required autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Creation Date</label>
                                    <input name="creation_date" type="date" class="form-control form-control-lg" value="<?php echo htmlentities($batch['creation_date']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Number of Pens</label>
                                    <select name="number_of_pens" class="form-control" required>
                                        <?php for ($i = 1; $i <= 2; $i++) { ?>
                                            <option value="<?php echo $i; ?>" <?php if ($i == $batch['number_of_pens']) echo 'selected'; ?>><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="text-right">
                                    <input class="btn btn-primary" type="submit" value="Update Batch" name="update_batch">
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Container 2: Manage Pens -->
                    <div class="col-lg-6 col-md-12 col-sm-12 mb-30">
                        <div class="pd-20 card-box" style="background-color: white;">
                            <h4 class="text-blue h4">Add New Pen</h4>
                            <form method="post" action="">
                                <div class="form-group">
                                    <label>Pen Name</label>
                                    <input name="pen_name" type="text" class="form-control" required autocomplete="off">
                                </div>
                                <div class="text-right">
                                    <input class="btn btn-primary" type="submit" value="Add Pen" name="add_pen">
                                </div>
                            </form>
                        </div>

                        <div class="pd-20 card-box mt-30" style="background-color: white;">
                            <h4 class="text-blue h4">Existing Pens</h4>
                            <div class="row">
                                <?php while ($pen = mysqli_fetch_assoc($pen_result)) { ?>
                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-30">
                                        <div class="pen-card card-box" style="background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 8px; padding: 15px; cursor: pointer;" data-toggle="modal" data-target="#editPenModal<?php echo $pen['pen_id']; ?>">
                                            <h5 class="text-blue"><?php echo htmlentities($pen['pen_name']); ?></h5>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Pen Modal -->
            <?php while ($pen = mysqli_fetch_assoc($pen_result)) { ?>
                <div class="modal fade" id="editPenModal<?php echo $pen['pen_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editPenModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editPenModalLabel">Edit Pen</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="">
                                    <input type="hidden" name="pen_id" value="<?php echo $pen['pen_id']; ?>">
                                    <div class="form-group">
                                        <label>Pen Name</label>
                                        <input name="pen_name" type="text" class="form-control" value="<?php echo htmlentities($pen['pen_name']); ?>" required autocomplete="off">
                                    </div>
                                    <div class="text-right">
                                        <input class="btn btn-primary" type="submit" value="Update Pen" name="update_pen">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <!-- Delete Pen Modal -->
            <?php while ($pen = mysqli_fetch_assoc($pen_result)) { ?>
                <div class="modal fade" id="deletePenModal<?php echo $pen['pen_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deletePenModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deletePenModalLabel">Delete Pen</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this pen? This action cannot be undone.
                            </div>
                            <div class="modal-footer">
                                <form method="post" action="">
                                    <input type="hidden" name="pen_id" value="<?php echo $pen['pen_id']; ?>">
                                    <input type="submit" class="btn btn-danger" value="Delete Pen" name="delete_pen">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php include('includes/footer.php'); ?>
        </div>
    </div>

    <?php include('includes/scripts.php'); ?>
</body>
</html>
d