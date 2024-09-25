<div class="header">
    <div class="header-left">
        <div class="menu-icon dw dw-menu"></div>
        <div class="" data-toggle="header_search"></div>
    </div>
    <div class="header-right">
        <div class="dashboard-setting user-notification">
            <div class="dropdown">
                <a class="dropdown-toggle no-arrow" href="javascript:;" data-toggle="right-sidebar">
                    <i class="dw dw-settings2"></i>
                </a>
            </div>
        </div>
        
        <div class="user-info-dropdown">
            <div class="dropdown">
                <?php
                // Determine table and column to query based on role
                if ($session_role == 'Admin') {
                    $table = 'tbl_admin';
                    $id_column = 'admin_id';  // Use the correct column name
                } elseif ($session_role == 'Staff') {
                    $table = 'tbl_staffs';
                    $id_column = 'staff_id';  // Use the correct column name
                } elseif ($session_role == 'Customer') {
                    $table = 'tbl_customers';
                    $id_column = 'customer_id';  // Use the correct column name
                } else {
                    $table = '';
                    $id_column = '';  // Fallback or error handling
                }
                
                if ($table && $id_column) {
                    $query = mysqli_query($conn, "SELECT * FROM $table WHERE $id_column = '$session_id'") or die(mysqli_error($conn));
                    $row = mysqli_fetch_array($query);
                }
                ?>
                
                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                    <span class="user-icon">
                        <img src="<?php echo (!empty($row['profile_picture'])) ? '../uploads/'.$row['profile_picture'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>" alt="">
                    </span>
                    <span class="user-name"><?php echo $row['first_name'] . " " . $row['last_name']; ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                    <a class="dropdown-item" href="admin_profile.php"><i class="dw dw-user1"></i> Profile</a>
                    <a class="dropdown-item" href="../logout.php"><i class="dw dw-logout"></i> Log Out</a>
                </div>
            </div>
        </div>
    </div>
</div>
