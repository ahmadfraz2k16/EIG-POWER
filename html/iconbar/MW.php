<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'C:/xampp/htdocs/latest_Dash/backend/functions.php'; ?>
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
        <!-- Sales chart -->
        <!-- ============================================================== -->
        <div class="card-group">
            <?php
            // include 'C:/xampp/htdocs/latest_Dash/backend/functions.php';

            $categoryData = getCategorySumData();
            $maxEnergy = 0;

            foreach ($categoryData as $row) {
                $maxEnergy = max($maxEnergy, $row['total_energy']);
            }

            $categoriesPerRow = 5; // Number of categories in each row
            $rowCount = 0; // Counter for the current row

            foreach ($categoryData as $row) {
                $category = $row["category"];
                $totalEnergy = $row["total_energy"];
            ?>

                <?php if ($rowCount % $categoriesPerRow === 0) : ?>
        </div>
        <div class="card-group"> <!-- Close the previous row and start a new row -->
        <?php endif; ?>

        <div class="card mr-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="d-flex no-block align-items-center ">
                            <div>
                                <span> <i class="fas fa-bolt font-20 " style="color: yellow;"></i></span>
                                <p class="font-16 m-b-5 lead"><?php echo $category; ?></p>
                                <h3 class="font-light text-right"><?php echo $totalEnergy; ?></h3>
                            </div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo ($totalEnergy / $maxEnergy) * 100; ?>%; height: 6px;" aria-valuenow="<?php echo $totalEnergy; ?>" aria-valuemin="0" aria-valuemax="<?php echo $maxEnergy; ?>"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    <?php
                $rowCount++;
            } ?>
        </div>
        <!-- ============================================================== -->
        <!-- Sales chart -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Email campaign chart -->
        <!-- ============================================================== -->


        <!-- Start spline chart -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Spline Chart test</h4>
                        <div id="spline-chart"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End spline chart -->

        <!-- table start -->



        <?php
        $fromDate = isset($_GET['from_date']) ? $_GET['from_date'] : null;
        $toDate = isset($_GET['to_date']) ? $_GET['to_date'] : null;
        $searchTerm = isset($_GET['search']) ? $_GET['search'] : null;

        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $perPage = 7;

        // Fetch data based on filters
        $powerData = fetchPowerData($page, $perPage, $fromDate, $toDate, $searchTerm);
        // $powerDataDownloadPurpose = fetchPowerDataDownloadPurpose($page, $fromDate, $toDate, $searchTerm);

        // Count total rows for pagination
        $conn = getDatabaseConnection();

        // Modify this query to get min and max dates
        $dateRangeQuery = "SELECT MIN(Time) as minDate, MAX(Time) as maxDate FROM mw";
        $dateRangeResult = $conn->query($dateRangeQuery);
        $dateRange = $dateRangeResult->fetch_assoc();
        $minDate = $dateRange['minDate'];
        $maxDate = $dateRange['maxDate'];

        $totalRowsQuery = "SELECT COUNT(*) as total FROM mw";

        // Apply filters to total rows query
        if (!empty($fromDate)) {
            $totalRowsQuery .= " WHERE Time >= '{$fromDate}'";
        }

        if (!empty($toDate)) {
            $totalRowsQuery .= ($fromDate ? " AND" : " WHERE") . " Time <= '{$toDate}'";
        }

        if (!empty($searchTerm)) {
            $totalRowsQuery .= ($fromDate || $toDate ? " AND" : " WHERE") . " Name LIKE '%{$searchTerm}%'";
        }

        $totalRowsResult = $conn->query($totalRowsQuery);
        $totalRows = $totalRowsResult->fetch_assoc()['total'];
        $totalPages = ceil($totalRows / $perPage);

        $conn->close();
        ?>
        <!-- table filter start -->
        <!-- Filter and Search forms -->
        <div class="row mb-3">
            <div class="col-lg-6">
                <form class="form-inline">
                    <!-- Filter form for date range -->
                    <label class="mr-2">From Date:</label>
                    <input class="form-control mr-sm-2" type="date" name="from_date" value="<?php echo $_GET['from_date'] ?? $minDate; ?>" min="<?php echo $minDate; ?>" max="<?php echo $maxDate; ?>">
                    <label class="mr-2">To Date:</label>
                    <input class="form-control mr-sm-2" type="date" name="to_date" value="<?php echo $_GET['to_date'] ?? $maxDate; ?>" min="<?php echo $minDate; ?>" max="<?php echo $maxDate; ?>">
                    <button class="btn btn-secondary" type="submit">Apply</button>
                </form>

            </div>
            <div class="col-lg-6">
                <form class="form-inline float-lg-right">
                    <input class="form-control mr-sm-2" type="text" placeholder="Search Powerplant Name" name="search" value="<?php echo $_GET['search'] ?? ''; ?>">
                    <button class="btn btn-secondary" type="submit">Search</button>
                </form>
            </div>
        </div>
        <!-- table filter ends -->
        <!-- download options start -->
        <div class="row">
            <div class="col-md-12 ">
                <div class="text-right">
                    <button id="csvBtn" class="btn btn-secondary">Download as CSV</button>
                    <button id="txtBtn" class="btn btn-secondary">Download as Text</button>
                    <button id="excelBtn" class="btn btn-secondary">Download as Excel</button>
                </div>
            </div>
        </div>

        <!-- download optionsends -->
        <!-- table to show records -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <!-- Row -->
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-warning text-white">
                                    <tr>
                                        <th>#</th>
                                        <th>Date Y-M-D Time H:M:S</th>
                                        <th>Powerplant Name</th>
                                        <th>Category</th>
                                        <th>Generation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = ($page - 1) * $perPage + 1;
                                    foreach ($powerData as $row) {
                                        echo '<tr>';
                                        echo '<td>' . $count . '</td>';
                                        echo '<td>' . $row['Time'] . '</td>';
                                        echo '<td>' . $row['Name'] . '</td>';
                                        echo '<td>' . $row['category'] . '</td>';
                                        echo '<td>' . $row['Energy_MWh'] . '</td>';
                                        echo '</tr>';
                                        $count++;
                                    }

                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Pagination links -->
                <!-- Pagination links -->
                <div class="row">
                    <div class="col-lg-12">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <?php
                                // Display "Previous" link
                                if ($page > 1) {
                                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '">Previous</a></li>';
                                }

                                // Display first three page numbers
                                for ($i = 1; $i <= min(3, $totalPages); $i++) {
                                    echo '<li class="page-item' . ($page == $i ? ' active' : '') . '">';
                                    echo '<a class="page-link" href="?page=' . $i . '">' . $i . '</a>';
                                    echo '</li>';
                                }

                                // Display ellipsis if there are more pages in between
                                if ($page - 2 > 3) {
                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                }

                                // Display intermediate page numbers
                                for ($i = max($page - 1, 4); $i <= min($page + 1, $totalPages - 3); $i++) {
                                    echo '<li class="page-item' . ($page == $i ? ' active' : '') . '">';
                                    echo '<a class="page-link" href="?page=' . $i . '">' . $i . '</a>';
                                    echo '</li>';
                                }

                                // Display ellipsis if there are more pages in between
                                if ($totalPages - ($page + 1) > 2) {
                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                }

                                // Display last three page numbers, ensuring they're always visible
                                for ($i = max($totalPages - 2, $totalPages - 5); $i <= $totalPages; $i++) {
                                    echo '<li class="page-item' . ($page == $i ? ' active' : '') . '">';
                                    echo '<a class="page-link" href="?page=' . $i . '">' . $i . '</a>';
                                    echo '</li>';
                                }

                                // Display "Next" link
                                if ($page < $totalPages) {
                                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '">Next</a></li>';
                                }
                                ?>
                            </ul>
                            <div class="mt-2">
                                <form class="form-inline">
                                    <input class="form-control mr-sm-2" type="text" placeholder="Go to page" name="page">
                                    <button class="btn btn-primary" type="submit">Go</button>
                                </form>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>







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

