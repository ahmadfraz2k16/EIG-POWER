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
    } elseif ($categoryName == "HYDRO") {
        return "col-md-6 col-sm-12";
    } else {
        return "col-md-4 col-sm-12";
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

function formatedGraphData($jsonDecodedData)
{
    
    $array = $jsonDecodedData;
    $formattedData = [];
    $subCategoriesData = [];
    // Define custom colors for categories
    $categoryColors = [
        'HYDEL' => '#7091F5',
        'RENEWABLE' => '#5C8374',
        'NUCLEAR' => '#9A3B3B',
        'THERMAL' => '#F0B86E',
    ];

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
                'y' => (int) $hourData['sum'], // Use the sum field as the y value
                'color' => $categoryColors[$mainCategoryName], // Custom color for the main category
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


// var_dump ($array);
function extractDates($inputArray)
{

    $dates = [];

    foreach ($inputArray as $entry) {
        if (isset($entry['DATE'])) {
            $dates[] = "'" . $entry['DATE'] . "'";
        }
    }

    return '[' . implode(', ', $dates) . ']';
}

function getUniqueDates()
{
    // Replace with your database connection code
    $mysqli = new mysqli("localhost", "root", "", "power");

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $dates = [];

    // Query to retrieve distinct dates (without hours) from your database table
    $query = "SELECT DISTINCT DATE(Time) AS DateOnly FROM mw_new";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dates[] = $row['DateOnly'];
        }
    }

    // Close the database connection
    $mysqli->close();

    // Return dates as JSON
    return json_encode($dates);
}
// var_dump(getUniqueDates());
function removeFiles()
{
    // Get all file names 
    $filez = glob('C:/Users/python/Documents/projR/processed_mw_sheets/*');

    // Loop through the file list 
    foreach ($filez as $file) { // Check if file is a regular file and not a directory 
        if (is_file($file))
            // Delete file 
            unlink($file);
    } 
}
