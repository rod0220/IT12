<?php
session_start();
include('includes/db_connect.php');

// Check user role and update status accordingly
if (isset($_SESSION['user_role'])) {
    $user_id = $_SESSION['user_id'];
    $user_role = $_SESSION['user_role'];

    // Update status based on user role
    if ($user_role === 'Admin') {
        $stmt = $conn->prepare("UPDATE tbl_admin SET status = 'Offline' WHERE admin_id = ?");
        $stmt->bind_param("i", $user_id);
    } elseif ($user_role === 'Staff') {
        $stmt = $conn->prepare("UPDATE tbl_staffs SET status = 'Offline' WHERE staff_id = ?");
        $stmt->bind_param("i", $user_id);
    } elseif ($user_role === 'Customer') {
        $stmt = $conn->prepare("UPDATE tbl_customers SET status = 'Offline' WHERE customer_id = ?");
        $stmt->bind_param("i", $user_id);
    }

    if (isset($stmt)) {
        $stmt->execute();
        $stmt->close();
    }
}

// Clear all session variables
$_SESSION = array();

// If cookies are used for sessions, clear the cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 3600,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: public_login.php");
exit();
?>
