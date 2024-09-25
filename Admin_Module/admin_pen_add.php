<?php include('includes/header.php'); ?>
<?php include('../includes/check_login.php'); ?>
<?php include('includes/right_sidebar.php'); ?>
<?php include('includes/scripts.php'); ?>

<!-- CSS for Pagination and Pen Cards -->
<style>
    .pen-card {
        color: #524d7d;
    }
    .pen-card a:hover {
        color: #524d7d;
    }
    .pen-link {
        color: inherit;
    }
    .dropdown-menu {
        min-width: 160px;
    }
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }
    .pagination a {
        margin: 0 5px;
        padding: 8px 18px;
        border: 1px solid #ddd;
        border-radius: 5px;
        text-decoration: none;
        color: #524d7d;
    }
    .pagination a.active {
        background-color: #524d7d;
        color: white;
        padding: 8px 18px;
    }
    .pagination a:hover {
        background-color: #ddd;
    }
</style>

<?php
// Pagination setup
$items_per_page = 4; // Number of pens per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $items_per_page;

// Fetch the batch ID
$batch_id = isset($_GET['batch_id']) ? intval($_GET['batch_id']) : 0;

// Fetch the batch name
$batch_query = "SELECT batch_name FROM tbl_batches WHERE batch_id = $batch_id";
$batch_result = mysqli_query($conn, $batch_query);
$batch_name = mysqli_num_rows($batch_result) > 0 ? mysqli_fetch_assoc($batch_result)['batch_name'] : 'Unknown Batch';

// Fetch pens for the current page with duck counts
$pen_query = "
    SELECT * FROM tbl_pens 
    WHERE batch_id = $batch_id 
    LIMIT $offset, $items_per_page";
$pen_result = mysqli_query($conn, $pen_query);

// Count total pens for pagination
$total_pens_query = "SELECT COUNT(*) as total FROM tbl_pens WHERE batch_id = $batch_id";
$total_pens_result = mysqli_query($conn, $total_pens_query);
$total_pens = mysqli_fetch_assoc($total_pens_result)['total'];
$total_pages = ceil($total_pens / $items_per_page);

// Handle pen addition
if (isset($_POST['add_pen'])) {
    $pen_name = $_POST['pen_name'];
    $breed = $_POST['breed'];

    // Check if the batch already has 2 pens
    $pen_count_query = mysqli_query($conn, "SELECT COUNT(*) as pen_count FROM tbl_pens WHERE batch_id = $batch_id");
    $pen_count = mysqli_fetch_assoc($pen_count_query)['pen_count'];

    if ($pen_count >= 2) {
        echo "<script>alert('This batch already has 2 pens.');</script>";
    } else {
        // Insert the pen with breed
        $query = mysqli_query($conn, "INSERT INTO tbl_pens (pen_name, batch_id, breed) VALUES ('$pen_name', $batch_id, '$breed')") 
            or die(mysqli_error($conn));

        // Update the number of pens in the tbl_batches
        $update_batch_query = mysqli_query($conn, "UPDATE tbl_batches SET number_of_pens = number_of_pens + 1 WHERE batch_id = $batch_id") 
            or die(mysqli_error($conn));
        
        echo "<script>alert('Pen added successfully');</script>";
        echo "<script type='text/javascript'> document.location = 'admin_pen_add.php?batch_id=" . $batch_id . "';</script>";
    }
}

// Handle pen deletion
if (isset($_POST['delete_pen'])) {
    $pen_id = intval($_POST['pen_id']);
    $delete_query = mysqli_query($conn, "DELETE FROM tbl_pens WHERE pen_id = $pen_id") or die(mysqli_error($conn));
    
    if ($delete_query) {
        // Update the number of pens in the tbl_batches
        $update_batch_query = mysqli_query($conn, "UPDATE tbl_batches SET number_of_pens = number_of_pens - 1 WHERE batch_id = $batch_id") or die(mysqli_error($conn));
        
        echo "<script>alert('Pen deleted successfully');</script>";
        echo "<script type='text/javascript'> document.location = 'admin_pen_add.php?batch_id=" . $batch_id . "';</script>";
    } else {
        echo "<script>alert('Failed to delete pen');</script>";
    }
}

