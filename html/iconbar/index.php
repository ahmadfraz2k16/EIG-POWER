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


                <button type="submit">Apply Date Range</button>
            </form>
        </div>

        <!-- ============================================================== -->
        <div id="cardsContainer" class="card-group">
            <!-- Cards will be displayed here -->
        </div>
        <!-- high chart should be displayed here -->
        <div id="container7" style="width:100%; height:400px;"></div>
        <!-- <div id="container6" style="width:100%; height:400px;"></div> -->
        <!-- End Row -->
        <!-- high chart should be displayed here -->
        <div id="container_version_2" style="width:100%; height:400px;"></div>
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


<!-- stacked column bar chart container_version_2 -->
<script>
    <?php
    // Fetch data from your database and prepare it for use
    $connection = new mysqli("localhost", "root", "", "power");
    $startDate = "2022-03-02";
    $endDate = "2022-03-21";
    $query = "SELECT * FROM mw_new WHERE Time BETWEEN '$startDate' AND '$endDate'";

    $result = $connection->query($query);

    $chartData = array();



    while ($row = $result->fetch_assoc()) {
        $subCategory = $row['sub_categories_by_fuel'];
        $time = $row['Time'];
        $energy = floatval($row['Energy_MWh']);

        if (!isset($chartData[$subCategory])) {
            $chartData[$subCategory] = array();
        }

        if (!isset($chartData[$subCategory][$time])) {
            $chartData[$subCategory][$time] = 0;
        }

        $chartData[$subCategory][$time] += $energy;
    }

    // Convert $chartData to a JSON format for use in JavaScript
    $chartJSData = json_encode($chartData);
    // var_dump($chartJSData);
    ?>

    var chartData = <?php echo $chartJSData; ?>;
    var categories = Object.keys(chartData);
    var seriesData = [];

    for (var i = 0; i < categories.length; i++) {
        var category = categories[i];
        var categoryData = Object.values(chartData[category]);

        seriesData.push({
            name: category,
            data: categoryData
        });
    }

    Highcharts.chart('container_version_2', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Energy Distribution By Major Categories'
        },
        xAxis: {
            categories: Object.keys(chartData[categories[0]])
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Energy (MWh)'
            }
        },
        tooltip: {
            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b><br/>',
            shared: true
        },
        series: seriesData
    });
</script>




<?php
// echo formatedGraphData();
$startDate = '2022-03-05';
$endDate = '2022-03-5';
$jsonData = extractDataForGraph($startDate, $endDate);
$array = json_decode($jsonData, true);

$extractedDates = extractDates($array);

?>

<!-- Add Highcharts configuration in JavaScript -->
<script>
    Highcharts.chart('container7', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Energy Distribution By Major Categories',
            align: 'left'
        },
        xAxis: {
            categories: <?php echo $extractedDates; ?>
        },
        yAxis: {
            min: 0,
            title: {
                text: 'GENERATION MWh'
            },
            stackLabels: {
                enabled: true
            }
        },
        legend: {
            align: 'left',
            x: 70,
            verticalAlign: 'top',
            y: 70,
            floating: true,
            backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },
        tooltip: {
            headerFormat: '<b>{point.x}</b><br/>',
            pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}<br/>Sub categories:<br/>{point.subCategories}'
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true
                }
            }
        },
        colors: ['#7091F5', '#5C8374', '#9A3B3B', '#F0B86E'], // Use the custom colors for major categories
        series: <?php
                // Generate series for each major category
                echo formatedGraphData($array);
                ?>

    });
</script>


