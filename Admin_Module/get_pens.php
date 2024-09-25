<?php
include('../includes/db_connect.php');

$batch_id = isset($_GET['batch_id']) ? intval($_GET['batch_id']) : 0;

$pen_query = "SELECT * FROM tbl_pens WHERE batch_id = $batch_id";
$pen_result = mysqli_query($conn, $pen_query);

$pens = [];
while ($pen = mysqli_fetch_assoc($pen_result)) {
    $pens[] = $pen;
}

echo json_encode($pens);
?>
