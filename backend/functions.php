<?php
function getDatabaseConnection() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "power";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
# sum of each category over the period of time, currently one month data is in database
function getCategorySumData() {
    $conn = getDatabaseConnection();

    $sql = "SELECT category, SUM(Energy_MWh) AS total_energy FROM mw GROUP BY category ORDER BY total_energy DESC";
    $result = $conn->query($sql);

    $data = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    $conn->close();

    return $data;
}
//daily production version 3
// In functions.php

function getPerDayProductionData()
{
    $conn = getDatabaseConnection();

    $sql = "SELECT category, DATE(Time) AS day, SUM(Energy_MWh) AS total_energy FROM mw GROUP BY category, DATE(Time)";
    $result = $conn->query($sql);

    $data = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $category = $row["category"];
            $day = $row["day"];
            $totalEnergy = $row["total_energy"];

            if (!isset($data[$category])) {
                $data[$category] = array();
            }

            $data[$category][$day] = floatval($totalEnergy); // Convert to float
        }
    }

    $conn->close();

    return $data;
}
// var_dump(getPerDayProductionData());
// Fetch all records with pagination
function getAllRecordsWithPagination($offset, $limit)
{
    $conn = getDatabaseConnection();

    $sql = "SELECT * FROM mw LIMIT $offset, $limit";
    $result = $conn->query($sql);

    $data = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    $conn->close();

    return $data;
}

// Get total record count
function getTotalRecordCount()
{
    $conn = getDatabaseConnection();

    $sql = "SELECT COUNT(*) AS total_records FROM mw";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return intval($row['total_records']);
    }

    $conn->close();

    return 0;
}
// fetch all data, search, date filters
function fetchPowerData($page = 1, $perPage = null, $fromDate = null, $toDate = null, $search =null)
{
    $conn = getDatabaseConnection();
    $offset = ($page - 1) * $perPage;

    $query = "SELECT * FROM mw";

    // Construct WHERE clause for date range and search
    $whereClause = '';
    $bindTypes = '';
    $bindValues = array();

    if (!empty($fromDate)) {
        $whereClause .= " Time >= ?";
        $bindTypes .= "s";
        $bindValues[] = $fromDate;
    }

    if (!empty($toDate)) {
        $whereClause .= ($whereClause ? " AND" : "") . " Time <= ?";
        $bindTypes .= "s";
        $bindValues[] = $toDate;
    }

    if (!empty($search)) {
        $whereClause .= ($whereClause ? " AND" : "") . " Name LIKE ?";
        $bindTypes .= "s";
        $bindValues[] = "%{$search}%";
    }

    if (!empty($whereClause)) {
        $query .= " WHERE" . $whereClause;
    }

    $query .= " LIMIT ?, ?";
    $bindTypes .= "ii";
    $bindValues[] = $offset;
    $bindValues[] = $perPage;

    $statement = $conn->prepare($query);

    // Bind parameters dynamically based on types
    $bindParams = array_merge(array($bindTypes), $bindValues);
    $bind_params = array();
    for ($i = 0; $i < count($bindParams); $i++) {
        $bind_params[] = &$bindParams[$i];
    }
    call_user_func_array(array($statement, 'bind_param'), $bind_params);

    $statement->execute();

    $result = $statement->get_result();

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $statement->close();
    $conn->close();

    return $data;
}
// fetch all data, search, date filters
function fetchPowerDataDownloadPurpose($page = 1, $fromDate = null, $toDate = null, $search =null)
{
    $conn = getDatabaseConnection();
    $perPage = null;
    $offset = ($page - 1) * $perPage;

    $query = "SELECT * FROM mw";

    // Construct WHERE clause for date range and search
    $whereClause = '';
    $bindTypes = '';
    $bindValues = array();

    if (!empty($fromDate)) {
        $whereClause .= " Time >= ?";
        $bindTypes .= "s";
        $bindValues[] = $fromDate;
    }

    if (!empty($toDate)) {
        $whereClause .= ($whereClause ? " AND" : "") . " Time <= ?";
        $bindTypes .= "s";
        $bindValues[] = $toDate;
    }

    if (!empty($search)) {
        $whereClause .= ($whereClause ? " AND" : "") . " Name LIKE ?";
        $bindTypes .= "s";
        $bindValues[] = "%{$search}%";
    }

    if (!empty($whereClause)) {
        $query .= " WHERE" . $whereClause;
    }

    $query .= " LIMIT ?, ?";
    $bindTypes .= "ii";
    $bindValues[] = $offset;
    $bindValues[] = $perPage;

    $statement = $conn->prepare($query);

    // Bind parameters dynamically based on types
    $bindParams = array_merge(array($bindTypes), $bindValues);
    $bind_params = array();
    for ($i = 0; $i < count($bindParams); $i++) {
        $bind_params[] = &$bindParams[$i];
    }
    call_user_func_array(array($statement, 'bind_param'), $bind_params);

    $statement->execute();

    $result = $statement->get_result();

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $statement->close();
    $conn->close();

    return $data;
}
//function for generating cards at index.php, major categories and sub categories
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
    $conn = getDatabaseConnection();
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
// function for lowest date
function startDate(){
    $conn = getDatabaseConnection();

    // Get the lowest date
    $sqlLowestDate = "SELECT MIN(Time) AS LowestDate FROM mw_new";
    $resultLowestDate = $conn->query($sqlLowestDate);
    $rowLowestDate = $resultLowestDate->fetch_assoc();
    $lowestDate = $rowLowestDate["LowestDate"];
    
    $conn->close();
    return $lowestDate;

}
// function for highest date
function endDate(){
    $conn = getDatabaseConnection();

    // Get the greatest date
    $sqlGreatestDate = "SELECT MAX(Time) AS GreatestDate FROM mw_new";
    $resultGreatestDate = $conn->query($sqlGreatestDate);
    $rowGreatestDate = $resultGreatestDate->fetch_assoc();
    $greatestDate = $rowGreatestDate["GreatestDate"];

    $conn->close();
    return $greatestDate;

}
// stacked column [bar graph]
// Function to extract and format data for major categories and subcategories
// function extractDataForGraph($startDate, $endDate)
// {
//     $HydroSubCategoryNames = array(
//         "Private",
//         "Public"
//     );
//     $HydroSubCategoryQueries = array(
//         "SELECT SUM(Energy_MWh) AS TotalEnergy FROM mw_new WHERE sub_categories_by_fuel = 'HYDEL' AND Time BETWEEN '$startDate' AND '$endDate'",
//         "SELECT SUM(Energy_MWh) AS TotalEnergy FROM mw_new WHERE sub_categories_by_fuel = 'IPPS HYDEL HYDEL' AND Time BETWEEN '$startDate' AND '$endDate'"

