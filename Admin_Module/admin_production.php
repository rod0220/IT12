<?php include('includes/header.php'); ?>
<?php include('../includes/check_login.php'); ?>
<?php include('includes/right_sidebar.php'); ?>
<?php include('includes/scripts.php'); ?>

<style>
    .batch-card {
        color: #524d7d;
    }
    .batch-card a:hover {
        color: #524d7d;
    }
    .dropdown-menu {
        min-width: 150px;
    }
    .pen-card {
        cursor: pointer;
        text-align: center;
    }
    .mt-3 {
        text-align: center;
    }
</style>

<?php
// Handle production record addition
if (isset($_POST['add_production'])) {
    $pen_id = $_POST['pen_id'];
    // Convert the date format
    $date_recorded = date('Y-m-d', strtotime($_POST['date_recorded'])); // Format to 'Y-m-d'
    $big_eggs = $_POST['big_eggs'];
    $small_eggs = $_POST['small_eggs'];
    $peewee_eggs = $_POST['peewee_eggs'];
    $total_eggs = $big_eggs + $small_eggs + $peewee_eggs;

    // Check if a harvest already exists for this pen on the selected date
    $check_query = "SELECT * FROM tbl_production WHERE pen_id = '$pen_id' AND date_recorded = '$date_recorded'";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Harvest for this pen has already been recorded on this date.');</script>";
    } else {
        // Insert the new production record into the database
        $query = mysqli_query($conn, "INSERT INTO tbl_production (pen_id, date_recorded, big_eggs, small_eggs, peewee_eggs, total_eggs) 
            VALUES ('$pen_id', '$date_recorded', '$big_eggs', '$small_eggs', '$peewee_eggs', '$total_eggs')") or die(mysqli_error($conn));

        echo "<script>alert('Production record added successfully');</script>";
        echo "<script type='text/javascript'> document.location = 'admin_production.php'; </script>";
    }
}

// Handle production record editing
if (isset($_POST['edit_production'])) {
    $production_id = $_POST['production_id'];
    $big_eggs = $_POST['big_eggs'];
    $small_eggs = $_POST['small_eggs'];
    $peewee_eggs = $_POST['peewee_eggs'];
    $total_eggs = $big_eggs + $small_eggs + $peewee_eggs;

    // Update the existing production record
    $query = mysqli_query($conn, "UPDATE tbl_production SET big_eggs='$big_eggs', small_eggs='$small_eggs', peewee_eggs='$peewee_eggs', total_eggs='$total_eggs' WHERE production_id='$production_id'") or die(mysqli_error($conn));

    echo "<script>alert('Production record updated successfully');</script>";
    echo "<script type='text/javascript'> document.location = 'admin_production.php'; </script>";
}

// Fetch batches and pens for display
$batch_query = "SELECT * FROM tbl_batches";
$batch_result = mysqli_query($conn, $batch_query);

