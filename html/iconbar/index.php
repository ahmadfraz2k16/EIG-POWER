<?php
// Read the CSV file
$file = fopen('C:/xampp/htdocs/latest_Dash/html/iconbar/include/csv/peakhours.csv', 'r');

// Initialize arrays to store unique dates and names
$dates = [];
$names = [];
$records = []; // Store all records

// Skip the header row
fgetcsv($file);

while (($row = fgetcsv($file)) !== false) {
    $date = date('Y-m-d', strtotime($row[3]));
    $name = $row[0];

    // Add the date to the dates array if it's not already present
    if (!in_array($date, $dates)) {
        $dates[] = $date;
    }

    // Add the name to the names array for the corresponding date
    if (!isset($names[$date])) {
        $names[$date] = [];
    }

    // Add the name to the names array if it's not already present
    if (!in_array($name, $names[$date])) {
        $names[$date][] = $name;
    }

    // Store the record
    $records[$date][$name][] = $row;
}

// Close the CSV file
fclose($file);


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
        <!-- Create a dropdown menu to select a date -->
        <!-- <label for="dateSelector">Select a Date:</label>
        <select id="dateSelector"></select> -->
        <form method="post" action="">
            <select name="selected_date" onchange="this.form.submit()">
                <?php
                // Call the getUniqueDates function to retrieve dates
                $dates = getUniqueDates();

                // Decode the JSON response
                $dates = json_decode($dates);

                // Loop through the dates and populate the dropdown options
                foreach ($dates as $date) {
                    echo "<option value=\"$date\">$date</option>";
                }
                ?>
            </select>
        </form>
        <!-- high chart should be displayed here -->
        <div id="container7" style="width:100%; height:400px;"></div>
        <!-- <div id="container6" style="width:100%; height:400px;"></div> -->
        <!-- End Row -->
        <!-- high chart should be displayed here -->
        <!-- <div id="container_version_2" style="width:100%; height:400px;"></div> -->
        <!-- End Row -->



        <!-- <figure class="highcharts-figure">
            <div id="container"></div>
        </figure> -->




    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <h3 style="font-size: 1.2em; color: rgb(51, 51, 51); font-weight: bold; fill: rgb(51, 51, 51);">Peak Contribution By Individual Powerplant</h3>

        <!-- Row -->
        <label for="dateSelect">Select Date:</label>
        <select id="dateSelect">
            <option value="">Select a Date</option>
            <?php foreach ($dates as $date) : ?>
                <option value="<?php echo $date; ?>"><?php echo $date; ?></option>
            <?php endforeach; ?>
        </select>

        <label for="nameSelect">Select Name:</label>
        <select id="nameSelect" disabled>
            <option value="">Select a Name</option>
        </select>
        <div id="cardContainer" class="row justify-content-between">
            <!-- Cards will be dynamically generated here -->
        </div>
        <div id="containerLineGraph">
            <h4>Line Graph Will Be Here</h4>
            <!-- Line Graph will be dynamically generated here -->
        </div>
        <!-- Row -->
    </div>

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
<!-- <script>
    // Create the chart
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            align: 'left',
            text: 'Power Plants generation shares. March, 2022'
        },
        subtitle: {
            align: 'left',
            text: 'Generation w.r.t Categories and Sub-categories'
        },
        accessibility: {
            announceNewData: {
                enabled: true
            }
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Total percent generation share'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}%'
                },
                drilldown: {
                    enabled: true // Enable drilldown interactions
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
        },
        series: [{
            name: 'POWER PLANTS',
            colorByPoint: true,
            data: [{
                    name: 'HYDRO',
                    y: 63.06,
                    color: '#137eff', // Custom color for HYDRO
                    drilldown: 'HYDRO'
                },
                {
                    name: 'RENEWABLE',
                    y: 19.84,
                    color: '#5ac146', // Custom color for RENEWABLE
                    drilldown: 'RENEWABLE'
                },
                {
                    name: 'NUCLEAR',
                    y: 4.18,
                    color: '#fa5838', // Custom color for NUCLEAR
                    drilldown: null
                },
                {
                    name: 'THERMAL',
                    y: 4.12,
                    color: '#ffbc34', // Custom color for THERMAL
                    drilldown: 'THERMAL'
                }
            ]
        }],
        drilldown: {
            breadcrumbs: {
                position: {
                    align: 'right'
                }
            },
            series: [{
                    name: 'HYDRO',
                    id: 'HYDRO',
                    data: [
                        ['PRIVATE', 30.0],
                        ['PUBLIC', 33.06]
                    ]
                },
                {
                    name: 'RENEWABLE',
                    id: 'RENEWABLE',
                    data: [
                        ['SOLAR', 10.0],
                        ['WIND', 5.0],
                        ['BAGASSE', 4.84]
                    ]
                },
                {
                    name: 'NUCLEAR',
                    id: 'NUCLEAR',
                    data: [
                        // Add data for NUCLEAR subcategories
                    ]
                },
                {
                    name: 'THERMAL',
                    id: 'THERMAL',
                    data: [{
                        name: 'IPPS',
                        y: 2.0,
                        drilldown: 'IPPS'
                    }, {
                        name: 'GENCOS',
                        y: 2.12,
                        drilldown: 'GENCOS'
                    }]
                },
                {
                    name: 'IPPS',
                    id: 'IPPS',
                    data: [
                        ['IPPs Gas', 0.6],
                        ['IPPs Coal', 0.8],
                        ['IPPs FO', 0.1],
                        ['IPPs RLNG', 0.62]
                    ]
                },
                {
                    name: 'GENCOS',
                    id: 'GENCOS',
                    data: [
                        ['Gencos Gas', 1.0],
                        ['Gencos Coal', 0.5],
                        ['Gencos RLNG', 0.5]
                    ]
                }
            ]
        }
    });