//     );
//     // Initialize arrays to store data
//     $data = array();

//     // Hydro category
//     $hydroData = array();
//     foreach ($HydroSubCategoryQueries as $key => $query) {
//         // Assuming you have a database connection established
//         $conn = getDatabaseConnection();

//         if ($conn->connect_error) {
//             die("Connection failed: " . $conn->connect_error);
//         }

//         $result = $conn->query($query);

//         if ($result->num_rows > 0) {
//             $row = $result->fetch_assoc();

//             $hydroData[] = array(
//                 'y' => (float)$row['TotalEnergy'],
//                 'color' => '#91C8E4', // Custom color for subcategory
//                 'subCategories' => $HydroSubCategoryNames[$key] . ' (' . (float)$row['TotalEnergy'] . ')',
//             );
//         }

//         $conn->close();
//     }

//     $data[] = array(
//         'name' => 'HYDRO',
//         'data' => $hydroData,
//     );

//     // Add similar code for other major categories (Renewable, Nuclear, Thermal) here...

//     // Convert the data array to JSON format
//     $jsonData = json_encode($data);

//     return $jsonData;
// }


// function extractDataForGraph($startDate, $endDate)
// {
//     // Assuming you have a database connection established
//     $conn = getDatabaseConnection();
//     // Initialize arrays to store data
//     $data = array();

//     // Define an array of hours from 00 to 23
//     $hours = array("00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23");

//     // Initialize arrays to store subcategory sums for each hour
//     $hydroSubcategorySums = array();

//     // Iterate through the hours and generate data for each hour
//     foreach ($hours as $hour) {
//         // Modify your SQL query to group by hour and fetch data within the date range
//         $query = "SELECT HOUR(Time) AS Hour, sub_categories_by_fuel, SUM(Energy_MWh) AS TotalEnergy 
//                   FROM mw_new 
//                   WHERE DATE(Time) BETWEEN '$startDate' AND '$endDate' 
//                   AND HOUR(Time) = '$hour' 
//                   GROUP BY Hour, sub_categories_by_fuel";

//         $result = mysqli_query($conn, $query);

//         // Initialize arrays to store private and public subcategory data for this hour
//         $hourlyPrivateSubcategories = array();
//         $hourlyPublicSubcategories = array();

