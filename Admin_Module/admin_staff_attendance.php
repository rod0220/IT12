<?php
include('includes/header.php');
include('../includes/check_login.php');

// Handle form submissions
if (isset($_POST['add_attendance'])) {
    $attendance_date = $_POST['attendance_date'];
    $remarks = $_POST['remarks'];

    foreach ($_POST['staff_attendance'] as $staff_id => $attendance) {
        $status = $attendance['status'];
        $check_in_time = isset($attendance['check_in_time']) ? $attendance['check_in_time'] : null;
        $check_out_time = isset($attendance['check_out_time']) ? $attendance['check_out_time'] : null;
        $hours_worked = isset($attendance['hours_worked']) ? $attendance['hours_worked'] : null;

        $query = "INSERT INTO tbl_attendance (staff_id, attendance_date, check_in_time, check_out_time, status, hours_worked, remarks)
                  VALUES ('$staff_id', '$attendance_date', '$check_in_time', '$check_out_time', '$status', '$hours_worked', '$remarks')";

        $result = mysqli_query($conn, $query);

        if (!$result) {
            die(mysqli_error($conn));
        }
    }

    echo "<script>alert('Attendance Successfully Added');</script>";
}

// Fetch staff members for selection
$staff_query = "SELECT staff_id, CONCAT(first_name, ' ', last_name) AS staff_name FROM tbl_staffs";
$staff_result = mysqli_query($conn, $staff_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff Attendance Checker</title>
</head>
<body>

    <?php include('includes/navbar.php') ?>
    <?php include('includes/right_sidebar.php') ?>
    <?php include('includes/left_sidebar.php') ?>
    <div class="mobile-menu-overlay"></div>
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Staff Attendance Checker</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Staff Attendance</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Add Attendance</h4>
                        </div>
                    </div>
                    <div class="wizard-content">
                        <form method="post" action="">
                            <section>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Attendance Date :</label>
                                            <input 
                                                name="attendance_date" 
                                                type="date" 
                                                class="form-control form-control-lg" 
                                                required 
                                                value="<?php echo date('Y-m-d'); ?>" 
                                            >
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Staff Attendance:</label>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Staff Name</th>
                                                        <th>Present</th>
                                                        <th>Late</th>
                                                        <th>Absent</th>
                                                        <th>Check-in Time</th>
                                                        <th>Check-out Time</th>
                                                        <th>Hours Worked</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while ($staff = mysqli_fetch_assoc($staff_result)) { ?>
                                                        <tr>
                                                            <td><?php echo htmlspecialchars($staff['staff_name']); ?></td>
                                                            <td>
                                                                <input type="radio" name="staff_attendance[<?php echo $staff['staff_id']; ?>][status]" value="Present" required>
                                                            </td>
                                                            <td>
                                                                <input type="radio" name="staff_attendance[<?php echo $staff['staff_id']; ?>][status]" value="Late" required>
                                                            </td>
                                                            <td>
                                                                <input type="radio" name="staff_attendance[<?php echo $staff['staff_id']; ?>][status]" value="Absent" required>
                                                            </td>
                                                            <td>
                                                                <input type="time" name="staff_attendance[<?php echo $staff['staff_id']; ?>][check_in_time]" class="form-control">
                                                            </td>
                                                            <td>
                                                                <input type="time" name="staff_attendance[<?php echo $staff['staff_id']; ?>][check_out_time]" class="form-control">
                                                            </td>
                                                            <td>
                                                                <input type="number" name="staff_attendance[<?php echo $staff['staff_id']; ?>][hours_worked]" step="0.01" class="form-control">
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>Remarks :</label>
                                            <input name="remarks" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <button class="btn btn-primary" name="add_attendance" type="submit">Add Attendance</button>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </form>
                    </div>
                </div>

                <div class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Attendance Records</h4>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Staff Name</th>
                                    <th>Attendance Date</th>
                                    <th>Check-in Time</th>
                                    <th>Check-out Time</th>
                                    <th>Status</th>
                                    <th>Hours Worked</th>
                                    <th>Remarks</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $attendance_query = "SELECT a.*, CONCAT(s.first_name, ' ', s.last_name) AS staff_name 
                                                    FROM tbl_attendance a 
                                                    JOIN tbl_staffs s ON a.staff_id = s.staff_id 
                                                    ORDER BY a.attendance_date DESC";
                                $attendance_result = mysqli_query($conn, $attendance_query);
                                while ($attendance = mysqli_fetch_assoc($attendance_result)) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($attendance['staff_name']); ?></td>
                                        <td><?php echo htmlspecialchars($attendance['attendance_date']); ?></td>
                                        <td><?php echo htmlspecialchars($attendance['check_in_time']); ?></td>
                                        <td><?php echo htmlspecialchars($attendance['check_out_time']); ?></td>
                                        <td><?php echo htmlspecialchars($attendance['status']); ?></td>
                                        <td><?php echo htmlspecialchars($attendance['hours_worked']); ?></td>
                                        <td><?php echo htmlspecialchars($attendance['remarks']); ?></td>
                                        <td>
                                            <a href="admin_attendance_edit.php?id=<?php echo htmlspecialchars($attendance['attendance_id']); ?>" class="btn btn-primary">Edit</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php include('includes/footer.php'); ?>
        </div>
    </div>
    <!-- js -->
    <?php include('includes/scripts.php') ?>
</body>
</html>