</script> -->

<!-- <script>
    // Create the chart
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },

        plotOptions: {
            series: {
                stacking: 'normal'
            }
        },

        series: [{
                data: [{
                        name: "HYDRO",
                        y: 62.74,
                        drilldown: "HYDRO"
                    },
                    {
                        name: "HYDRO",
                        y: 10.57,
                        drilldown: "HYDRO"
                    }
                ]
            },
            {
                data: [{
                        name: "RENEWABLE",
                        y: 15,
                        drilldown: "RENEWABLE"
                    },
                    {
                        name: "RENEWABLE",
                        y: 23,
                        drilldown: "RENEWABLE"
                    }
                ]
            },
            {
                data: [{
                        name: "NUCLEAR",
                        y: 15,
                        drilldown: "NUCLEAR"
                    },
                    {
                        name: "NUCLEAR",
                        y: 23,
                        drilldown: "NUCLEAR"
                    }
                ]
            },
            {
                data: [{
                        name: "THERMAL",
                        y: 15,
                        drilldown: "THERMAL"
                    },
                    {
                        name: "THERMAL",
                        y: 23,
                        drilldown: "THERMAL"
                    }
                ]
            }
        ],
        drilldown: {
            series: [{
                id: "HYDRO",
                data: [
                    [
                        "PRIVATE",
                        0.1
                    ],
                    [
                        "PUBLIC",
                        1.3
                    ]
                ]
            }, 
            {
                id: "RENEWABLE",
                data: [
                    [
                        "SOLAR",
                        23
                    ],
                    [
                        "WIND",
                        12
                    ],
                    [
                        "BAGASSE",
                        5
                    ]
                ]
            },
            {
                id: "THERMAL",
                data: [
                    [
                        "GENCOS",
                        23
                    ],
                    [
                        "IPPS",
                        12
                    ]
                ]
            }, 
        ]
        }
    });
</script> -->

