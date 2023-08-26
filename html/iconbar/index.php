<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'C:/xampp/htdocs/latest_Dash/backend/functions.php';
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
        <!-- ============================================================== -->   
        <?php
echo '<div class="card-group">';

$HydroSubCategoryQueries = array(
    "SELECT SUM(Energy_MWh) AS TotalEnergy FROM mw_new WHERE sub_categories_by_fuel = 'HYDEL'",
    "SELECT SUM(Energy_MWh) AS TotalEnergy FROM mw_new WHERE sub_categories_by_fuel = 'IPPS HYDEL HYDEL'"
);
$HydroSubCategoryNames = array(
    "Private",
    "Public"
);
generateCategoryCardnew("HYDRO", count($HydroSubCategoryQueries), $HydroSubCategoryQueries, "mdi mdi-water text-info ", $HydroSubCategoryNames);

$RenewableSubCategoryQueries = array(
    "SELECT SUM(Energy_MWh) AS TotalEnergy FROM mw_new WHERE sub_categories_by_fuel = 'SOLAR'",
    "SELECT SUM(Energy_MWh) AS TotalEnergy FROM mw_new WHERE sub_categories_by_fuel = 'WIND'",
    "SELECT SUM(Energy_MWh) AS TotalEnergy FROM mw_new WHERE sub_categories_by_fuel = 'IPPS BAGASSE BAGASSE'"
);
$RenewableSubCategoryNames = array(
    "Solar",
    "Wind",
    "Bagasse"
);
generateCategoryCardnew("RENEWABLE", count($RenewableSubCategoryQueries), $RenewableSubCategoryQueries, "mdi mdi-tree text-success", $RenewableSubCategoryNames);

$NuclearSubCategoryQueries = array(
    "SELECT SUM(Energy_MWh) AS TotalEnergy FROM mw_new WHERE sub_categories_by_fuel = 'NUCLEAR'"
);
$NuclearSubCategoryNames = array(
    "Nuclear"
);
generateCategoryCardnew("NUCLEAR", count($NuclearSubCategoryQueries), $NuclearSubCategoryQueries, "mdi mdi-radioactive text-danger ", $NuclearSubCategoryNames);

$ThermalSubCategoryQueries = array(
    "SELECT SUM(Energy_MWh) AS TotalEnergy FROM mw_new WHERE sub_categories_by_fuel IN ('GENCOS Gas', 'GENCOS Coal', 'GENCOS RLNG')",
    "SELECT SUM(Energy_MWh) AS TotalEnergy FROM mw_new WHERE sub_categories_by_fuel IN ('IPPS FOSSIL FUEL Gas', 'IPPS FOSSIL FUEL Coal', 'IPPS FOSSIL FUEL FO', 'IPPS FOSSIL FUEL RLNG')"
);
$ThermalSubCategoryNames = array(
    "Gencos",
    "IPPS"
);
generateCategoryCardnew("THERMAL", count($ThermalSubCategoryQueries), $ThermalSubCategoryQueries, "mdi mdi-fire text-warning ", $ThermalSubCategoryNames);

echo '</div>';



        ?>
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
</body>

</html>