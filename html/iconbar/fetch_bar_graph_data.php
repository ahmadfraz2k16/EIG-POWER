<?php
// Initialize an empty response array
$response = array();
// Check if the selectedDate parameter is set
if (isset($_GET['selectedDate'])) {
    // Get the selected date from the query parameter
    $selectedDate = $_GET['selectedDate'];
    $startDate = $selectedDate;
    $endDate = $selectedDate;
    $jsonData = extractDataForGraph($startDate, $endDate);
    $array = json_decode($jsonData, true);

    // Call the formattedGraphData function and store the result
    $formattedData = formattedGraphDataV2($array);

    // Add 'dates' and 'series' keys to the response array
    $response['dates'] = $formattedData['dates'];
    $response['series'] = $formattedData['series'];
    // Set the response content type to JSON
    header('Content-Type: application/json');

    // Encode the response array as JSON and echo it
    echo json_encode($response);
} 
else {
    $startDate = '2022-03-03';
    $endDate = '2022-03-5';
    $jsonData = extractDataForGraph($startDate, $endDate);
    $array = json_decode($jsonData, true);

    // Call the formattedGraphData function and store the result
    $formattedData = formattedGraphDataV2($array);

    // Add 'dates' and 'series' keys to the response array
    $response['dates'] = $formattedData['dates'];
    $response['series'] = $formattedData['series'];
    // Set the response content type to JSON
    header('Content-Type: application/json');

    // Encode the response array as JSON and echo it
    echo json_encode($response);
}

?>