// Get the selected date from the URL, or default to today
$selected_date = isset($_GET['selected_date']) ? date('Y-m-d', strtotime($_GET['selected_date'])) : date('Y-m-d');
$formatted_selected_date = date('d F Y', strtotime($selected_date));
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
                                <h4>Egg Production Management</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Egg Production</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- Date Filter -->
                <div class="row">
                    <div class="col-md-6">
                        <form method="GET" action="">
                            <div class="form-group">
                                <label>Select Date</label>
                                <input type="text" name="selected_date" class="form-control form-control-lg date-picker" required value="<?php echo $formatted_selected_date; ?>">
                            </div>
                            <button type="submit" class="btn btn-primary">Select</button>
                        </form>
                    </div>
                </div>

                <!-- Display Batches and Pens -->
                <div class="row mt-4">
                    <?php while ($batch = mysqli_fetch_assoc($batch_result)) { ?>
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-30">
                            <div class="pd-20 card-box batch-card" style="background-color: white; border: 1px solid #ddd; border-radius: 8px; padding: 15px; min-height: 300px;">
                                <h4 class="text-center" style="color: #031e23;"><?php echo htmlentities($batch['batch_name']); ?></h4>

                                <div class="row mt-3">
                                    <?php
                                    $pen_query = "SELECT * FROM tbl_pens WHERE batch_id = " . $batch['batch_id'];
                                    $pen_result = mysqli_query($conn, $pen_query);
                                    while ($pen = mysqli_fetch_assoc($pen_result)) {
                                        // Fetch existing harvest data for the selected date
                                        $harvest_query = "SELECT * FROM tbl_production WHERE pen_id = " . $pen['pen_id'] . " AND date_recorded = '$selected_date' ORDER BY date_recorded DESC";
                                        $harvest_result = mysqli_query($conn, $harvest_query);
                                        $harvest_data = mysqli_fetch_assoc($harvest_result);
                                    ?>
                                        <div class="col-md-6 mb-3">
                                            <div class="card-box pen-card" style="background-color: white; border: 1px solid #ddd; border-radius: 8px; padding: 15px; min-height: 260px;">
                                                <h5 style="color: #031e23;"><?php echo htmlentities($pen['pen_name']); ?></h5>

                                                <div class="dropdown" style="position: absolute; right: 30px; top: 15px;">
                                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                        <i class="dw dw-more"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                        <a class="dropdown-item" href="#" onclick="showAddModal(<?php echo $pen['pen_id']; ?>)">
                                                            <i class="dw dw-add"></i> Add Harvest
                                                        </a>
                                                        <a class="dropdown-item" href="#" onclick="showEditModal(<?php echo $pen['pen_id']; ?>, '<?php echo htmlentities($harvest_data['production_id']); ?>')">
                                                            <i class="dw dw-edit2"></i> Edit Harvest
                                                        </a>
                                                    </div>
                                                </div>

                                                <!-- Display Harvest Data -->
                                                <div class="mt-3">
                                                    <?php if ($harvest_data) { ?>
                                                        <div class="harvest-data" style="text-align: left;">
                                                            <p><strong>Big Eggs:</strong> <?php echo htmlentities($harvest_data['big_eggs']); ?></p>
                                                            <p><strong>Small Eggs:</strong> <?php echo htmlentities($harvest_data['small_eggs']); ?></p>
                                                            <p><strong>Peewee Eggs:</strong> <?php echo htmlentities($harvest_data['peewee_eggs']); ?></p>
                                                            <p><strong>Total Eggs:</strong> <?php echo htmlentities($harvest_data['total_eggs']); ?></p>
                                                        </div>
                                                    <?php } else { ?>
                                                        <p>No harvest recorded for this date.</p>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    <!-- Add pagination links here if necessary -->
                </div>
            </div>
        </div>
    </div>

    <!-- Add Production Modal -->
    <div class="modal fade" id="addProductionModal" tabindex="-1" role="dialog" aria-labelledby="addProductionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductionModalLabel">Add Production Record</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="pen_id" id="pen_id" value="">
                        <div class="form-group">
                            <label>Date Recorded</label>
                            <input type="" name="date_recorded" class="form-control form-control-lg date-picker" required value="<?php echo date('d F Y'); ?>">
                        </div>
                        <div class="form-group">
                            <label>Big Eggs</label>
                            <input type="number" name="big_eggs" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Small Eggs</label>
                            <input type="number" name="small_eggs" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Peewee Eggs</label>
                            <input type="number" name="peewee_eggs" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="add_production" class="btn btn-primary">Add Production</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Production Modal -->
    <div class="modal fade" id="editProductionModal" tabindex="-1" role="dialog" aria-labelledby="editProductionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductionModalLabel">Edit Production Record</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="production_id" id="production_id" value="">
                        <div class="form-group">
                            <label>Big Eggs</label>
                            <input type="number" name="big_eggs" id="edit_big_eggs" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Small Eggs</label>
                            <input type="number" name="small_eggs" id="edit_small_eggs" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Peewee Eggs</label>
                            <input type="number" name="peewee_eggs" id="edit_peewee_eggs" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="edit_production" class="btn btn-primary">Update Production</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showAddModal(penId) {
            document.getElementById('pen_id').value = penId;
            $('#addProductionModal').modal('show');
        }

        function showEditModal(penId, productionId) {
    document.getElementById('production_id').value = productionId;

    // Fetch existing production data for the selected production ID
    $.ajax({
        url: 'fetch_production_data.php', // Create this file to fetch existing data
        type: 'POST',
        data: { production_id: productionId },
        dataType: 'json',
        success: function(data) {
            document.getElementById('edit_big_eggs').value = data.big_eggs; // Echo existing big eggs
            document.getElementById('edit_small_eggs').value = data.small_eggs; // Echo existing small eggs
            document.getElementById('edit_peewee_eggs').value = data.peewee_eggs; // Echo existing peewee eggs
            $('#editProductionModal').modal('show');
        }
    });
}
y
    </script>

</body>
</html>