//         // Iterate through the result and calculate subcategory sums for this hour
//         while ($row = mysqli_fetch_assoc($result)) {
//             $subcategory = $row['sub_categories_by_fuel'];
//             $totalEnergy = isset($row['TotalEnergy']) ? (float)$row['TotalEnergy'] : 0;

//             // Check if the subcategory is private or public
//             if ($subcategory === 'IPPS HYDEL HYDEL') {
//                 // Private subcategory
//                 $hourlyPrivateSubcategories[] = array(
//                     'name' => 'Private',
//                     'y' => $totalEnergy,
//                     'color' => '#91C8E4', // Custom color for private subcategory
//                 );
//             } elseif ($subcategory === 'HYDEL') {
//                 // Public subcategory
//                 $hourlyPublicSubcategories[] = array(
//                     'name' => 'Public',
//                     'y' => $totalEnergy,
//                     'color' => '#FFA500', // Custom color for public subcategory
//                 );
//             }

//             // Update the sum for the subcategory in the overall sum array
//             if (!isset($hydroSubcategorySums[$subcategory])) {
//                 $hydroSubcategorySums[$subcategory] = 0;
//             }
//             $hydroSubcategorySums[$subcategory] += $totalEnergy;
//         }

//         // Add the data for this hour to the main data array
//         $data[] = array(
//             'hour' => $hour,
//             'privateSubcategories' => $hourlyPrivateSubcategories, // Add private subcategory data for this hour
//             'publicSubcategories' => $hourlyPublicSubcategories,   // Add public subcategory data for this hour
//         );
//     }

//     // Calculate the sum for the "HYDRO" major category
//     $hydroTotal = array_sum($hydroSubcategorySums);

//     // Convert the data array to JSON format along with the "HYDRO" total
//     $jsonData = json_encode(array(
//         'data' => $data,
//         'hydroTotal' => $hydroTotal, // Add the total for "HYDRO"
//     ));
//     // Convert the data array to JSON format
//     $jsonData = json_encode($data);
//     return $jsonData;
// }
function extractDataForGraph($startDate, $endDate){
    $conn = getDatabaseConnection();
    // Construct the SQL query to select specific columns
    $sql = "SELECT Time, Energy_MWh, sub_categories_by_fuel FROM mw_new WHERE `Time` >= '$startDate 00:00:00' AND `Time` <= '$endDate 23:00:00'";

    // Execute the query and fetch the results
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        // Handle the error if the query fails
        $response = array('error' => 'Database error: ' . mysqli_error($conn));
        echo json_encode($response);
        return;
    }

    // Initialize an array to store the summed data
    $summedData = array();

    // Fetch rows and sum the Energy_MWh for each sub_categories_by_fuel for each hour
    while ($row = mysqli_fetch_assoc($result)) {
        $time = $row['Time'];
        $hour = date('H', strtotime($time));
        $subCategory = $row['sub_categories_by_fuel'];
        $energy = (float)$row['Energy_MWh'];

        // Initialize the array for the hour if it doesn't exist
        if (!isset($summedData[$time])) {
            $summedData[$time] = array();
        }

        // Initialize the sum for the sub_category if it doesn't exist
        if (!isset($summedData[$time][$subCategory])) {
            $summedData[$time][$subCategory] = 0.0;
        }

        // Sum the Energy_MWh for the sub_category and hour
        $summedData[$time][$subCategory] += $energy;
    }

    // Close the database connection
    mysqli_close($conn);

    // Create an associative array with "DATE" key
    $finalData = array();
    foreach ($summedData as $time => $data) {
        $finalData[] = array("DATE" => $time) + $data;
    }

    //EXTRA PROCESSING
    

    // Initialize an array to store the modified data
    $modifiedData = array();

    // Loop through the data and perform calculations
    // Loop through the data and perform calculations
    foreach ($finalData as $element) {
        // Calculate the values for each category
        $public = $element['HYDEL'];
        $private = $element['IPPS HYDEL HYDEL'];
        $SOLAR = $element['SOLAR'];
        $WIND = $element['WIND'];
        $BAGASSE = $element['IPPS BAGASSE BAGASSE'];
        $NUCLEAR = $element['NUCLEAR'];
        $GENCOS = $element['GENCOS RLNG'] + $element['GENCOS Coal'] + $element['GENCOS Gas'];
        $IPPS = $element['IPPS FOSSIL FUEL Gas'] + $element['IPPS FOSSIL FUEL Coal'] + $element['IPPS FOSSIL FUEL FO'] + $element['IPPS FOSSIL FUEL RLNG'];
        $HYDEL = array(
            "PRIVATE" => $private,
            "PUBLIC" => $public,
        );
        $RENEWABLE = array(
            "SOLAR" => $SOLAR,
            "WIND" => $WIND,
            "BAGASSE" => $BAGASSE,
        );
        $NUCLEAR = array(
            "NUCLEAR" => $NUCLEAR,
        );
        $THERMAL = array(
            "GENCOS" => $GENCOS,
            "IPPS" => $IPPS,
        );

        // Create a new array with the modified values
        $modifiedElement = array(
            "DATE" => $element['DATE'],
            "HYDEL" => $HYDEL,
            "RENEWABLE" => $RENEWABLE,
            "NUCLEAR" => $NUCLEAR,
            "THERMAL" => $THERMAL,
        );

        // Add the modified element to the result array
        $modifiedData[] = $modifiedElement;
    }

    
    // // Encode the summed data as JSON and send it as a response
    return json_encode($modifiedData, JSON_PRETTY_PRINT);
}

