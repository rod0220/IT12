<?php
include('../includes/db_connect.php');

// Check if the admin account already exists
$checkAdmin = "SELECT * FROM tbl_admin WHERE email = 'admin@example.com'";
$result = mysqli_query($conn, $checkAdmin);

if (mysqli_num_rows($result) == 0) {
    // Insert the first admin account
    $username = 'admin';
    $first_name = 'First';
    $last_name = 'Admin';
    $password = md5('admin123'); // Assuming MD5 hashing
    $phone_number = '1234567890'; // Optional field, can be changed
    $email = 'admin@example.com';

    $sql = "INSERT INTO tbl_admin (username, password, first_name, last_name, phone_number, email, created_at) 
            VALUES ('$username', '$password', '$first_name', '$last_name', '$phone_number', '$email', NOW())";

    if (mysqli_query($conn, $sql)) {
        echo "Admin account created successfully!";
    } else {
        echo "Error creating admin account: " . mysqli_error($conn);
    }
} else {
    echo "Admin account already exists!";
}
?>
