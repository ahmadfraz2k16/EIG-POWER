<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HTML 5 Boilerplate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
</head>

<body>

    <div class="container-fluid">
        <figure class="highcharts-figure">
            <div id="container2"></div>
        </figure>
        <figure class="highcharts-figure">
            <div id="container3"></div>
        </figure>
    </div>

    <script>
        Highcharts.chart('container2', {
            chart: {
                type: 'areaspline'
            },
            title: {
                text: 'Energy Production for a Specific Date',
                align: 'left'
            },
            xAxis: [{
                visible: true, // Show the x-axis
                type: 'datetime', // Use datetime type for x values
                // tickInterval: 15, // Set tick interval to 15 minutes
                tickInterval: 15 * 60 * 1000, // Set tick interval to 15 minutes
                dateTimeLabelFormats: {
                    hour: '%H:%M', // Format for hours and minutes
                    day: '%Y-%m-%d' // Format for days
                },
                title: {
                    text: '2023-08-24'
                },
                labels: {
                    formatter: function() {
                        // Custom formatter to display time as HH:MM
                        const date = new Date(this.value);
                        const hours = date.getUTCHours().toString().padStart(2, '0');
                        const minutes = date.getUTCMinutes().toString().padStart(2, '0');
                        return hours + ':' + minutes;
                    }
                }
            }],
            yAxis: {
                title: {
                    text: 'Energy Production (Megawatt)'
                }
            },
            tooltip: {
                headerFormat: '<b>Time: {point.x:%H:%M}</b><br>',
                pointFormat: 'Energy Production: {point.y} MW'
            },
            plotOptions: {
                areaspline: {
                    fillOpacity: 0.5,
                    lineWidth: 2,
                    lineColor: 'rgba(68, 170, 213, .2)'
                }
            },
            series: [{
                name: 'Energy Production',
                data: [{
                        x: Date.UTC(2023, 8, 24, 0, 0),
                        y: 100
                    }, // Replace with your data for each hour
                    {
                        x: Date.UTC(2023, 8, 24, 1, 0),
                        y: 150
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 2, 0),
                        y: 200
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 3, 0),
                        y: 250
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 4, 0),
                        y: 300
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 5, 0),
                        y: 350
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 6, 0),
                        y: 400
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 7, 0),
                        y: 450
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 8, 0),
                        y: 500
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 9, 0),
                        y: 550
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 10, 0),
                        y: 600
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 11, 0),
                        y: 650
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 12, 0),
                        y: 700
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 13, 0),
                        y: 750
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 14, 0),
                        y: 800
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 15, 0),
                        y: 800
                    },

                    // peak points in 24 hours, with 15 minute interval
                    {
                        x: Date.UTC(2023, 8, 24, 15, 15),
                        y: 800
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 15, 30),
                        y: 800
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 15, 45),
                        y: 800
                    },
                    // end of peak points

                    {
                        x: Date.UTC(2023, 8, 24, 16, 0),
                        y: 800
                    },

                    // peak points in 24 hours, with 15 minute interval
                    {
                        x: Date.UTC(2023, 8, 24, 16, 15),
                        y: 800
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 16, 30),
                        y: 800
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 16, 45),
                        y: 800
                    },
                    // end of peak points

                    {
                        x: Date.UTC(2023, 8, 24, 17, 0),
                        y: 800
                    },

                    // peak points in 24 hours, with 15 minute interval
                    {
                        x: Date.UTC(2023, 8, 24, 17, 15),
                        y: 850
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 17, 30),
                        y: 900
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 17, 45),
                        y: 950
                    },
                    // end of peak points

                    {
                        x: Date.UTC(2023, 8, 24, 18, 0),
                        y: 1000
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 19, 0),
                        y: 1050
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 20, 0),
                        y: 1100
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 21, 0),
                        y: 1200
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 22, 0),
                        y: 1300
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 23, 0),
                        y: 1300
                    }
                ]
            }, {
                name: 'Peak Hours',
                type: 'areaspline',
                color: 'rgba(219, 112, 147, 0.8)',
                fillColor: 'rgba(219, 112, 147, 0.8)',
                marker: {
                    enabled: true,
                    fillColor: 'rgba(219, 112, 147, 1)',
                    lineColor: 'rgba(219, 112, 147, 1)'
                },
                connectEnds: true,
                data: [{
                        x: Date.UTC(2023, 8, 24, 15, 15),
                        y: 800
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 15, 30),
                        y: 800
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 15, 45),
                        y: 800
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 16, 15),
                        y: 800
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 16, 30),
                        y: 800
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 16, 45),
                        y: 800
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 17, 15),
                        y: 850
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 17, 30),
                        y: 900
                    },
                    {
                        x: Date.UTC(2023, 8, 24, 17, 45),
                        y: 950
                    }
                ]


            }]
        });
    </script>

    <?php
    // Define the path to your CSV file
    $csvFilePath = 'C:/xampp/htdocs/latest_Dash/html/iconbar/include/csv/peakhours.csv';

    // Initialize an empty array to store peak hours data
    $peakHoursData = [];

    // Define the target date and power plant
    $targetDate = '03/02/2022';
    $targetPowerPlant = 'TARBELA';

    // Initialize an empty array for the data points
    $dataPoints = [];

    // Read the CSV file and parse the data
    if (($handle = fopen($csvFilePath, 'r')) !== false) {
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            // Assuming your CSV structure has columns named 'name', 'peak_no', 'peak_values', and 'Time'
            $name = $data[0];
            $peakNo = $data[1];
            $peakValue = intval($data[2]);
            $timestamp = strtotime($data[3]);

            // Check if the row corresponds to the target date and power plant name
            if ($name === $targetPowerPlant && date('m/d/Y', $timestamp) === $targetDate && preg_match('/^p\d+$/', $peakNo)) {
                // Add the data point to the dataPoints array
                $dataPoints[] = [
                    'x' => $timestamp * 1000, // Convert to milliseconds for Highcharts
                    'y' => $peakValue,
                ];
            }
        }

        fclose($handle);
    }
    // Create a single series with the peak hours data points
    $peakHoursData['TARBELA_Peak_Hours'] = $dataPoints;

    // Define the path to your mw_new.csv file
    $mwNewFilePath = 'C:/xampp/htdocs/latest_Dash/html/iconbar/include/csv/mw_new.csv';

    // Initialize an empty array for the mw_new data points
    $mwNewDataPoints = [];

    // Read the mw_new.csv file and parse the data
    if (($handle = fopen($mwNewFilePath, 'r')) !== false) {
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            // Assuming your CSV structure has columns named 'Time', 'Name', and 'Energy_MWh'
            $mwName = $data[2];
            $mwTimestamp = strtotime($data[1]);
            $mwEnergyMWh = intval($data[4]);

            // Check if the row corresponds to the target date and power plant name
            if ($mwName === $targetPowerPlant && date('m/d/Y', $mwTimestamp) === $targetDate) {
                // Add the mw_new data point to the mwNewDataPoints array
                $mwNewDataPoints[] = [
                    'x' => $mwTimestamp * 1000, // Convert to milliseconds for Highcharts
                    'y' => $mwEnergyMWh,
                ];
            }
        }

        fclose($handle);
    }
    // Create a single series with the mw_new data points
    $peakHoursData['TARBELA_24_Hours'] = $mwNewDataPoints;
    // var_dump($peakHoursData['TARBELA_24_Hours']);

    // // Create a single series with the data points
    // $peakHoursData['TARBELA_Peak_Hours'] = $dataPoints;
    // Extract the time part and store it in separate arrays
    $peakHoursTimes = [];
    $mwNewTimes = [];
    $final_Xaxis_Times = [];

    foreach ($dataPoints as $dataPoint) {
        $peakHoursTimes[] = date('H:i', $dataPoint['x'] / 1000); // Extract time part and convert to HH:mm format
    }

    foreach ($mwNewDataPoints as $mwNewDataPoint) {
        $mwNewTimes[] = date('H:i', $mwNewDataPoint['x'] / 1000); // Extract time part and convert to HH:mm format
    }



    // // Iterate through the arrays and remove the 'x' key
    // foreach ($peakHoursData['TARBELA_Peak_Hours'] as &$dataPoint) {
    //     unset($dataPoint['x']);
    // }

    // foreach ($peakHoursData['TARBELA_24_Hours'] as &$dataPoint) {
    //     unset($dataPoint['x']);
    // }


    // Add the "x" key with corrected values, to TARBELA_Peak_Hours
    foreach ($peakHoursData['TARBELA_Peak_Hours'] as $index => $dataPoint) {
        $peakHoursData['TARBELA_Peak_Hours'][$index]['x'] = $peakHoursTimes[$index];
    }

    // Add the "x" key with corrected values, to TARBELA_24_Hours
    foreach ($peakHoursData['TARBELA_24_Hours'] as $index => $dataPoint) {
        $peakHoursData['TARBELA_24_Hours'][$index]['x'] = $mwNewTimes[$index];
    }




    // Convert peakHoursData into a JSON string for use in JavaScript
    $peakHoursTimesJson = json_encode($peakHoursTimes);
    $mwNewTimesJson = json_encode($mwNewTimes);
    // Convert peakHoursData into a JSON string for use in JavaScript
    $peakHoursDataJson = json_encode($peakHoursData);
    // echo '<pre>';
    // print_r($peakHoursData);
    // echo '</pre>';
    // var_dump($peakHoursData);
    // echo '<br>';
    // var_dump($peakHoursTimes);
    // echo '<br>';
    // var_dump($mwNewTimes);


    // Initialize a new array to combine data
    $combinedData = [];

    // Iterate through TARBELA_Peak_Hours and combine data
    foreach ($peakHoursData['TARBELA_Peak_Hours'] as $dataPoint) {
        $combinedData[] = [
            'y' => $dataPoint['y'],
            'x' => $dataPoint['x'],
        ];
    }

    // Iterate through TARBELA_24_Hours and combine data
    foreach ($peakHoursData['TARBELA_24_Hours'] as $dataPoint) {
        $combinedData[] = [
            'y' => $dataPoint['y'],
            'x' => $dataPoint['x'],
        ];
    }

    // Create an associative array with the combined data
    $combinedDataArray = [
        'Combined_Data' => $combinedData,
    ];

    // // Convert the combined data into a JSON string for use in JavaScript
    // $combinedDataJson = json_encode($combinedDataArray);

    // Function to compare two data points based on 'x' (time)
    function compareDataPoints($a, $b)
    {
        return strtotime($a['x']) - strtotime($b['x']);
    }

    // Sort the combined data array
    usort($combinedDataArray['Combined_Data'], 'compareDataPoints');

    foreach ($combinedDataArray['Combined_Data'] as $data) {
        $final_Xaxis_Times[] = date('H:i', strtotime($data['x'])); // Convert 'x' to HH:mm format
    }

    // var_dump($final_Xaxis_Times);
    $final_Xaxis_TimesJson = json_encode($final_Xaxis_Times);
    //unset x keys from combined_Data
    foreach ($combinedDataArray['Combined_Data'] as &$dataPoint) {
        unset($dataPoint['x']);
    }
    // Convert the combined data into a JSON string for use in JavaScript
    $combinedDataJson = json_encode($combinedDataArray);
    // Print the combined data
    echo '<pre>';
    // print_r($combinedDataArray);
    print_r($peakHoursTimes);
    print_r($final_Xaxis_TimesJson);
    echo '</pre>';

    ?>


    <script>
        var peakHoursTimes = <?php echo $peakHoursTimesJson; ?>;
        console.log(peakHoursTimes);
        var mwNewTimes = <?php echo $mwNewTimesJson; ?>;
        var final_Xaxis_Times = <?php echo $final_Xaxis_TimesJson; ?>;
        console.log(final_Xaxis_Times);
        // Get the target date in the 'YYYY-MM-DD' format
        const targetDateFormatted = '<?php echo date('Y-m-d', strtotime($targetDate)); ?>';
        // Include the peakHoursData in your Highcharts chart configuration
        var peakHoursData = <?php echo $peakHoursDataJson; ?>;
        var combinedData = <?php echo $combinedDataJson; ?>;

        // // Create an array to hold the zones
        // var zones = [];

        // // Set the entire xAxis area to light blue
        // zones.push({
        //     color: 'rgba(173, 216, 230, 0.8)', // Light blue color with 80% opacity
        //     colorIndex: 0, // Use a different color index for the red zone
        // });

        // // Add a light red zone with dashed style between the first and last peak hour
        // zones.push({
        //     color: 'rgba(255, 182, 193, 0.8)', // Light red color with 50% opacity
        //     value: final_Xaxis_Times.indexOf(peakHoursTimes[0]), // Start from the first peak hour
        //     dashStyle: 'Dash', // Dashed style
        //     colorIndex: 1, // Use a different color index for the red zone
        // });
        // zones.push({
        //     color: 'rgba(255, 182, 193, 0.8)', // Light red color with 50% opacity
        //     value: final_Xaxis_Times.indexOf(peakHoursTimes[peakHoursTimes.length - 1]), // End at the last peak hour
        //     dashStyle: 'Dash', // Dashed style
        //     colorIndex: 1, // Use a different color index for the red zone
        // });
        // // Set the entire xAxis area to light blue
        // zones.push({
        //     color: 'rgba(173, 216, 230, 0.8)', // Light blue color with 80% opacity
        //     colorIndex: 0, // Use a different color index for the red zone
        // });

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
        Highcharts.chart('container3', {
            chart: {
                type: 'areaspline',
            },
            // time: {
            //     timezoneOffset: -5 * 60,
            // },
            title: {
                text: 'Energy Production for ' + targetDateFormatted,
                align: 'left',
            },
            xAxis: {
                type: 'category', // Use category type for discrete time values
                // categories: <?php echo json_encode($mwNewTimes); ?>, // Use mwNewTimes for x-axis categories
                categories: <?php echo json_encode($final_Xaxis_Times); ?>, // Use final_Xaxis_Times for x-axis categories
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
                name: '24_hours_with_Peak_Hours',
                type: 'areaspline',
                data: combinedData['Combined_Data'],
                zoneAxis: 'x', // Set the zoneAxis to 'x'
                zones: zones,
            }, ],
        });
    </script>

    <!-- <script>
        Highcharts.chart('container', {
            chart: {
                type: 'column',

                events: {
                    drilldown: function(e) {
                        if (!e.seriesOptions) {

                            var chart = this,
                                Hydro = {
                                    'Private': {
                                        name: 'Private',
                                        color: 'blue',
                                        data: [
                                            ['00:00', 2],
                                            ['01:00', 6],
                                            ['02:00', 1],
                                            ['03:00', 2],
                                            ['04:00', 3],

                                        ]
                                    },
                                    'Public': {

                                        name: 'Public',
                                        color: 'red',
                                        data: [
                                            ['00:00', 5],
                                            ['01:00', 5],
                                            ['02:00', 5],
                                            ['03:00', 5],
                                            ['04:00', 5],
                                        ]
                                    }
                                },

                                Renewables = {

                                    'Solar': {

                                        name: 'Solar',
                                        color: 'yellow',
                                        data: [
                                            ['00:00', 2],
                                            ['01:00', 6],
                                            ['02:00', 1],
                                            ['03:00', 2],
                                            ['04:00', 3],

                                        ]
                                    },
                                    'Wind': {

                                        name: 'Wind',
                                        color: 'blue',
                                        data: [
                                            ['00:00', 5],
                                            ['01:00', 5],
                                            ['02:00', 5],
                                            ['03:00', 5],
                                            ['04:00', 5],
                                        ]
                                    },
                                    'Bagasse': {

                                        name: 'Bagasse',
                                        color: 'green',
                                        data: [
                                            ['00:00', 5],
                                            ['01:00', 5],
                                            ['02:00', 5],
                                            ['03:00', 5],
                                            ['04:00', 5],
                                        ]
                                    }
                                },
                                Thermal = {

                                    'IPPS': {

                                        name: 'IPPS',
                                        color: 'blue',
                                        data: [
                                            ['00:00', 2],
                                            ['01:00', 6],
                                            ['02:00', 1],
                                            ['03:00', 2],
                                            ['04:00', 3],
                                        ],
                                        stack: "move",
                                        drilldown: true
                                    },
                                    'GENCOS': {

                                        name: 'GENCOS',
                                        color: 'black',
                                        data: [
                                            ['00:00', 5],
                                            ['01:00', 5],
                                            ['02:00', 5],
                                            ['03:00', 5],
                                            ['04:00', 5],
                                        ],
                                        stack: "move",
                                        drilldown: true
                                    }
                                },
                                Nuclear = {

                                    'Nuclear': {

                                        name: 'Nuclear',
                                        color: 'red',
                                        data: [
                                            ['00:00', 2],
                                            ['01:00', 6],
                                            ['02:00', 1],
                                            ['03:00', 2],
                                            ['04:00', 3],
                                        ]
                                    }
                                },
                                IPPS = {

                                    'COAL': {

                                        name: 'COAL',
                                        color: 'black',
                                        data: [
                                            ['00:00', 2],
                                            ['01:00', 6],
                                            ['02:00', 1],
                                            ['03:00', 2],
                                            ['04:00', 3],
                                        ]
                                    },
                                    'GAS': {

                                        name: 'GAS',
                                        color: 'green',
                                        data: [
                                            ['00:00', 5],
                                            ['01:00', 5],
                                            ['02:00', 5],
                                            ['03:00', 5],
                                            ['04:00', 5],
                                        ]
                                    },
                                    'RLNG': {

                                        name: 'RLNG',
                                        color: 'yellow',
                                        data: [
                                            ['00:00', 5],
                                            ['01:00', 5],
                                            ['02:00', 5],
                                            ['03:00', 5],
                                            ['04:00', 5],
                                        ]
                                    },
                                    'FO': {

                                        name: 'FO',
                                        color: 'blue',
                                        data: [
                                            ['00:00', 5],
                                            ['01:00', 5],
                                            ['02:00', 5],
                                            ['03:00', 5],
                                            ['04:00', 5],
                                        ]
                                    }
                                },
                                GENCOS = {

                                    'COAL': {

                                        name: 'COAL',
                                        color: 'black',
                                        data: [
                                            ['00:00', 2],
                                            ['01:00', 6],
                                            ['02:00', 1],
                                            ['03:00', 2],
                                            ['04:00', 3],
                                        ]
                                    },
                                    'GAS': {

                                        name: 'GAS',
                                        color: 'green',
                                        data: [
                                            ['00:00', 5],
                                            ['01:00', 5],
                                            ['02:00', 5],
                                            ['03:00', 5],
                                            ['04:00', 5],
                                        ]
                                    },
                                    'RLNG': {

                                        name: 'RLNG',
                                        color: 'yellow',
                                        data: [
                                            ['00:00', 5],
                                            ['01:00', 5],
                                            ['02:00', 5],
                                            ['03:00', 5],
                                            ['04:00', 5],
                                        ]
                                    }
                                };


                            if (e.point.color == "blue") {
                                chart.addSingleSeriesAsDrilldown(e.point, Hydro.Private);
                                chart.addSingleSeriesAsDrilldown(e.point, Hydro.Public);
                            } else if (e.point.color == "green") {
                                chart.addSingleSeriesAsDrilldown(e.point, Renewables.Solar);
                                chart.addSingleSeriesAsDrilldown(e.point, Renewables.Wind);
                                chart.addSingleSeriesAsDrilldown(e.point, Renewables.Bagasse);
                            } else if (e.point.color == "red") {
                                chart.addSingleSeriesAsDrilldown(e.point, Thermal.IPPS);
                                chart.addSingleSeriesAsDrilldown(e.point, Thermal.GENCOS);
                                if (e.point.color == "blue") {
                                    chart.addSingleSeriesAsDrilldown(e.point, IPPS.COAL);
                                    chart.addSingleSeriesAsDrilldown(e.point, IPPS.GAS);
                                    chart.addSingleSeriesAsDrilldown(e.point, IPPS.IPPS);
                                    chart.addSingleSeriesAsDrilldown(e.point, IPPS.FO);
                                } else if (e.point.color == "black") {
                                    chart.addSingleSeriesAsDrilldown(e.point, GENCOS.COAL);
                                    chart.addSingleSeriesAsDrilldown(e.point, GENCOS.GAS);
                                    chart.addSingleSeriesAsDrilldown(e.point, GENCOS.IPPS);

                                }
                            } else if (e.point.color == "yellow") {
                                chart.addSingleSeriesAsDrilldown(e.point, Nuclear.Nuclear);

                            }
                            chart.applyDrilldown();

                        }
                    }
                }
            },
            xAxis: {

                type: 'category'
                //  categories: ["03-03-2022", "04-03-2022", "05-03-2022", "06-03-2022"]
            },
            tooltip: {
                enabled: true
            },

            plotOptions: {
                series: {

                    stacking: 'percent'
                }
            },

            series: [{

                    id: 'g1',
                    color: 'blue',
                    name: "Hydro",
                    data: [{
                        name: "03-03-2022",
                        y: 1,
                        drilldown: true
                    }, {
                        name: "04-03-2022",
                        y: 2,
                        drilldown: true
                    }, {
                        name: "05-03-2022",
                        y: 3,
                        drilldown: true
                    }, {
                        name: "06-03-2022",
                        y: 4,
                        drilldown: true
                    }],
                    stack: "move",
                    drilldown: true
                },

                {
                    id: 'g2',
                    color: 'green',
                    name: "Renewables",
                    data: [{
                        name: "03-03-2022",
                        y: 1,
                        drilldown: true
                    }, {
                        name: "04-03-2022",
                        y: 2,
                        drilldown: true
                    }, {
                        name: "05-03-2022",
                        y: 3,
                        drilldown: true
                    }, {
                        name: "06-03-2022",
                        y: 4,
                        drilldown: true
                    }],
                    stack: "move",
                    drilldown: true
                },

                {
                    id: 'g3',
                    color: 'red',
                    name: "Thermal",
                    data: [{
                        name: "03-03-2022",
                        y: 1,
                        drilldown: true
                    }, {
                        name: "04-03-2022",
                        y: 2,
                        drilldown: true
                    }, {
                        name: "05-03-2022",
                        y: 3,
                        drilldown: true
                    }, {
                        name: "06-03-2022",
                        y: 4,
                        drilldown: true
                    }],
                    stack: "move",
                    drilldown: true
                },

                {
                    id: 'g4',
                    color: 'yellow',
                    name: "Nuclear",
                    data: [{
                        name: "03-03-2022",
                        y: 1,
                        drilldown: true
                    }, {
                        name: "04-03-2022",
                        y: 2,
                        drilldown: true
                    }, {
                        name: "05-03-2022",
                        y: 3,
                        drilldown: true
                    }, {
                        name: "06-03-2022",
                        y: 4,
                        drilldown: true
                    }],
                    stack: "move",
                    drilldown: true
                }


            ]
        });
    </script> -->
</body>

</html>