<script>
    // Define initial categories (dates) for the x-axis
    var initialCategories = ['2022-03-02'];

    // Create the chart
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        xAxis: {
            type: 'datetime',
            categories: initialCategories
        },
        plotOptions: {
            series: {
                stacking: 'normal'
            }
        },

        series: [{
                name: "HYDRO",
                color: '#89CFF0',
                data: [{
                    name: "HYDRO",
                    y: 62.74,
                    color: '#89CFF0', // Custom color for HYDRO
                    drilldown: "HYDRO"
                }]
            },
            {
                name: "RENEWABLE",
                color: '#90EE90',
                data: [{
                    name: "RENEWABLE",
                    y: 15,
                    color: '#90EE90', // Custom color for RENEWABLE
                    drilldown: "RENEWABLE"
                }]
            },
            {
                name: "NUCLEAR",
                color: '#F88379',
                data: [{
                    name: "NUCLEAR",
                    y: 15,
                    color: '#F88379', // Custom color for NUCLEAR
                    drilldown: null
                }]
            },
            {
                name: "THERMAL",
                color: '#ffbc34',
                data: [{
                    name: "THERMAL",
                    y: 15,
                    color: '#ffbc34', // Custom color for THERMAL
                    drilldown: "THERMAL"
                }]
            }
        ],
        drilldown: {
            series: [{
                    name: "HYDRO",
                    id: "HYDRO",
                    data: [
                        [
                            "PRIVATE",
                            0.1
                        ],
                        [
                            "PUBLIC",
                            1.3
                        ]
                    ]
                },
                {
                    name: "RENEWABLE",
                    id: "RENEWABLE",
                    data: [
                        [
                            "SOLAR",
                            23
                        ],
                        [
                            "WIND",
                            12
                        ],
                        [
                            "BAGASSE",
                            5
                        ]
                    ]
                },
                {
                    name: "THERMAL",
                    id: "THERMAL",
                    data: [{
                            name: "GENCOS",
                            y: 23,
                            drilldown: "GENCOS"
                        },
                        {
                            name: "IPPS",
                            y: 12,
                            drilldown: "IPPS"
                        }
                    ]
                },
                {
                    id: "GENCOS",
                    data: [
                        ['Gencos Gas', 1.0],
                        ['Gencos Coal', 0.5],
                        ['Gencos RLNG', 0.5]
                    ]
                },
                {
                    id: "IPPS",
                    data: [
                        ['IPPs Gas', 0.6],
                        ['IPPs Coal', 0.8],
                        ['IPPs FO', 0.1],
                        ['IPPs RLNG', 0.62]
                    ]
                }
            ]
        }
    });
</script>








<script>
    // Parse the JSON string containing dates
    var datesJson = '<?= getUniqueDates() ?>';
    var datesArray = JSON.parse(datesJson);

    // Get the select element
    var dateSelector = document.getElementById('dateSelector');

    // Loop through the dates and add options to the select element
    for (var i = 0; i < datesArray.length; i++) {
        var date = datesArray[i];
        var option = document.createElement('option');
        option.value = date;
        option.text = date;
        dateSelector.appendChild(option);
    }
</script>
<!-- stacked column bar chart container_version_2 -->
<script>
    <?php
    // Fetch data from your database and prepare it for use
    $connection = new mysqli("localhost", "root", "", "power");
    $startDateee = "2022-03-02";
    $endDateee = "2022-03-21";
    $query = "SELECT * FROM mw_new WHERE Time BETWEEN '$startDateee' AND '$endDateee'";

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
// Check if a date is selected, and display the corresponding data
if (isset($_POST['selected_date'])) {
    $startDatee = $_POST['selected_date'];
    $endDatee = $_POST['selected_date'];
    $jsonData = extractDataForGraph($startDatee, $endDatee);
    $array = json_decode($jsonData, true);

    $extractedDates = extractDates($array);
} else {
    $startDatee = '2022-03-02';
    $endDatee = '2022-03-2';
    $jsonData = extractDataForGraph($startDatee, $endDatee);
    $array = json_decode($jsonData, true);

    $extractedDates = extractDates($array);
}


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

