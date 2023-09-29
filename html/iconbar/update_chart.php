<?php
function areasplinegraph($date, $name)
{
    $targetDate = $date;
    // Convert the input date string to a Unix timestamp
    $targetDate = strtotime($targetDate);

    // Check if the conversion was successful
    if ($targetDate === false) {
        return "Invalid Date";
    }

    // Convert the Unix timestamp to the desired format "m/d/Y"
    $formattedDate = date("m/d/Y", $targetDate);
    // Define the target date and power plant
    $targetDate = $formattedDate;
    $targetPowerPlant = $name;
    // $targetDate = '03/15/2022';
    // $targetPowerPlant = 'TARBELA';
    // Define the path to your CSV file
    $csvFilePath = 'C:/xampp/htdocs/latest_Dash/html/iconbar/include/csv/peakhours.csv';

    // Initialize an empty array to store peak hours data
    $peakHoursData = [];


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
    // Create an associative array with the combined data
    $combinedDataArray = [
        'Combined_Data' => $combinedDataArray['Combined_Data'],
        'peak_hours' => $peakHoursTimesJson,
        'final_Xaxis' => $final_Xaxis_TimesJson,
        'Date' => $targetDate,
        'PowerPlant_Name' => $targetPowerPlant,
    ];
    // Convert the combined data into a JSON string for use in JavaScript
    $combinedDataJson = json_encode($combinedDataArray);
    // echo $combinedDataJson;
    // Print the combined data
    // echo '<pre>';
    // print_r($combinedDataJson);
    // print_r($combinedDataArray);
    // print_r($peakHoursTimes);
    // print_r($final_Xaxis_TimesJson);
    // echo '</pre>';
    return $combinedDataJson;
}
// Get the selected date and name from the AJAX request
$selectedDate = $_GET['date'];
$selectedName = $_GET['name'];

// Perform data retrieval and processing based on $selectedDate and $selectedName
// Here, we simulate generating sample data.
$updatedChartData = areasplinegraph($selectedDate, $selectedName);

// Send the updated chart data as JSON response
header('Content-Type: application/json');
//already json encoded in php function areasplinegraph
echo $updatedChartData;
// echo json_encode($updatedChartData);
