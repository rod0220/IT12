<?php
include('../includes/db_connect.php'); // Ensure this connects to your database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $pen_id = isset($_POST['pen_id']) ? intval($_POST['pen_id']) : 0;
    $pen_name = isset($_POST['pen_name']) ? mysqli_real_escape_string($conn, $_POST['pen_name']) : '';
    $breed = isset($_POST['breed']) ? mysqli_real_escape_string($conn, $_POST['breed']) : '';
    $weeks_old = isset($_POST['weeks_old']) ? intval($_POST['weeks_old']) : 0;
    $ducks_added_date = isset($_POST['ducks_added_date']) ? mysqli_real_escape_string($conn, $_POST['ducks_added_date']) : '';

    // Format date to SQL format
    $formatted_date = date('Y-m-d', strtotime($ducks_added_date));

    // Update query
    $update_query = "UPDATE tbl_pens SET 
                    pen_name = '$pen_name', 
                    breed = '$breed', 
                    weeks_old = $weeks_old, 
                    ducks_added_date = '$formatted_date' 
                    WHERE pen_id = $pen_id";

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Pen updated successfully.');</script>";
    } else {
        echo "<script>alert('Error updating pen: " . mysqli_error($conn) . "');</script>";
    }
    
    // Redirect back to the pen management page
    echo "<script>window.location.href='admin_batch_add.php';</script>";
} else {
    echo "<script>alert('Invalid request.');</script>";
    echo "<script>window.location.href='admin_batch_add.php';</script>";
}
?>
