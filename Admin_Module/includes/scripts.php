<head>
    <!-- Other head content -->
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body, h1, h2, h3, h4, h5, h6, p, a, button, input, select, textarea {
            font-family: 'Poppins', sans-serif !important;
            font-weight: 400;
        }
    </style>
</head>



<body>
    <!-- Your content -->

    <!-- Script files -->
    <script src="../vendors/scripts/core.js"></script>
    <script src="../vendors/scripts/script.min.js"></script>
    <script src="../vendors/scripts/process.js"></script>
    <script src="../vendors/scripts/layout-settings.js"></script>
    <script src="../src/plugins/apexcharts/apexcharts.min.js"></script>
    <script src="../src/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="../src/plugins/datatables/js/dataTables.responsive.min.js"></script>
    <script src="../src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
    <script src="../vendors/scripts/datagraph.js"></script>
	

    <!-- Buttons for Export Datatable -->
    <script src="../src/plugins/datatables/js/dataTables.buttons.min.js"></script>
    <script src="../src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
    <script src="../src/plugins/datatables/js/buttons.print.min.js"></script>
    <script src="../src/plugins/datatables/js/buttons.html5.min.js"></script>
    <script src="../src/plugins/datatables/js/buttons.flash.min.js"></script>
    <script src="../src/plugins/datatables/js/pdfmake.min.js"></script>
    <script src="../src/plugins/datatables/js/vfs_fonts.js"></script>
    <script src="../vendors/scripts/advanced-components.js"></script>


	<script>
function formatDate() {
    var dateInput = document.getElementById('creation_date');
    var dateValue = dateInput.value;

    // Convert date from "19 September 2024" to "2024-09-19"
    var dateParts = dateValue.split(' ');
    var day = dateParts[0];
    var month = new Date(Date.parse(dateParts[1] + " 1, 2020")).getMonth() + 1; // Get month index
    var year = dateParts[2];

    // Add leading zeros to day and month if needed
    if (day.length < 2) {
        day = '0' + day;
    }
    if (month < 10) {
        month = '0' + month;
    }

    // Set the value in the format YYYY-MM-DD
    dateInput.value = year + '-' + month + '-' + day;

    return true; // Allow form submission
}
</script>

</body>