// var_dump($array);
// Assuming your data is stored in the $dataArray variable
// foreach ($array as $entry) {
//     // Access and display the date
//     $date = $entry['DATE'];
//     echo "Date: $date<br>";

//     // Loop through the main categories
//     foreach ($entry as $categoryKey => $categoryValue) {
//         // Skip the 'DATE' key
//         if ($categoryKey === 'DATE') continue;

//         // Display the main category name
//         echo "Main Category: $categoryKey<br>";

//         // Loop through the subcategories and their values
//         foreach ($categoryValue as $subcategoryKey => $subcategoryValue) {
//             // Display the subcategory and its production value
//             echo "Subcategory: $subcategoryKey, Production Value: $subcategoryValue<br>";
//         }
//     }

//     // Add a separator between entries
//     echo "<hr>";
// }
function formatedGraphData()
{
    $startDate = '2022-03-02';
    $endDate = '2022-03-02';
    $jsonData = extractDataForGraph($startDate, $endDate);
    $array = json_decode($jsonData, true);
    $formattedData = [];
    $subCategoriesData = [];

    foreach ($array as $entry) {
        // Get the hour from the date field
        $hour = date('H', strtotime($entry['DATE']));

        foreach ($entry as $categoryKey => $categoryValue) {
            if ($categoryKey === 'DATE') continue;

            foreach ($categoryValue as $subcategoryKey => $subcategoryValue) {
                // Check if the main category name and hour exist in the subCategoriesData array
                if (!isset($subCategoriesData[$categoryKey][$hour])) {
                    // If not, create a new entry with the sum and subcategories fields
                    $subCategoriesData[$categoryKey][$hour] = [
                        'sum' => 0,
                        'subCategories' => [],
                    ];
                }

                // Add the subcategory value to the sum field
                $subCategoriesData[$categoryKey][$hour]['sum'] += $subcategoryValue;

                // Create a formatted subcategory string
                $subcategoryFormatted = "$subcategoryKey ($subcategoryValue)";

                // Add the subcategory string to the subcategories field
                $subCategoriesData[$categoryKey][$hour]['subCategories'][] = $subcategoryFormatted;
            }
        }
    }

    foreach ($subCategoriesData as $mainCategoryName => $mainCategoryHours) {
        // Create a data entry for the formatted data array
        $dataEntry = [];

        foreach ($mainCategoryHours as $hour => $hourData) {
            // Create a data entry for each hour
            $dataEntry[] = [
                'y' => $hourData['sum'], // Use the sum field as the y value
                'color' => '#91C8E4', // Custom color for the main category
                'subCategories' => implode(', ', $hourData['subCategories']), // Join the subcategories with commas
            ];
        }

        // Add the data entry to the formatted data array
        $formattedData[] = [
            'name' => $mainCategoryName,
            'data' => $dataEntry, // Use the data entry as an array
        ];
    }

    // Convert the formatted data to JSON
    $formattedDataJson = json_encode($formattedData, JSON_PRETTY_PRINT);

    // Print the JSON data
    return $formattedDataJson;
}



// function formatedGraphData(){
//     // Example usage:
//     $startDate = '2022-03-02';
//     $endDate = '2022-03-02';

//     $jsonData = extractDataForGraph($startDate, $endDate);
//     $array = json_decode($jsonData, true); // convert the JSON string to an associative array
//     // Initialize an empty array to store the formatted data
//     $formattedData = [];