<!-- Spline chart -->
<script type="text/javascript">
    $(function() {
        // Fetch data using PHP function
        <?php
        $perDayProductionData = getPerDayProductionData();
        $categories = array_keys($perDayProductionData);
        $dataColumns = array();

        // Define color patterns for each category
        $colorPatterns = ["#2962FF", "#4fc3f7", "#FF9800", "#FF5722", "#8BC34A", "#E91E63", "#9C27B0", "#607D8B"];

        $colorIndex = 0; // To cycle through the color patterns

        foreach ($perDayProductionData as $category => $data) {
            $dataColumn = array($category);
            foreach ($data as $day => $totalEnergy) {
                $dataColumn[] = $totalEnergy;
            }
            $dataColumns[] = $dataColumn;
            $colorIndex = ($colorIndex + 1) % count($colorPatterns);
        }
        ?>

        var n = c3.generate({
            bindto: "#spline-chart",
            size: {
                height: 400
            },
            point: {
                r: 4
            },
            color: {
                pattern: <?php echo json_encode($colorPatterns); ?>
            },
            data: {
                columns: <?php echo json_encode($dataColumns); ?>,
                type: "spline"
            },
            axis: {
                x: {
                    type: "category"
                }
            },
            grid: {
                y: {
                    show: true
                }
            }
        });
    });
