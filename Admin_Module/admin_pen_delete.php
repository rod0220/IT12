<?php
// admin_pen_delete.php

include('../includes/db_connect.php');

if (isset($_POST['pen_id'])) {
    $pen_id = $_POST['pen_id'];

    // Check if the pen is empty before deleting
    $pen_query = mysqli_query($conn, "SELECT male_ducks, female_ducks FROM tbl_pens WHERE pen_id = $pen_id");
    $pen = mysqli_fetch_assoc($pen_query);

    if ($pen['male_ducks'] == 0 && $pen['female_ducks'] == 0) {
        // Proceed to delete the pen
        mysqli_query($conn, "DELETE FROM tbl_pens WHERE pen_id = $pen_id");

        // Success message
        echo "<script>alert('Pen successfully deleted!'); window.location.href='admin_pen_list.php';</script>";
    } else {
        // Error message if the pen is not empty
        echo "<script>alert('Cannot delete a pen that still has ducks!'); window.location.href='admin_pen_list.php';</script>";
    }
}
?>
