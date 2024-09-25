<?php
include('../includes/db_connect.php'); // Adjust the path as necessary

if (isset($_POST['production_id'])) {
    $production_id = $_POST['production_id'];

    // Prepare the query to fetch the production data
    $query = "SELECT big_eggs, small_eggs, peewee_eggs FROM tbl_production WHERE production_id = '$production_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = mysqli_fetch_assoc($result);
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'No data found']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
