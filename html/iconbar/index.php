<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'C:/xampp/htdocs/latest_Dash/backend/functions.php';
$startDate = date_format(date_create(startDate()), "Y-m-d");
$endDate = date_format(date_create(endDate()), "Y-m-d");
?>
<?php include('include/header.php'); ?>
<!-- ============================================================== -->
<!-- End Topbar header -->
<!-- ============================================================== -->
<?php include('include/sidebar.php'); ?>
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Dashboard</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <div class="row">
            <form id="dateRangeForm">
                <label for="startDate">Start Date:</label>
                <input type="date" id="startDate" name="startDate" min="<?php echo $startDate; ?>" max="<?php echo $endDate; ?>">
                <label for="endDate">End Date:</label>
                <input type="date" id="endDate" name="endDate" min="<?php echo $startDate; ?>" max="<?php echo $endDate; ?>">

                <!-- <label for="startDate">Start Date:</label>
                <input type="date" id="startDate" name="startDate">
                <label for="endDate">End Date:</label>
                <input type="date" id="endDate" name="endDate"> -->
                <button type="submit">Apply Date Range</button>
            </form>
        </div>

        <!-- ============================================================== -->
        <div id="cardsContainer" class="card-group">
            <!-- Cards will be displayed here -->
        </div>

        <!-- End Row -->




    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->

</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->


<!-- ============================================================== -->
<!-- customizer Panel -->
<!-- ============================================================== -->
<?php
// include('include/customizer.php'); 
?>
<?php include('include/footer.php'); ?>





<!-- <script src="../../dist/js/pages/c3-chart/line/c3-spline.js"></script> -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const startDateInput = document.getElementById("startDate");
        const endDateInput = document.getElementById("endDate");
        const cardsContainer = document.getElementById("cardsContainer");

        
        startDateInput.value = "<?php echo $startDate; ?>";
        endDateInput.value = "<?php echo $endDate; ?>";

        startDateInput.min = "<?php echo $startDate; ?>";
        startDateInput.max = "<?php echo $endDate; ?>";
        endDateInput.min = "<?php echo $startDate; ?>";
        endDateInput.max = "<?php echo $endDate; ?>";

        const dateRangeForm = document.getElementById("dateRangeForm");

        dateRangeForm.addEventListener("submit", function(event) {
            event.preventDefault();

            const startDate = startDateInput.value;
            const endDate = endDateInput.value;
            // Validate and adjust the selected date range within bounds
            if (startDate < "<?php echo $startDate; ?>") {
                startDateInput.value = "<?php echo $startDate; ?>";
            }
            if (endDate > "<?php echo $endDate; ?>") {
                endDateInput.value = "<?php echo $endDate; ?>";
            }

            // Make an AJAX request
            const xhr = new XMLHttpRequest();
            xhr.open("GET", `get_filtered_data.php?startDate=${startDate}&endDate=${endDate}`);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Update the cards content with the received HTML response
                    cardsContainer.innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        });
    });
</script>

</body>

</html>