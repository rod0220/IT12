<?php
include('../includes/db_connect.php'); // Ensure this connects to your database

if (isset($_GET['batch_id'])) {
    $batch_id = intval($_GET['batch_id']); // Ensure that batch_id is an integer to prevent SQL injection
    
    // Delete the batch
    $delete_query = "DELETE FROM tbl_batches WHERE batch_id = $batch_id";
    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Batch deleted successfully.');</script>";
    } else {
        echo "<script>alert('Error deleting batch.');</script>";
    }
    
    // Redirect back to the batch management page
    echo "<script>window.location.href='admin_batch_add.php';</script>";
} else {
    echo "<script>alert('Invalid batch ID.');</script>";
    echo "<script>window.location.href='admin_batch_add.php';</script>";
}
?>