<script>
    Highcharts.chart('container6', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Energy Distribution By Major Categories',
            align: 'left'
        },
        xAxis: {
            categories: ['2022-03-02 00:00:00', '2022-03-02 01:00:00', '2022-03-02 02:00:00', '2022-03-02 03:00:00']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'GENERATION MWh'
            },
            stackLabels: {
                enabled: true
            }
        },
        legend: {
            align: 'left',
            x: 70,
            verticalAlign: 'top',
            y: 70,
            floating: true,
            backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },
        tooltip: {
            headerFormat: '<b>{point.x}</b><br/>',
            pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}<br/>Sub categories:<br/>{point.subCategories}'
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true
                }
            }
        },
        colors: ['#7091F5', '#5C8374', '#9A3B3B', '#F0B86E'], //custom color hash for main categories
        series: [{
            name: 'HYDEL',
            data: [{
                y: 3,
                color: '#91C8E4', //custom color hash for sub category
                subCategories: 'PRIVATE (1.5), PUBLIC (1.5)' //dummy values for sub category
            }, {
                y: 5,
                color: '#91C8E4',
                subCategories: 'PRIVATE (2.5), PUBLIC (2.5)'
            }, {
                y: 3,
                color: '#91C8E4',
                subCategories: 'PRIVATE (1.5), PUBLIC (1.5)'
            }, {
                y: 13,
                color: '#91C8E4',
                subCategories: 'PRIVATE (6.5), PUBLIC (6.5)'
            }]
        }, {
            name: 'RENEWABLE',
            data: [{
                y: 14,
                color: '#A8DF8E',
                subCategories: 'SOLAR (4.7), WIND (4.7), BAGASSE (4.6)'
            }, {
                y: 8,
                color: '#A8DF8E',
                subCategories: 'SOLAR (2.7), WIND (2.7), BAGASSE (2.6)'
            }, {
                y: 8,
                color: '#A8DF8E',
                subCategories: 'SOLAR (2.7), WIND (2.7), BAGASSE (2.6)'
            }, {
                y: 12,
                color: '#A8DF8E',
                subCategories: 'SOLAR (4), WIND (4), BAGASSE (4)'
            }]
        }, {
            name: 'NUCLEAR',
            data: [{
                y: 14,
                color: '#FF6969',
                subCategories: 'NUCLEAR (14)'
            }, {
                y: 8,
                color: '#FF6969',
                subCategories: 'NUCLEAR (8)'
            }, {
                y: 8,
                color: '#FF6969',
                subCategories: 'NUCLEAR (8)'
            }, {
                y: 12,
                color: '#FF6969',
                subCategories: 'NUCLEAR (12)'
            }]
        }, {
            name: 'THERMAL',
            data: [{
                y: 4,
                color: '#F0B86E',
                subCategories: 'GENCOS (2), IPPS (2)'
            }, {
                y: 2,
                color: '#F0B86E',
                subCategories: 'GENCOS (1), IPPS (1)'
            }, {
                y: 6,
                color: '#F0B86E',
                subCategories: 'GENCOS (3), IPPS (3)'
            }, {
                y: 3,
                color: '#F0B86E',
                subCategories: 'GENCOS (1.5), IPPS (1.5)'
            }]
        }]
    });
</script>
<!-- <script>
    Highcharts.chart('container6', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Energy Distribution By Major Categories',
            align: 'left'
        },
        xAxis: {
            categories: ['2022-03-02', '2022-03-03', '2022-03-04', '2022-03-05']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'GENERATION MWh'
            },
            stackLabels: {
                enabled: true
            }
        },
        legend: {
            align: 'left',
            x: 70,
            verticalAlign: 'top',
            y: 70,
            floating: true,
            backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },
        tooltip: {
            headerFormat: '<b>{point.x}</b><br/>',
            pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}<br/>Sub categories:<br/>{point.subCategories}'
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true
                }
            }
        },
        series: [{
            name: 'HYDRO',
            data: [{
                y: 3,
                subCategories: 'Private, Public'
            }, {
                y: 5,
                subCategories: 'Private, Public'
            }, {
                y: 3,
                subCategories: 'Private, Public'
            }, {
                y: 13,
                subCategories: 'Private, Public'
            }]
        }, {
            name: 'RENEWABLE',
            data: [{
                y: 14,
                subCategories: 'Solar, Wind, Bagasse'
            }, {
                y: 8,
                subCategories: 'Solar, Wind, Bagasse'
            }, {
                y: 8,
                subCategories: 'Solar, Wind, Bagasse'
            }, {
                y: 12,
                subCategories: 'Solar, Wind, Bagasse'
            }]
        }, {
            name: 'NUCLEAR',
            data: [{
                y: 14,
                subCategories: 'Nuclear'
            }, {
                y: 8,
                subCategories: 'Nuclear'
            }, {
                y: 8,
                subCategories: 'Nuclear'
            }, {
                y: 12,
                subCategories: 'Nuclear'
            }]
        }, {
            name: 'THERMAL',
            data: [{
                y: 4,
                subCategories: 'Gencos, IPPS'
            }, {
                y: 2,
                subCategories: 'Gencos, IPPS'
            }, {
                y: 6,
                subCategories: 'Gencos, IPPS'
            }, {
                y: 3,
                subCategories: 'Gencos, IPPS'
            }]
        }]
    });
</script> -->


<!-- <script>
    Highcharts.chart('container_version_2', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Energy Distribution By Major Categories container_version_2'
        },
        xAxis: {
            categories: ['2021/22', '2020/21', '2019/20', '2018/19', '2017/18']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Assists'
            }
        },
        tooltip: {
            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
            shared: true
        },
        plotOptions: {
            column: {
                stacking: 'percent'
            }
        },
        series: [{
            name: 'HYDRO',
            data: [4, 4, 2, 4, 4],
            color: '#7bc4df'
        }, {
            name: 'RENEWABLE',
            data: [1, 4, 3, 2, 3],
            color: '#bcff4f'
        }, {
            name: 'NUCLEAR',
            data: [1, 2, 2, 1, 2],
            color: '#f6764d'
        }, {
            name: 'THERMAL',
            data: [1, 2, 2, 1, 2],
            color: '#ffd433'
        }]
    });
</script> -->
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

        // Make an initial AJAX request to load default cards
        updateCardsWithDateRange(startDateInput.value, endDateInput.value);

        function updateCardsWithDateRange(startDate, endDate) {
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
        }
    });
</script>


</body>

</html>