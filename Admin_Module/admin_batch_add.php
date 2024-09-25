<?php include('includes/header.php'); ?>
<?php include('../includes/check_login.php'); ?>
<?php include('includes/right_sidebar.php'); ?>
<?php include('includes/scripts.php'); ?>


<!-- CSS for Pagination and Batch Cards -->
<style>
        .batch-card {
            color: #524d7d;
            
        }
        .batch-card a:hover {
            color: #524d7d;
        }

        .batch-link {
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
$items_per_page = 4; // Number of batches per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $items_per_page;

// Fetch batches for the current page with pen count
$batch_query = "
    SELECT b.*, COUNT(p.pen_id) AS pen_count 
    FROM tbl_batches b 
    LEFT JOIN tbl_pens p ON b.batch_id = p.batch_id 
    GROUP BY b.batch_id 
    LIMIT $offset, $items_per_page";
$batch_result = mysqli_query($conn, $batch_query);

// Count total batches for pagination
$total_batches_query = "SELECT COUNT(*) as total FROM tbl_batches";
$total_batches_result = mysqli_query($conn, $total_batches_query);
$total_batches = mysqli_fetch_assoc($total_batches_result)['total'];
$total_pages = ceil($total_batches / $items_per_page);

// Handle batch addition
if (isset($_POST['add_batch'])) {
    $batch_name = $_POST['batch_name'];
    $creation_date = date('m F Y'); // Store in "m F Y" format

    // Check if the batch already exists
    $query = mysqli_query($conn, "SELECT * FROM tbl_batches WHERE batch_name = '$batch_name'") or die(mysqli_error($conn));
    $count = mysqli_num_rows($query);

    if ($count > 0) {
        echo "<script>alert('Batch already exists');</script>";
    } else {
        // Insert the batch
        $query = mysqli_query($conn, "INSERT INTO tbl_batches (batch_name, creation_date) VALUES ('$batch_name', '$creation_date')") or die(mysqli_error($conn));
        echo "<script>alert('Batch added successfully');</script>";
        echo "<script type='text/javascript'> document.location = 'admin_batch_add.php'; </script>";
    }
}

// Handle batch update
if (isset($_POST['batch_id'])) {
    $batch_id = $_POST['batch_id'];
    $batch_name = $_POST['batch_name'];
    $creation_date = $_POST['creation_date'];

    // Update batch information in the database
    $update_query = "UPDATE tbl_batches SET batch_name = '$batch_name', creation_date = '$creation_date' WHERE batch_id = $batch_id";
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Batch updated successfully');</script>";
    } else {
        echo "<script>alert('Error updating batch');</script>";
    }
    
    // Redirect back to the page
    echo "<script>window.location.href='admin_batch_add.php';</script>";
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
                                <h4>Batch Management</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Batch Management</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Add Batch Form -->
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-30">
                        <div class="pd-20 card-box mb-30" style="background-color: white;">
                            <div class="clearfix">
                                <div class="pull-left">
                                    <h4 class="text-blue h4">Add New Batch</h4>
                                    <p class="mb-20"></p>
                                </div>
                            </div>
                            <form method="post" action="" onsubmit="return formatDate()">
                                <div class="form-group">
                                    <label>Batch Name</label>
                                    <input name="batch_name" type="text" class="form-control" required autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Creation Date</label>
                                    <input name="creation_date" id="creation_date" type="text" class="form-control form-control-lg date-picker" required value="<?php echo date('d F Y'); ?>">
                                </div>
                                <div class="text-right">
                                    <input class="btn btn-primary" type="submit" value="Add Batch" name="add_batch">
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Display Batches in Separate Cards -->
                    <div class="col-lg-8 col-md-6 col-sm-12 mb-30">
                        <div class="pd-20 card-box mb-30" style="background-color: white;">
                            <h4 class="text-blue h4">Existing Batches</h4>
                            <br>
                            <div class="row">
                                <br>
                                <?php while ($batch = mysqli_fetch_assoc($batch_result)) { ?>
                                    <div class="col-lg-6 col-md-6 col-sm-12 mb-30">
                                        <div class="batch-card card-box" style="background-color: white; border: 1px solid #ddd; border-radius: 8px; padding: 15px; display: flex; justify-content: space-between; align-items: center; position: relative;">
                                            <!-- Batch Details -->
                                            <a href="admin_pen_add.php?batch_id=<?php echo htmlentities($batch['batch_id']); ?>" class="batch-link" style="text-decoration: none; color: inherit;">
                                                <h4 style="color: #031e23;"><?php echo htmlentities($batch['batch_name']); ?></h4><br>
                                                <p style="color: gray;">Creation Date: <?php echo htmlentities($batch['creation_date']); ?></p>
                                                <p style="color: gray;">Number of Pens: <?php echo htmlentities($batch['pen_count']); ?></p>
                                            </a>
                                            <!-- Dropdown menu -->
                                        <div class="dropdown" style="position: absolute; right: 15px; top: 15px;">
                                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                <i class="dw dw-more"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                <a class="dropdown-item edit-btn" href="#"
                                                data-batch-id="<?php echo htmlentities($batch['batch_id']); ?>"
                                                data-batch-name="<?php echo htmlentities($batch['batch_name']); ?>"
                                                data-creation-date="<?php echo htmlentities($batch['creation_date']); ?>">
                                                <i class="dw dw-edit2"></i> Edit
                                                </a>
                                                <a class="dropdown-item delete-btn" href="admin_batch_delete.php?batch_id=<?php echo htmlentities($batch['batch_id']); ?>">
                                                    <i class="dw dw-delete-3"></i> Delete
                                                </a>
                                            </div>
                                        </div>

                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                            <!-- Pagination controls -->
                            <div class="pagination">
                            
                                <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                    <a href="admin_batch_add.php?page=<?php echo $i; ?>" <?php if ($i == $page) echo 'class="active"'; ?>><?php echo $i; ?></a>
                                <?php } ?>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('includes/footer.php'); ?>
        
        </div>
    </div>

    <div class="modal fade" id="editBatchModal" tabindex="-1" role="dialog" aria-labelledby="editBatchModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBatchModalLabel">Edit Batch</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editBatchForm" method="post" action="admin_batch_add.php" onsubmit="return formatDate()">
                    <input type="hidden" name="batch_id" id="batch_id">
                    <div class="form-group">
                        <label for="batch_name">Batch Name</label>
                        <input type="text" class="form-control" id="batch_name" name="batch_name" required>
                    </div>
                    <div class="form-group">
                        <label for="creation_date">Creation Date</label>
                        <input type="" class="form-control form-control-lg date-picker" required value="<?php echo date('d F Y'); ?>" required id="creation_date" name="creation_date">
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Wait for the document to load
    $(document).ready(function() {
        // Handle Edit Button Click
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function () {
                const batchId = this.getAttribute('data-batch-id');
                const batchName = this.getAttribute('data-batch-name');
                const creationDate = this.getAttribute('data-creation-date'); // Ensure this is in "d F Y" format

                document.getElementById('batch_id').value = batchId;
                document.getElementById('batch_name').value = batchName;
                document.getElementById('creation_date').value = creationDate; // Set value for modal input

                $('#editBatchModal').modal('show'); // Show the modal
            });
        });
    });

    function formatDate() {
        var dateInput = document.getElementById('creation_date');
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



</body>
</html>
