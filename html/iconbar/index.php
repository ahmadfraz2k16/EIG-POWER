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

        <!-- Row -->
        <div class="card-group">
            <!-- Column -->
            <div class="card mr-3">
                <div class="card-body text-center">
                    <h4 class="text-center text-info">HYDRO</h4>
                    <h2>966056</h2>
                    <div class="row p-t-10 p-b-10">
                        <!-- Column -->
                        <div class="col text-center align-self-center">
                            <div data-label="20%" class="css-bar m-b-0 css-bar-primary css-bar-20"><i class="display-6 text-info  mdi mdi-water"></i></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <h4 class="font-medium m-b-0"><span class="text-info">Public</span><br>12465</h4>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <h4 class="font-medium m-b-0"><span class="text-info">Private</span><br>145</h4>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="card mr-3">
                <div class="card-body text-center">
                    <h4 class="text-center text-success">RENEWABLE</h4>
                    <h2>288037</h2>
                    <div class="row p-t-10 p-b-10">
                        <!-- Column -->
                        <div class="col text-center align-self-center">
                            <div data-label="20%" class="css-bar m-b-0 css-bar-primary css-bar-20"><i class="display-6 text-success mdi mdi-tree"></i></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <h4 class="font-medium m-b-0"><span class="text-success">Solar</span><br>12465</h4>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <h4 class="font-medium m-b-0"><span class="text-success">Wind</span><br>12465</h4>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <h4 class="font-medium m-b-0"><span class="text-success">Bagasse</span><br>145</h4>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="card mr-3">
                <div class="card-body text-center">
                    <h4 class="text-center text-danger">NUCLEAR</h4>
                    <h2>965200</h2>
                    <div class="row p-t-10 p-b-10">
                        <!-- Column -->
                        <div class="col text-center align-self-center">
                            <div data-label="20%" class="css-bar m-b-0 css-bar-danger css-bar-20"><i class="display-6 text-danger mdi mdi-radioactive"></i></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <h4 class="font-medium m-b-0"><span class="text-danger">Nuclear</span><br>12465</h4>
                        </div>
                        <!-- <div class="col-md-6 col-sm-12">
                            <h4 class="font-medium m-b-0"><span class="text-danger">IPPs</span><br>145</h4>
                        </div> -->
                    </div>

                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="text-center text-warning">THERMAL</h4>
                    <h2>3826388</h2>
                    <div class="row p-t-10 p-b-10">
                        <!-- Column -->
                        <div class="col text-center align-self-center">
                            <div data-label="20%" class="css-bar m-b-0 css-bar-success css-bar-20"><i class="display-6 text-warning mdi mdi-fire"></i></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <h4 class="font-medium m-b-0"><span class="text-warning">Gencos</span><br>12465</h4>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <h4 class="font-medium m-b-0"><span class="text-warning">IPPs</span><br>145</h4>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Column -->
        </div>
        <?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "power";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// change column sizes for subcategories of NUCLEAR AND RENEWABLE major category
function getColumnClass($categoryName)
{
    if ($categoryName == "NUCLEAR") {
        return "col-md-12 col-sm-12";
    } elseif ($categoryName == "RENEWABLE") {
        return "col-md-4 col-sm-12";
    } else {
        return "col-md-6 col-sm-12";
    }
}
// generate cards of major category with their respective sub categories
function generateCategoryCardnew($categoryName, $numSubCategories, $subCategoryQueries, $iconClass, $SubCategoryNames)
{
    global $conn;
    $totalEnergy = 0;
    // Mapping of category names to their corresponding classes
    $categoryClasses = array(
        "HYDRO" => "text-info",
        "RENEWABLE" => "text-success",
        "NUCLEAR" => "text-danger",
        "THERMAL" => "text-warning"
    );
    for ($i = 0; $i < $numSubCategories; $i++) {
        $sql = $subCategoryQueries[$i];
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $subCategoryEnergy = $row["TotalEnergy"];
        $totalEnergy += (int) $subCategoryEnergy;
        
    }
    // if category is thermal, its mean its last card, so don't add margin to the right
    echo '<div class="card ' . ($categoryName != "THERMAL" ? 'mr-3' : '') . '">
        <div class="card-body text-center">
            <h4 class="text-center ' . $categoryClasses[$categoryName] . '">' . $categoryName . '</h4>
            <h2>' . $totalEnergy . '</h2>
        <div class="row p-t-10 p-b-10">
            <div class="col text-center align-self-center">
                <div data-label="20%" class="css-bar m-b-0 css-bar-primary css-bar-20"><i class="display-6 ' . $iconClass . '"></i></div>
            </div>
        </div>';


            echo '<div class="row">';
    for ($i = 0; $i < $numSubCategories; $i++) {
        $sql = $subCategoryQueries[$i];
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $subCategoryEnergy = (int) $row["TotalEnergy"];
        // $totalEnergy += $subCategoryEnergy;

        echo '
                <div class="' . getColumnClass($categoryName) . ' col-sm-12">
                    <h4 class="font-medium m-b-0"><span class="' . $categoryClasses[$categoryName] . '">' . $SubCategoryNames[$i] . '</span><br>' . $subCategoryEnergy . '</h4>
                </div>
            ';
    }

    echo '
    </div>
    </div>
</div>';
}

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

$conn->close();

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