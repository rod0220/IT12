<?php
include('../includes/db_connect.php');

if (isset($_GET['pen_id'])) {
    $pen_id = intval($_GET['pen_id']); // Sanitize input to prevent SQL injection
    $query = "SELECT * FROM tbl_pens WHERE pen_id = $pen_id";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $pen = mysqli_fetch_assoc($result);

        // Calculate total ducks
        $total_ducks = intval($pen['male_ducks']) + intval($pen['female_ducks']);

        // Output details for viewing
        echo '<p><strong>Pen Name:</strong> ' . htmlentities($pen['pen_name']) . '</p>';
        echo '<p><strong>Breed:</strong> ' . htmlentities($pen['breed']) . '</p>';
        echo '<p><strong>Male Ducks:</strong> ' . htmlentities($pen['male_ducks']) . '</p>';
        echo '<p><strong>Female Ducks:</strong> ' . htmlentities($pen['female_ducks']) . '</p>';
        echo '<p><strong>Total Ducks:</strong> ' . $total_ducks . '</p>';
        echo '<p><strong>Weeks Old:</strong> ' . htmlentities($pen['weeks_old']) . '</p>';
        echo '<p><strong>Date Added:</strong> ' . date('d F Y', strtotime($pen['ducks_added_date'])) . '</p>';
    } else {
        echo '<p>Error fetching pen details: ' . mysqli_error($conn) . '</p>';
    }
} else {
    echo '<p>Invalid pen ID.</p>';
}
?>