<!-- JavaScript code to display records in cards -->
<script>
    //line graph function with ajax functionality
    function updateChart(the_Date, the_Name) {
        var selectedDate = the_Date;
        var selectedName = the_Name;

        // Make an AJAX request to fetch updated data
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var combinedData = JSON.parse(xhr.responseText);

                function convertDateFormat(originalDate) {
                    // Parse the original date string into a Date object
                    const dateParts = originalDate.split('/');
                    const day = parseInt(dateParts[1], 10);
                    const month = parseInt(dateParts[0], 10) - 1; // JavaScript months are 0-based
                    const year = parseInt(dateParts[2], 10);

                    // Create a Date object
                    const dateObject = new Date(year, month, day);

                    // Format the date components in "mm/dd/yyyy" format
                    const formattedDate = `${dateObject.getMonth() + 1}-${dateObject.getDate()}-${dateObject.getFullYear()}`;

                    return formattedDate;
                }
                var peakHoursTimes = JSON.parse(combinedData.peak_hours);
                var final_Xaxis_Times = JSON.parse(combinedData.final_Xaxis);
                // Get the target date in the 'YYYY-MM-DD' format
                const targetDateFormatted = convertDateFormat(combinedData.Date);
                // Get the powerplant name
                const PowerPlant_Name = combinedData.PowerPlant_Name;

                // Create an array to hold the zones
                var zones = [];

                // Find the start and end times for the red zone
                var start = peakHoursTimes[0];
                var end = peakHoursTimes[peakHoursTimes.length - 1];

                // Find the corresponding indices in the final_Xaxis_Times array
                var startIndex = final_Xaxis_Times.indexOf(start);
                var endIndex = final_Xaxis_Times.indexOf(end);

                // Create the zones array with colorIndex for consistent colors
                zones.push({
                    fillColor: 'none', // Disable default fill color
                    lineColor: 'none', // Disable default line color
                });
                zones.push({
                    color: 'rgba(255, 182, 193, 0.8)', // Light red color with 50% opacity
                    value: startIndex, // Start from the first peak hour
                    dashStyle: 'Dash', // Dashed style
                });
                zones.push({
                    fillColor: 'rgba(255, 182, 193, 0.8)',
                    color: 'rgba(255, 182, 193, 0.8)', // Light red color with 50% opacity
                    value: endIndex, // End at the last peak hour
                    dashStyle: 'Dash', // Dashed style
                });
                zones.push({
                    value: final_Xaxis_Times.indexOf('23:00'), // End at 23:00
                    fillColor: 'none', // Disable default fill color
                    lineColor: 'none', // Disable default line color

                });

                // Create a Highcharts chart using the data
                Highcharts.chart('containerLineGraph', {
                    chart: {
                        type: 'areaspline',
                    },
                    // time: {
                    //     timezoneOffset: -5 * 60,
                    // },
                    title: {
                        text: 'Peak Contribution in Demand on ' + targetDateFormatted,
                        align: 'left',
                    },
                    xAxis: {
                        type: 'category', // Use category type for discrete time values
                        categories: final_Xaxis_Times, // Use final_Xaxis_Times for x-axis categories
                        title: {
                            text: targetDateFormatted,
                        }
                    },
                    yAxis: {
                        title: {
                            text: 'Energy Production (Megawatt)',
                        },
                    },
                    tooltip: {
                        headerFormat: '<b>Time: {point.x:%H:%M}</b><br>',
                        pointFormat: 'Energy Production: {point.y} MW',
                    },
                    plotOptions: {
                        areaspline: {
                            fillOpacity: 0.8,
                            lineWidth: 2,
                            // lineColor: 'rgba(95, 141, 237, 0.8)',
                            fillColor: 'none', // Disable default fill color
                        },
                    },
                    series: [{
                        name: PowerPlant_Name,
                        type: 'areaspline',
                        data: combinedData['Combined_Data'],
                        zoneAxis: 'x', // Set the zoneAxis to 'x'
                        zones: zones,
                    }, ],
                })
            }
        };

        // Define the PHP endpoint that handles the request and passes the selectedDate and selectedName
        var phpEndpoint = 'update_chart.php';
        var params = 'date=' + encodeURIComponent(selectedDate) + '&name=' + encodeURIComponent(selectedName);

        // Send the request
        xhr.open('GET', phpEndpoint + '?' + params, true);
        xhr.send();
    }
    // Get references to the dropdowns and card container
    var dateSelect = document.getElementById('dateSelect');
    var nameSelect = document.getElementById('nameSelect');
    var cardContainer = document.getElementById('cardContainer');

    // Function to populate the name dropdown based on the selected date
    function populateNameDropdown(selectedDate) {
        // Clear previous options
        nameSelect.innerHTML = '<option value="">Select a Name</option>';

        // Populate the name dropdown with names for the selected date
        if (selectedDate in names) {
            names[selectedDate].forEach(function(name) {
                var option = document.createElement('option');
                option.value = name;
                option.text = name;
                nameSelect.appendChild(option);
            });
            nameSelect.removeAttribute('disabled');
        }
    }

    // Function to display cards for a selected date and name
    function displayCards(selectedDate, selectedName) {
        // Clear previous cards
        cardContainer.innerHTML = '';

        // Display the cards with records for the selected date and name
        if (selectedDate in records && selectedName in records[selectedDate]) {
            var selectedRecords = records[selectedDate][selectedName];
            selectedRecords.forEach(function(record) {
                var cardDiv = document.createElement('div');
                cardDiv.className = 'col-sm-12 col-md-4';
                cardDiv.innerHTML = `
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class=""><i class="display-6 text-warning ti-bolt"></i></div>
                                <div class="m-l-10 align-self-center">
                                    <h4 class="m-b-0">${record[0]}</h4>
                                </div>
                                <div class="ml-auto align-self-center">
                                    <h2 class="font-medium m-b-0">${record[2]} <span class="lead h6">MW</span></h2>
                                    <h5 class="font-medium m-b-0">${record[3]}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                cardContainer.appendChild(cardDiv);
            });
        }
    }

    // PHP variables converted to JavaScript objects
    var names = <?php echo json_encode($names); ?>;
    var records = <?php echo json_encode($records); ?>;

    // Populate the name dropdown with the default selected date and select the first date
    var defaultSelectedDate = dateSelect.options[1].value; // Assuming the first date is at index 1
    var defaultSelectedName = names[defaultSelectedDate][0]; // Assuming the first name for the first date is at index 0
    populateNameDropdown(defaultSelectedDate);
    dateSelect.value = defaultSelectedDate;

    // Set the default selected name
    var defaultNameOption = nameSelect.querySelector('option[value="' + defaultSelectedName + '"]');
    if (defaultNameOption) {
        defaultNameOption.selected = true;
    }

    // Display cards for the default selected date and name
    displayCards(defaultSelectedDate, defaultSelectedName);
    updateChart(defaultSelectedDate, defaultSelectedName);

    // // Populate the name dropdown with the default selected date and select the first date
    // var defaultSelectedDate = dateSelect.options[1].value; // Assuming the first date is at index 1
    // var defaultSelectedName = names[defaultSelectedDate][0]; // Assuming the first name for the first date is at index 0
    // populateNameDropdown(defaultSelectedDate);
    // dateSelect.value = defaultSelectedDate;

    // // Display cards for the default selected date and name
    // displayCards(defaultSelectedDate, defaultSelectedName);

    // Event listener for date selection
    dateSelect.addEventListener('change', function() {
        // Get the selected date
        var selectedDate = dateSelect.value;
        console.log(selectedDate);
        // Populate the name dropdown based on the selected date
        populateNameDropdown(selectedDate);

        // Select the first name for the selected date
        if (selectedDate in names && names[selectedDate].length > 0) {
            nameSelect.value = names[selectedDate][0];
        }

        // Display cards for the selected date and name
        displayCards(selectedDate, nameSelect.value);
        updateChart(selectedDate, nameSelect.value);
    });

    // Event listener for name selection
    nameSelect.addEventListener('change', function() {
        // Get the selected date and name
        var selectedDate = dateSelect.value;
        var selectedName = nameSelect.value;

        // Display cards for the selected date and name
        displayCards(selectedDate, selectedName);
        updateChart(selectedDate, selectedName);
    });
</script>
</body>

</html>