</script>

<!-- download buttons -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('csvBtn').addEventListener('click', function() {
            downloadData('csv');
        });

        document.getElementById('txtBtn').addEventListener('click', function() {
            downloadData('txt');
        });

        document.getElementById('excelBtn').addEventListener('click', function() {
            downloadData('excel');
        });

        function generateCSVData(data) {
            var csv = 'Date,Powerplant Name,Category,Generation\n';
            data.forEach(function(row) {
                csv += row.Time + ',' + row.Name + ',' + row.category + ',' + row.Energy_MWh + '\n';
            });
            return csv;
        }

        function generateTXTData(data) {
            var txt = '';
            data.forEach(function(row) {
                txt += 'Date: ' + row.Time + '\n';
                txt += 'Powerplant Name: ' + row.Name + '\n';
                txt += 'Category: ' + row.category + '\n';
                txt += 'Generation: ' + row.Energy_MWh + '\n\n';
            });
            return txt;
        }

        function generateExcelData(data) {
            var xlsxData = [
                ['Date', 'Powerplant Name', 'Category', 'Generation']
            ];

            data.forEach(function(row) {
                xlsxData.push([row.Time, row.Name, row.category, row.Energy_MWh]);
            });

            var worksheet = XLSX.utils.aoa_to_sheet(xlsxData);
            var workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, 'Sheet1');

            var blob = new Blob([s2ab(XLSX.write(workbook, {
                bookType: 'xlsx',
                type: 'blob'
            }))], {
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            });

            return blob;
        }

        // Convert string to ArrayBuffer
        function s2ab(s) {
            var buf = new ArrayBuffer(s.length);
            var view = new Uint8Array(buf);
            for (var i = 0; i < s.length; i++) {
                view[i] = s.charCodeAt(i) & 0xFF;
            }
            return buf;
        }


        function downloadData(format) {
            var powerData = <?php echo json_encode($powerData); ?>;
            console.log(powerData)
            var data = '';

            switch (format) {
                case 'csv':
                    data = generateCSVData(powerData);
                    break;
                case 'txt':
                    data = generateTXTData(powerData);
                    break;
                case 'excel':
                    data = generateExcelData(powerData);
                    break;
                default:
                    console.error('Unsupported format: ' + format);
                    return;
            }

            var blob = new Blob([data], {
                type: 'text/plain;charset=utf-8'
            });
            var filename = 'data.' + format;

            saveAs(blob, filename);
        }

    });
</script>

<!-- <script src="../../dist/js/pages/c3-chart/line/c3-spline.js"></script> -->
</body>

</html>