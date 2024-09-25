<?php
session_start();

// Check if the session variable 'user_id' is set, otherwise redirect to public_login.php
if (!isset($_SESSION['user_id']) || trim($_SESSION['user_id']) == '') { ?>
    <script>
    window.location = "public_login.php"; // Redirect to the updated login page
    </script>
<?php
} else {
    // Store session variables
    $session_id = $_SESSION['user_id']; // Stores the ID (could be from tbl_admin, tbl_staffs, or tbl_customers)
    $session_role = $_SESSION['user_role']; // Stores the user's role ('Admin', 'Staff', or 'Customer')
}
?>
