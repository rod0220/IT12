<?php
// admin_pen_transfer.php

include('../includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pen_id = $_POST['pen_id'];
    $destination_pen = $_POST['destination_pen'];
    $male_ducks = intval($_POST['male_ducks']);
    $female_ducks = intval($_POST['female_ducks']);

    // Check if the source pen has enough ducks to transfer
    $source_query = mysqli_query($conn, "SELECT male_ducks, female_ducks FROM tbl_pens WHERE pen_id = $pen_id");
    $source_pen = mysqli_fetch_assoc($source_query);

    if ($source_pen['male_ducks'] >= $male_ducks && $source_pen['female_ducks'] >= $female_ducks) {
        // Deduct ducks from the source pen
        mysqli_query($conn, "UPDATE tbl_pens SET male_ducks = male_ducks - $male_ducks, female_ducks = female_ducks - $female_ducks WHERE pen_id = $pen_id");

        // Add ducks to the destination pen
        mysqli_query($conn, "UPDATE tbl_pens SET male_ducks = male_ducks + $male_ducks, female_ducks = female_ducks + $female_ducks WHERE pen_id = $destination_pen");

        // Success message
        echo "<script>alert('Ducks successfully transferred!'); window.location.href='admin_pen_list.php';</script>";
    } else {
        // Error message if not enough ducks to transfer
        echo "<script>alert('Not enough ducks in the source pen!'); window.location.href='admin_pen_list.php';</script>";
    }
}
?>