//     // Create an empty array to store subcategories for each main category
//     $subCategoriesData = [];

//     // Loop through your existing data
//     foreach ($array as $entry) {
//         // Loop through the main categories and their subcategories
//         foreach ($entry as $categoryKey => $categoryValue) {
//             // Skip the 'DATE' key
//             if ($categoryKey === 'DATE'
//             ) continue;

//             // Create an array for the subcategories and their production values
//             $subcategoryData = [];
//             foreach ($categoryValue as $subcategoryKey => $subcategoryValue) {
//                 // Format the subcategory and its production value
//                 $subcategoryFormatted = "$subcategoryKey ($subcategoryValue)";
//                 $subcategoryData[] = [
//                     'y' => $subcategoryValue,
//                     'color' => '#91C8E4', // Custom color for the subcategory
//                     'subCategories' => $subcategoryFormatted,
//                 ];
//             }

//             // Use the main category name as the 'name' key
//             $mainCategoryName = $categoryKey;

//             // Store the subcategories data for each main category
//             if (!isset($subCategoriesData[$mainCategoryName])) {
//                 $subCategoriesData[$mainCategoryName] = $subcategoryData;
//             } else {
//                 // Merge subcategories data for the same main category
//                 $subCategoriesData[$mainCategoryName] = array_merge($subCategoriesData[$mainCategoryName], $subcategoryData);
//             }
//         }
//     }

//     // Create the final formatted data structure with one 'data' key per main category
//     foreach ($subCategoriesData as $mainCategoryName => $mainCategoryData) {
//         $formattedData[] = [
//             'name' => $mainCategoryName,
//             'data' => $mainCategoryData,
//         ];
//     }

//     // Convert the formatted data to JSON
//     $formattedDataJson = json_encode($formattedData, JSON_PRETTY_PRINT);

//     // Print the JSON data
//     return $formattedDataJson;

// }
echo formatedGraphData();



// // Your data as an array of objects
// $data = json_decode($jsonData);

// // A function to convert an object to a series array
// function object_to_series($obj)
// {
//     // Get the keys and values of the object
//     $keys = array_keys(get_object_vars($obj));
//     $values = array_values(get_object_vars($obj));

//     // Format the numeric values with two decimal digits
//     $values = array_map(function ($v) {
//         return is_numeric($v) ? number_format($v, 2) : $v;
//     }, $values);

//     // Return the series array with the name and data keys
//     return array(
//         "name" => $keys[0],
//         "data" => $values
//     );
// }

// // Convert each object in the data to a series array
// $series = array_map("object_to_series", $data);
// // Print the output
// print_r($series) ;






// $startingDate = '2022-03-02';
// $endingDate = '2022-03-02';

// $responseData = extractDataForGraph($startingDate, $endingDate); 
// // Decode the JSON response
// $data = json_decode($responseData, true);

// // Initialize arrays for categories, series data, and colors
// $categories = [];
// $seriesData = [];
// $colors = ['#91C8E4', '#A8DF8E', '#FF6969', '#F0B86E']; // Custom colors for major categories

// // Loop through data to format it for Highcharts
// foreach ($data as $item) {
//     $categories[] = $item['DATE'];

//     // Loop through major categories ('HYDEL', 'RENEWABLE', 'NUCLEAR', 'THERMAL')
//     foreach (array_keys($item) as $majorCategory) {
//         if ($majorCategory === 'DATE') continue; // Skip 'DATE' key

//         // Loop through subcategories ('PRIVATE', 'PUBLIC', 'SOLAR', 'WIND', 'BAGASSE', 'NUCLEAR', 'GENCOS', 'IPPS')
//         foreach ($item[$majorCategory] as $subcategory => $value) {
//             // Prepare data point for subcategory
//             $dataPoint = [
//                 'y' => $value,
//                 'color' => $colors[array_search($majorCategory, array_keys($item))], // Use custom color for major category
//                 'subCategories' => $subcategory . ' (' . $value . ')',
//             ];

//             // Add data point to the corresponding series
//             $seriesData[$majorCategory][] = $dataPoint;
//         }
//     }
// }



// // //xAxis: categories:
// // echo json_encode($categories); 
// // echo json_encode($colors);  // Use the custom colors for major categories


// // Generate series for each major category
// foreach ($seriesData as $majorCategory => $data) {
// echo "{
//     name: '$majorCategory',
//     data: " . json_encode($data) . "
// },";
// }

        