// Handle adding ducks
if (isset($_POST['add_ducks'])) {
    $pen_id = intval($_POST['pen_id']);
    $male_ducks = isset($_POST['male_ducks']) ? intval($_POST['male_ducks']) : 0;
    $female_ducks = isset($_POST['female_ducks']) ? intval($_POST['female_ducks']) : 0;
    $weeks_old = isset($_POST['weeks_old']) ? intval($_POST['weeks_old']) : 0;
    $ducks_added_date = isset($_POST['ducks_added_date']) ? date('m F Y', strtotime($_POST['ducks_added_date'])) : date('m F Y');

    $update_query = mysqli_query($conn, "UPDATE tbl_pens 
        SET male_ducks = male_ducks + $male_ducks, 
            female_ducks = female_ducks + $female_ducks,
            weeks_old = $weeks_old,
            ducks_added_date = '$ducks_added_date' 
        WHERE pen_id = $pen_id") 
        or die(mysqli_error($conn));
    
    if ($update_query) {
        echo "<script>alert('Ducks added successfully');</script>";
        echo "<script type='text/javascript'> document.location = 'admin_pen_add.php?batch_id=" . $batch_id . "';</script>";
    } else {
        echo "<script>alert('Failed to add ducks');</script>";
    }
}

// Handle transferring ducks
if (isset($_POST['transfer_ducks'])) {
    $from_pen_id = isset($_POST['from_pen_id']) ? intval($_POST['from_pen_id']) : 0;
    $to_pen_id = isset($_POST['to_pen_id']) ? intval($_POST['to_pen_id']) : 0;
    $male_ducks = isset($_POST['male_ducks']) ? intval($_POST['male_ducks']) : 0;
    $female_ducks = isset($_POST['female_ducks']) ? intval($_POST['female_ducks']) : 0;

    if ($from_pen_id === 0 || $to_pen_id === 0 || $from_pen_id === $to_pen_id) {
        echo "<script>alert('Invalid pen selection');</script>";
    } else {
        $from_pen_query = mysqli_query($conn, "SELECT male_ducks, female_ducks FROM tbl_pens WHERE pen_id = $from_pen_id");
        $from_pen = mysqli_fetch_assoc($from_pen_query);

        if ($from_pen['male_ducks'] >= $male_ducks && $from_pen['female_ducks'] >= $female_ducks) {
            $update_from_query = mysqli_query($conn, "UPDATE tbl_pens 
                SET male_ducks = male_ducks - $male_ducks, 
                    female_ducks = female_ducks - $female_ducks 
                WHERE pen_id = $from_pen_id");

            $update_to_query = mysqli_query($conn, "UPDATE tbl_pens 
                SET male_ducks = male_ducks + $male_ducks, 
                    female_ducks = female_ducks + $female_ducks 
                WHERE pen_id = $to_pen_id");

            if ($update_from_query && $update_to_query) {
                echo "<script>alert('Ducks transferred successfully');</script>";
                echo "<script type='text/javascript'> document.location = 'admin_pen_add.php?batch_id=" . $batch_id . "';</script>";
            } else {
                echo "<script>alert('Failed to transfer ducks');</script>";
            }
        } else {
            echo "<script>alert('Not enough ducks to transfer');</script>";
        }
    }
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
                        <h4>Pen Management for <?php echo htmlentities($batch_name); ?></h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="admin_batch_add.php">Batch Management</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Pen Management</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>


                <div class="row">
    <!-- Add Pen Form -->
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-30">
                            <div class="pd-20 card-box mb-30" style="background-color: white;">
                                <div class="clearfix">
                                    <div class="pull-left">
                                        <h4 class="text-blue h4">Add New Pen</h4>
                                        <p class="mb-20"></p>
                                    </div>
                                </div>
                                <form method="post" action="">
                                    <input type="hidden" name="batch_id" value="<?php echo htmlentities($batch_id); ?>">
                                    <div class="form-group">
                                        <label>Pen Name</label>
                                        <input name="pen_name" type="text" class="form-control" required autocomplete="off">
                                    </div>

                                    <!-- Breed Dropdown -->
                                    <div class="form-group">
                                        <label>Breed</label>
                                        <select name="breed" class="form-control" required>
                                            <option value="" disabled selected>Select Breed</option>
                                            <option value="Pateros">Pateros</option>
                                            <option value="Itik Pinas (IP)">Itik Pinas (IP)</option>
                                        </select>
                                    </div>

                                    <div class="text-right">
                                        <input class="btn btn-primary" type="submit" value="Add Pen" name="add_pen">
                                    </div>
                                </form>
                            </div>
                        </div>
            

                    <!-- Display Pens in Separate Cards -->
                    <div class="col-lg-8 col-md-6 col-sm-12 mb-30">
                        <div class="pd-20 card-box mb-30" style="background-color: white;">
                            <h4 class="text-blue h4">Existing Pens</h4>
                            <br>
                            <div class="row">
                                <?php while ($pen = mysqli_fetch_assoc($pen_result)) { ?>
                                    <div class="col-lg-6 col-md-6 col-sm-12 mb-30">
                                        <div class="pen-card card-box" style="background-color: white; border: 1px solid #ddd; border-radius: 8px; padding: 15px; display: flex; justify-content: space-between; align-items: center; position: relative;">
                                            <!-- Pen Details -->
                                            <a href="#" class="pen-link" style="text-decoration: none; color: inherit;">
                                                <h4 style="color: #031e23;"><?php echo htmlentities($pen['pen_name']); ?></h4><br>
                                                <p style="color: gray;">Breed: <?php echo htmlentities($pen['breed']); ?></p>
                                                <p style="color: gray;">Male Ducks: <?php echo htmlentities($pen['male_ducks']); ?></p>
                                                <p style="color: gray;">Female Ducks: <?php echo htmlentities($pen['female_ducks']); ?></p>
                                                <p style="color: gray;">Weeks old: <?php echo htmlentities($pen['weeks_old']); ?></p>
                                            </a>
                                            <!-- Dropdown menu -->
                                            <div class="dropdown" style="position: absolute; right: 15px; top: 15px;">
                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                    <i class="dw dw-more"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <a class="dropdown-item add-ducks-btn" href="#" data-pen-id="<?php echo htmlentities($pen['pen_id']); ?>">
                                                        <i class="dw dw-add"></i> Add Ducks
                                                    </a>
                                                    <a class="dropdown-item transfer-ducks-btn" href="#" data-pen-id="<?php echo htmlentities($pen['pen_id']); ?>">
                                                        <i class="dw dw-exchange"></i> Transfer Ducks
                                                    </a>
                                                    <a class="dropdown-item edit-btn" href="#" 
    data-pen-id="<?php echo htmlentities($pen['pen_id']); ?>" 
    data-pen-name="<?php echo htmlentities($pen['pen_name']); ?>" 
    data-breed="<?php echo htmlentities($pen['breed']); ?>" 
    data-weeks-old="<?php echo $pen['weeks_old']; ?>" 
    data-ducks-added-date="<?php echo date('d F Y', strtotime($pen['ducks_added_date'])); ?>">
    <i class="dw dw-edit2"></i> Edit
</a>

                                                    <a class="dropdown-item details-btn" href="#" data-pen-id="<?php echo htmlentities($pen['pen_id']); ?>">
                                                        <i class="dw dw-eye"></i> Details
                                                    </a>
                                                    <form method="post" action="" style="display:inline;">
                                                        <input type="hidden" name="pen_id" value="<?php echo htmlentities($pen['pen_id']); ?>">
                                                        <button type="submit" name="delete_pen" class="dropdown-item text-danger">
                                                            <i class="dw dw-delete-3"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>  
                    </div> 
                </div>
                <?php include('includes/footer.php'); ?>
                <!-- Modals for Adding Ducks -->
                    <div id="addDucksModal" class="modal fade" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Ducks</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post" action="">
                                    <div class="modal-body">
                                        <input type="hidden" name="pen_id" id="modalPenId">
                                        
                                        <div class="form-group">
                                            <label for="male_ducks">Number of Male Ducks</label>
                                            <input type="number" name="male_ducks" id="male_ducks" class="form-control" min="0">
                                        </div>

                                        <div class="form-group">
                                            <label for="female_ducks">Number of Female Ducks</label>
                                            <input type="number" name="female_ducks" id="female_ducks" class="form-control" min="0">
                                        </div>

                                        <!-- New field for weeks old -->
                                        <div class="form-group">
                        <label for="weeks_old">Weeks Old</label>
                        <input type="number" class="form-control" id="weeks_old" name="weeks_old" min="0" required>
                    </div>

                                        <!-- New field for ducks_added_date -->
                                        <div class="form-group">
                                        <label for="ducks_added_date">Date Added</label>
                                        <input type="text" name="ducks_added_date" id="ducks_added_date" class="form-control form-control-lg date-picker" required value="<?php echo date('m F Y'); ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" name="add_ducks" class="btn btn-primary">Add Ducks</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                <!-- Transfer Ducks Modal -->
                <div class="modal fade" id="transferDucksModal" tabindex="-1" role="dialog" aria-labelledby="transferDucksModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form method="post" action="">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="transferDucksModalLabel">Transfer Ducks</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="from_pen_id" id="from_pen_id">
                                    
                                    <div class="form-group">
                                        <label for="to_pen_id">Select Destination Pen</label>
                                        <select name="to_pen_id" id="to_pen_id" class="form-control" required>
                                            <!-- Populate this dynamically with available pens -->
                                            <?php
                                            $all_pens_query = mysqli_query($conn, "SELECT * FROM tbl_pens WHERE batch_id = $batch_id");
                                            while ($pen = mysqli_fetch_assoc($all_pens_query)) {
                                                echo "<option value='" . $pen['pen_id'] . "'>" . htmlentities($pen['pen_name']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="male_ducks">Male Ducks to Transfer</label>
                                        <input type="number" name="male_ducks" id="male_ducks" class="form-control" min="0">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="female_ducks">Female Ducks to Transfer</label>
                                        <input type="number" name="female_ducks" id="female_ducks" class="form-control" min="0">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="transfer_ducks">Transfer Ducks</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit Pen Modal -->
<!-- Edit Pen Modal -->
<div class="modal fade" id="editPenModal" tabindex="-1" role="dialog" aria-labelledby="editPenModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPenModalLabel">Edit Pen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editPenForm" method="post" action="admin_pen_edit.php" onsubmit="return formatDate()">
                    <input type="hidden" name="pen_id" id="pen_id" value="<?php echo isset($pen['pen_id']) ? htmlentities($pen['pen_id']) : ''; ?>">
                    
                    <div class="form-group">
                        <label for="pen_name">Pen Name</label>
                        <input type="text" class="form-control" id="pen_name" name="pen_name" required value="<?php echo isset($pen['pen_name']) ? htmlentities($pen['pen_name']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="breed">Breed</label>
                        <select class="form-control" id="breed" name="breed" required>
                            <option value="Pateros" <?php echo (isset($pen['breed']) && $pen['breed'] == 'Pateros') ? 'selected' : ''; ?>>Pateros</option>
                            <option value="Itik Pinas (IP)" <?php echo (isset($pen['breed']) && $pen['breed'] == 'Itik Pinas (IP)') ? 'selected' : ''; ?>>Itik Pinas (IP)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="weeks_old">Weeks Old</label>
                        <input type="number" class="form-control" id="weeks_old" name="weeks_old" min="0" required value="<?php echo isset($pen['weeks_old']) ? htmlentities($pen['weeks_old']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="ducks_added_date">Date Added</label>
                        <input type="text" class="form-control form-control-lg date-picker" required id="ducks_added_date" name="ducks_added_date" value="<?php echo isset($pen['ducks_added_date']) ? date('d F Y', strtotime($pen['ducks_added_date'])) : ''; ?>">
                    </div>

                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>




                <!-- Modal for Pen Details -->
                <div id="penDetailsModal" class="modal fade" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Pen Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div id="penDetailsContent"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>


    <!-- Scripts to Handle Modals -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add Ducks Modal
            document.querySelectorAll('.add-ducks-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    var penId = button.getAttribute('data-pen-id');
                    document.getElementById('modalPenId').value = penId;
                    $('#addDucksModal').modal('show');
                });
            });

        
    // When the transfer button is clicked, open the modal and set the from_pen_id
    document.querySelectorAll('.transfer-ducks-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const penId = this.getAttribute('data-pen-id');
            document.getElementById('from_pen_id').value = penId;
            
            // Show the modal
            $('#transferDucksModal').modal('show');
        });
    });



            // Pen Details Modal
            document.querySelectorAll('.details-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    var penId = button.getAttribute('data-pen-id');
                    fetch('fetch_pen_details.php?pen_id=' + penId)
                        .then(response => response.text())
                        .then(data => {
                            document.getElementById('penDetailsContent').innerHTML = data;
                            $('#penDetailsModal').modal('show');
                        });
                });
            });
        });

    
        $(document).ready(function() {
    $('.edit-btn').on('click', function() {
        const penId = $(this).data('pen-id');
        const penName = $(this).data('pen-name');
        const breed = $(this).data('breed');
        const weeksOld = $(this).data('weeks-old');
        const ducksAddedDate = $(this).data('ducks-added-date');

        // Populate the modal fields
        $('#pen_id').val(penId);
        $('#pen_name').val(penName);
        $('#breed').val(breed);
        $('#weeks_old').val(weeksOld);
        $('#ducks_added_date').val(ducksAddedDate);

        $('#editPenModal').modal('show'); // Show the modal
    });
});





    function formatDate() {
        var dateInput = document.getElementById('ducks_added_date');
        var dateValue = dateInput.value;

        // Check if dateValue is not empty
        if (!dateValue) return true; // Allow submission if no value

        // Convert date from "19 September 2024" to "2024-09-19"
        var dateParts = dateValue.split(' ');
        var day = dateParts[0];
        var month = new Date(Date.parse(dateParts[1] + " 1, 2020")).getMonth() + 1; // Get month index
        var year = dateParts[2];

        // Add leading zeros to day and month if needed
        day = day.length < 2 ? '0' + day : day;
        month = month < 10 ? '0' + month : month;

        // Set the value in the format YYYY-MM-DD
        dateInput.value = year + '-' + month + '-' + day;

        return true; // Allow form submission
    }



    </script>
    <!-- Bootstrap and jQuery -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
