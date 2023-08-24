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
        <div class="row">
            <!-- Column -->
            <div class="col-sm-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-row">
                            <div class="round align-self-center round-info"><i class="display-7  mdi mdi-water"></i></div>
                            <div class="m-l-10 align-self-center">
                                <h4 class="m-b-0">Hydro</h4>
                                <span class="text-muted">Income</span>
                            </div>
                            <div class="ml-auto align-self-center">
                                <h2 class="font-medium m-b-0">MWh 926056</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-sm-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-row">
                            <div class="round align-self-center round-success"><i class="display-7 mdi mdi-tree"></i></div>
                            <div class="m-l-10 align-self-center">
                                <h4 class="m-b-0">Renewable</h4>
                                <span class="text-muted">Users</span>
                            </div>
                            <div class="ml-auto align-self-center">
                                <h2 class="font-medium m-b-0">MWh 288037</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-sm-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-row">
                            <div class="round align-self-center round-danger"><i class="display-7 mdi mdi-radioactive"></i></div>
                            <div class="m-l-10 align-self-center">
                                <h4 class="m-b-0">Nuclear</h4>
                                <span class="text-muted">My birthday</span>
                            </div>
                            <div class="ml-auto align-self-center">
                                <h2 class="font-medium m-b-0">MWh 965200</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-sm-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-row">
                            <div class="round align-self-center round-warning"><i class="display-7 mdi mdi-fire"></i></div>
                            <div class="m-l-10 align-self-center">
                                <h4 class="m-b-0">Thermal</h4>
                                <span class="text-muted">pending</span>
                            </div>
                            <div class="ml-auto align-self-center">
                                <h2 class="font-medium m-b-0">MWh 3826388</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>
        <!-- Row -->
        <!-- Row -->
        <div class="card-group">
            <!-- Column -->
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="text-center text-info">HYDRO</h4>
                    <h2>966056</h2>
                    <div class="row p-t-10 p-b-10">
                        <!-- Column -->
                        <div class="col text-center align-self-center">
                            <div data-label="20%" class="css-bar m-b-0 css-bar-primary css-bar-20"><i class="display-6 text-primary  mdi mdi-water"></i></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <h4 class="font-medium m-b-0"><span class="text-success">Public</span><br>12465</h4>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <h4 class="font-medium m-b-0"><span class="text-danger">Private</span><br>145</h4>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="card">
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
                            <h4 class="font-medium m-b-0"><span class="text-danger">Wind</span><br>12465</h4>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <h4 class="font-medium m-b-0"><span class="text-success">Bagasse</span><br>145</h4>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="card">
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
                        <div class="col-md-6 col-sm-12">
                            <h4 class="font-medium m-b-0"><span class="text-success">Gencos</span><br>12465</h4>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <h4 class="font-medium m-b-0"><span class="text-danger">IPPs</span><br>145</h4>
                        </div>
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
                            <h4 class="font-medium m-b-0"><span class="text-success">Increase</span><br>12465</h4>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <h4 class="font-medium m-b-0"><span class="text-danger">Decrease</span><br>145</h4>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Column -->
        </div>
        <!-- End Row -->
        <!-- ============================================================== -->
        <!-- Sales chart -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Email campaign chart -->
        <!-- ============================================================== -->

















        <!-- ============================================================== -->
        <!-- Email campaign chart -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Recent comment and chats -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Recent comment and chats -->
        <!-- ============================================================== -->
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