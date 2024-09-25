<?php include('includes/header.php'); ?>
<?php include('../includes/check_login.php'); ?>
<?php include('includes/right_sidebar.php'); ?>
<?php include('includes/scripts.php'); ?>

<?php
// Handle product addition
if (isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $product_type = $_POST['product_type'];
    $quantity_in_stock = $_POST['quantity_in_stock'];
    $price_per_unit = $_POST['price_per_unit'];

    // Insert the new product into the database
    $query = mysqli_query($conn, "INSERT INTO tbl_products (product_name, product_type, quantity_in_stock, price_per_unit) 
        VALUES ('$product_name', '$product_type', '$quantity_in_stock', '$price_per_unit')") or die(mysqli_error($conn));
    
    echo "<script>alert('Product added successfully');</script>";
    echo "<script type='text/javascript'> document.location = 'admin_products.php'; </script>";
}

// Fetch all product records
$product_query = "SELECT * FROM tbl_products ORDER BY created_at DESC";
$product_result = mysqli_query($conn, $product_query);
?>

<body>
    <?php include('includes/navbar.php'); ?>
    <?php include('includes/left_sidebar.php'); ?>
    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Product Management</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Products</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Add Product Form -->
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-30">
                        <div class="pd-20 card-box mb-30" style="background-color: white;">
                            <div class="clearfix">
                                <div class="pull-left">
                                    <h4 class="text-blue h4">Add New Product</h4>
                                    <p class="mb-20"></p>
                                </div>
                            </div>
                            <form method="post" action="">
                                <div class="form-group">
                                    <label>Product Name</label>
                                    <input name="product_name" type="text" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Product Type</label>
                                    <select name="product_type" class="form-control" required>
                                        <option value="Egg">Egg</option>
                                        <option value="Meat">Meat</option>
                                        <option value="Chick">Chick</option>
                                        <option value="Breeder">Breeder</option>
                                        <option value="Cull">Cull</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Quantity in Stock</label>
                                    <input name="quantity_in_stock" type="number" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Price per Unit</label>
                                    <input name="price_per_unit" type="text" class="form-control" required>
                                </div>
                                <div class="text-right">
                                    <input class="btn btn-primary" type="submit" value="Add Product" name="add_product">
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Display Existing Products -->
                    <div class="col-lg-8 col-md-6 col-sm-12 mb-30">
                        <div class="pd-20 card-box mb-30" style="background-color: white;">
                            <h4 class="text-blue h4">Products</h4>
                            <br>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Type</th>
                                        <th>Quantity in Stock</th>
                                        <th>Price per Unit</th>
                                        <th>Date Added</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($product = mysqli_fetch_assoc($product_result)) { ?>
                                        <tr>
                                            <td><?php echo htmlentities($product['product_name']); ?></td>
                                            <td><?php echo htmlentities($product['product_type']); ?></td>
                                            <td><?php echo htmlentities($product['quantity_in_stock']); ?></td>
                                            <td><?php echo htmlentities($product['price_per_unit']); ?></td>
                                            <td><?php echo htmlentities($product['created_at']); ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('includes/footer.php'); ?>
        
        </div>
    </div>
</body>

</html>
