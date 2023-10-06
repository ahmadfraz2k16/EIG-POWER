<?php
include 'C:/xampp/htdocs/latest_Dash/backend/functions.php';
$startDate = date_format(date_create(startDate()), "Y-m-d");
$endDate = date_format(date_create(endDate()), "Y-m-d");
?>
<?php

// // Initialize the associative array to store the data
// $gencosData = array();

// // Open the CSV file for reading
// $csvFile = fopen('include/CSV/mw_new.csv', 'r');

// // Define the categories to filter
// $categoriesToFilter = ['GENCOS Gas', 'GENCOS Coal', 'GENCOS RLNG'];

// // Define the target date in 'Y-m-d' format
// $targetDate = '2022-03-02';

// // Initialize an array to store hourly sums
// $hourlySums = array();

// // Loop through each line in the CSV file
// while (($row = fgetcsv($csvFile)) !== false) {
//     // Extract the relevant columns
//     $date = $row[1];
//     $subCategory = $row[5];
//     $energyMWh = (int)$row[4];

//     // Check if the date matches the target date and the sub_category_by_fuel matches the desired values
//     if (date('Y-m-d', strtotime($date)) === $targetDate && in_array($subCategory, $categoriesToFilter)) {
//         // Parse the date to get the hour
//         $hour = date('H', strtotime($date));

//         // Determine the category name based on sub_categories_by_fuel
//         switch ($subCategory) {
//             case 'GENCOS Gas':
//                 $category = 'Gas';
//                 $color = 'yellow'; // Set the desired color for Gas
//                 break;
//             case 'GENCOS Coal':
//                 $category = 'Coal';
//                 $color = 'green'; // Set the desired color for Coal
//                 break;
//             case 'GENCOS RLNG':
//                 $category = 'RLNG';
//                 $color = 'blue'; // Set the desired color for RLNG
//                 break;
//         }

//         // Create or update the category entry in the associative array
//         if (!isset($gencosData[$category])) {
//             $gencosData[$category] = array(
//                 'name' => $category,
//                 'color' => $color,
//                 'data' => array()
//             );
//         }

//         // Add the energy value to the corresponding hour's sum
//         if (!isset($hourlySums[$hour])) {
//             $hourlySums[$hour] = 0;
//         }
//         $hourlySums[$hour] += $energyMWh;
//     }
// }

// // Close the CSV file
// fclose($csvFile);

// // Convert hourly sums to the desired format
// foreach ($hourlySums as $hour => $sum) {
//     foreach ($gencosData as &$categoryData) {
//         $categoryData['data'][] = [$hour . ':00', $sum];
//     }
// }

// // Output the result in JSON format
// echo json_encode($gencosData, JSON_PRETTY_PRINT);

?>
<?php

// // Initialize the associative array to store the data
// $ippsData = array();

// // Open the CSV file for reading
// $csvFile = fopen('include/CSV/mw_new.csv', 'r');

// // Define the categories to filter for IPPS
// $categoriesToFilter = ['IPPS FOSSIL FUEL Gas', 'IPPS FOSSIL FUEL Coal', 'IPPS FOSSIL FUEL FO', 'IPPS FOSSIL FUEL RLNG'];

// // Define the target date in 'Y-m-d' format
// $targetDate = '2022-03-02';

// // Initialize an array to store hourly sums
// $hourlySums = array();

// // Loop through each line in the CSV file
// while (($row = fgetcsv($csvFile)) !== false) {
//     // Extract the relevant columns
//     $date = $row[1];
//     $subCategory = $row[5];
//     $energyMWh = (int)$row[4];

//     // Check if the date matches the target date and the sub_category_by_fuel matches the desired values
//     if (date('Y-m-d', strtotime($date)) === $targetDate && in_array($subCategory, $categoriesToFilter)) {
//         // Parse the date to get the hour
//         $hour = date('H', strtotime($date));

//         // Determine the category name based on sub_categories_by_fuel
//         switch ($subCategory) {
//             case 'IPPS FOSSIL FUEL Gas':
//                 $category = 'Gas';
//                 $color = 'yellow'; // Set the desired color for Gas
//                 break;
//             case 'IPPS FOSSIL FUEL Coal':
//                 $category = 'Coal';
//                 $color = 'green'; // Set the desired color for Coal
//                 break;
//             case 'IPPS FOSSIL FUEL FO':
//                 $category = 'FO';
//                 $color = 'red'; // Set the desired color for FO
//                 break;
//             case 'IPPS FOSSIL FUEL RLNG':
//                 $category = 'RLNG';
//                 $color = 'blue'; // Set the desired color for RLNG
//                 break;
//         }

//         // Create or update the category entry in the associative array
//         if (!isset($ippsData[$category])) {
//             $ippsData[$category] = array(
//                 'name' => $category,
//                 'color' => $color,
//                 'data' => array()
//             );
//         }

//         // Add the energy value to the corresponding hour's sum
//         if (!isset($hourlySums[$hour])) {
//             $hourlySums[$hour] = 0;
//         }
//         $hourlySums[$hour] += $energyMWh;
//     }
// }

// // Close the CSV file
// fclose($csvFile);

// // Convert hourly sums to the desired format
// foreach ($hourlySums as $hour => $sum) {
//     foreach ($ippsData as &$categoryData) {
//         $categoryData['data'][] = [$hour . ':00', $sum];
//     }
// }

// // Output the result in JSON format
// echo json_encode($ippsData, JSON_PRETTY_PRINT);

?>
<?php

// Function to process data for a given set of categories and target date
function processData($categoriesToFilter, $targetDate)
{
    // Initialize the associative array to store the data
    $data = array();

    // Open the CSV file for reading
    $csvFile = fopen('include/CSV/mw_new.csv', 'r');

    // Initialize an array to store hourly sums
    $hourlySums = array();

    // Loop through each line in the CSV file
    while (($row = fgetcsv($csvFile)) !== false) {
        // Extract the relevant columns
        $date = $row[1];
        $subCategory = $row[5];
        $energyMWh = (int)$row[4];

        // Check if the date matches the target date and the sub_category_by_fuel matches the desired values
        if (date('Y-m-d', strtotime($date)) === $targetDate && in_array($subCategory, $categoriesToFilter)) {
            // Parse the date to get the hour
            $hour = date('H', strtotime($date));

            // Determine the category name based on sub_categories_by_fuel
            switch ($subCategory) {
                case 'GENCOS Gas':
                    $category = 'Gas';
                    $color = 'yellow'; // Set the desired color for Gas
                    break;
                case 'GENCOS Coal':
                    $category = 'Coal';
                    $color = 'green'; // Set the desired color for Coal
                    break;
                case 'GENCOS RLNG':
                    $category = 'RLNG';
                    $color = 'blue'; // Set the desired color for RLNG
                    break;
                case 'IPPS FOSSIL FUEL Gas':
                    $category = 'Gas';
                    $color = 'yellow'; // Set the desired color for Gas
                    break;
                case 'IPPS FOSSIL FUEL Coal':
                    $category = 'Coal';
                    $color = 'green'; // Set the desired color for Coal
                    break;
                case 'IPPS FOSSIL FUEL FO':
                    $category = 'FO';
                    $color = 'red'; // Set the desired color for FO
                    break;
                case 'IPPS FOSSIL FUEL RLNG':
                    $category = 'RLNG';
                    $color = 'blue'; // Set the desired color for RLNG
                    break;
                case 'NUCLEAR':
                    $category = 'Nuclear';
                    $color = 'blue'; // Set the desired color for RLNG
                    break;
                case 'HYDEL':
                    $category = 'Public';
                    $color = 'blue'; // Set the desired color for RLNG
                    break;
                case 'IPPS HYDEL HYDEL':
                    $category = 'Private';
                    $color = 'red'; // Set the desired color for RLNG
                    break;
                case 'SOLAR':
                    $category = 'Solar';
                    $color = 'yellow'; // Set the desired color for RLNG
                    break;
                case 'WIND':
                    $category = 'Wind';
                    $color = 'blue'; // Set the desired color for RLNG
                    break;
                case 'IPPS BAGASSE BAGASSE':
                    $category = 'Bagasse';
                    $color = 'green'; // Set the desired color for RLNG
                    break;
                default:
                    // If the subCategory doesn't match any of the expected values, skip this entry
                    continue 2; // Skip to the next iteration of the while loop
            }

            // Create or update the category entry in the associative array
            if (!isset($data[$category])) {
                $data[$category] = array(
                    'name' => $category,
                    'color' => $color,
                    'data' => array()
                );
            }

            // Add the energy value to the corresponding hour's sum
            if (!isset($hourlySums[$hour])) {
                $hourlySums[$hour] = 0;
            }
            $hourlySums[$hour] += $energyMWh;
        }
    }

    // Close the CSV file
    fclose($csvFile);

    // Convert hourly sums to the desired format
    foreach ($hourlySums as $hour => $sum) {
        foreach ($data as &$categoryData) {
            $categoryData['data'][] = [$hour . ':00', $sum];
        }
    }

    return $data;
}

function generateFinalDrillDown($startDate, $endDate)
{
    $final_drill_down = [];

    // Generate a list of dates between the start and end date
    $dateRange = [];
    $currentDate = strtotime($startDate);
    $endDate = strtotime($endDate);

    while ($currentDate <= $endDate) {
        $dateRange[] = date('Y-m-d', $currentDate);
        $currentDate = strtotime('+1 day', $currentDate);
    }

    foreach ($dateRange as $TargetDate) {
        // Define the categories for GENCOS
        $gencosCategories = ['GENCOS Gas', 'GENCOS Coal', 'GENCOS RLNG'];
        // Process data for GENCOS
        $gencosData = processData($gencosCategories, $TargetDate);

        // Define the categories for IPPS
        $ippsCategories = ['IPPS FOSSIL FUEL Gas', 'IPPS FOSSIL FUEL Coal', 'IPPS FOSSIL FUEL FO', 'IPPS FOSSIL FUEL RLNG'];
        // Process data for IPPS
        $ippsData = processData($ippsCategories, $TargetDate);

        // Define the categories for IPPS Gas
        $ippsGasCategories = ['IPPS FOSSIL FUEL Gas'];
        // Process data for IPPS Gas
        $ippsGasData = processData($ippsGasCategories, $TargetDate);

        // Define the categories for IPPS Coal
        $ippsCoalCategories = ['IPPS FOSSIL FUEL Coal'];
        // Process data for IPPS Coal
        $ippsCoalData = processData($ippsCoalCategories, $TargetDate);

        // Define the categories for IPPS FO
        $ippsFOCategories = ['IPPS FOSSIL FUEL FO'];
        // Process data for IPPS FO
        $ippsFOData = processData($ippsFOCategories, $TargetDate);

        // Define the categories for IPPS RLNG
        $ippsRLNGCategories = ['IPPS FOSSIL FUEL RLNG'];
        // Process data for IPPS RLNG
        $ippsRLNGData = processData($ippsRLNGCategories, $TargetDate);

        // Define the categories for Nuclear
        $nuclearCategories = ['NUCLEAR'];
        // Process data for Nuclear
        $nuclearData = processData($nuclearCategories, $TargetDate);

        // Define the categories for Public
        $publicCategories = ['HYDEL'];
        // Process data for Public
        $publicData = processData($publicCategories, $TargetDate);

        // Define the categories for Private
        $privateCategories = ['IPPS HYDEL HYDEL'];
        // Process data for Private
        $privateData = processData($privateCategories, $TargetDate);

        // Define the categories for Solar
        $solarCategories = ['SOLAR'];
        // Process data for Solar
        $solarData = processData($solarCategories, $TargetDate);

        // Define the categories for Wind
        $windCategories = ['WIND'];
        // Process data for Wind
        $windData = processData($windCategories, $TargetDate);

        // Define the categories for Bagasse
        $BagasseCategories = ['IPPS BAGASSE BAGASSE'];
        // Process data for Bagasse
        $BagasseData = processData($BagasseCategories, $TargetDate);


        // summing them up for making parent layer of the chart
        // // Access the "Private" and "Public" data and calculate sums
        // $privateData = $data["Private"]["data"];
        // $publicData = $data["Public"]["data"];
        // Initialize sum variables for private and public data
        $privateSum = 0;
        $publicSum = 0;
        $hydroSum = 0;
        $solarSum = 0;
        $windSum = 0;
        $bagasseSum = 0;
        $renewableSum = 0;
        $nuclearSum = 0;
        $ippsgasSum = 0;
        $ippscoalSum = 0;
        $ippsfoSum = 0;
        $ippsrlngSum = 0;
        $ippsSum = 0;
        $gencosgasSum = 0;
        $gencoscoalSum = 0;
        $gencosrlngSum = 0;
        $gencosSum = 0;
        $thermalSum = 0;
        // Iterate through the "data" arrays and sum the values
        //Hydro(public + private)
        foreach ($privateData["Private"]["data"] as $entry) {
            $privateSum += $entry[1];
        }

        foreach ($publicData["Public"]["data"] as $entry) {
            $publicSum += $entry[1];
        }
        $hydroSum = $privateSum + $publicSum;
        //Renewable(solar, wind, bagasse)
        foreach ($solarData["Solar"]["data"] as $entry) {
            $solarSum += $entry[1];
        }

        foreach ($windData["Wind"]["data"] as $entry) {
            $windSum += $entry[1];
        }

        foreach ($BagasseData["Bagasse"]["data"] as $entry) {
            $bagasseSum += $entry[1];
        }
        $renewableSum = $solarSum + $windSum + $bagasseSum;
        //Nuclear sum
        foreach ($nuclearData["Nuclear"]["data"] as $entry) {
            $nuclearSum += $entry[1];
        }

        //thermal 
        //ipps(Gas, Coal, Fo, RLNG)
        foreach ($ippsGasData["Gas"]["data"] as $entry) {
            $ippsgasSum += $entry[1];
        }
        foreach ($ippsCoalData["Coal"]["data"] as $entry) {
            $ippscoalSum += $entry[1];
        }
        foreach ($ippsFOData["FO"]["data"] as $entry) {
            $ippsfoSum += $entry[1];
        }
        foreach ($ippsRLNGData["RLNG"]["data"] as $entry) {
            $ippsrlngSum += $entry[1];
        }

        $ippsSum = $ippsrlngSum + $ippsgasSum + $ippscoalSum + $ippsfoSum;

        //gencos(gas, coal, f0)
        foreach ($gencosData["Gas"]["data"] as $entry) {
            $gencosgasSum += $entry[1];
        }
        foreach ($gencosData["Coal"]["data"] as $entry) {
            $gencoscoalSum += $entry[1];
        }
        foreach ($gencosData["RLNG"]["data"] as $entry) {
            $gencosrlngSum += $entry[1];
        }

        $gencosSum = $gencosrlngSum + $gencoscoalSum + $gencosgasSum;
        //thermal sum
        $thermalSum = $gencosSum + $ippsSum;
        // Combine the data into an associative array for each date
        $finalData = [
            "Hydro" => json_decode(json_encode(["Private" => $privateData["Private"], "Public" => $publicData["Public"]]), true),
            "Renewable" => json_decode(json_encode(["Solar" => $solarData["Solar"], "Wind" => $windData["Wind"], "Bagasse" => $BagasseData["Bagasse"]]), true),
            "IPPS" => json_decode(json_encode(["Gas" => $ippsGasData["Gas"], "Coal" => $ippsCoalData["Coal"], "FO" => $ippsFOData["FO"], "RLNG" => $ippsRLNGData["RLNG"]]), true),
            "GENCOS" => json_decode(json_encode($gencosData), true),
            "Nuclear" => json_decode(json_encode($nuclearData), true),
            "privateSum" => $privateSum,
            "publicSum" => $publicSum,
            "hydroSum" => $hydroSum,
            "nuclearSum" => $nuclearSum,
            "bagasseSum" => $bagasseSum,
            "windSum" => $windSum,
            "solarSum" => $solarSum,
            "renewableSum" => $renewableSum,
            "ippsrlngSum" => $ippsrlngSum,
            "ippsgasSum" => $ippsgasSum,
            "ippscoalSum" => $ippscoalSum,
            "ippsfoSum" => $ippsfoSum,
            "ippsSum" => $ippsSum,
            "gencosrlngSum" => $gencosrlngSum,
            "gencoscoalSum" => $gencoscoalSum,
            "gencosgasSum" => $gencosgasSum,
            "gencosSum" => $gencosSum,
            "thermalSum" => $thermalSum,


        ];

        // Add the final data for the current date to the final_drill_down array
        $final_drill_down[$TargetDate] = $finalData;
        // Add the data for DataParentLayerHydroHydro for the current date to $dataForParentOne
        $dataForParentOneHydro[$TargetDate] = [
            "name" => $TargetDate,
            "y" => $hydroSum,
            "drilldown" => true
        ];
        // Add the data for DataParentLayerRenewable for the current date to $dataForParentOne
        $dataForParentOneRenewable[$TargetDate] = [
            "name" => $TargetDate,
            "y" => $renewableSum,
            "drilldown" => true
        ];
        // Add the data for DataParentLayerNuclear for the current date to $dataForParentOne
        $dataForParentOneNuclear[$TargetDate] = [
            "name" => $TargetDate,
            "y" => $nuclearSum,
            "drilldown" => true
        ];
        // Add the data for DataParentLayerThermal for the current date to $dataForParentOne
        $dataForParentOneThermal[$TargetDate] = [
            "name" => $TargetDate,
            "y" => $thermalSum,
            "drilldown" => true
        ];
        // Add the data for DataParentLayerIPPS for the current date to $dataForParentOne
        $dataForParentOneIPPS[$TargetDate] = [
            "name" => $TargetDate,
            "y" => $ippsSum,
            "drilldown" => true
        ];
        // Add the data for DataParentLayerGENCOS for the current date to $dataForParentOne
        $dataForParentOneGENCOS[$TargetDate] = [
            "name" => $TargetDate,
            "y" => $gencosSum,
            "drilldown" => true
        ];
        // $final_drill_down["DataForParentOne"] = [
        //     "DataParentLayerHydro"  => array(
        //         "name" => $TargetDate,
        //         "y" => $hydroSum,
        //         "drilldown" => true
        //     ),
        //     // "DataParentLayerRenewable"  => array(
        //     //     "name" => $TargetDate,
        //     //     "y" => $renewableSum,
        //     //     "drilldown" => true
        //     // ),
        //     // "DataParentLayerNuclear"  => array(
        //     //     "name" => $TargetDate,
        //     //     "y" => $nuclearSum,
        //     //     "drilldown" => true
        //     // ),
        //     // "DataParentLayerThermal"  => array(
        //     //     "name" => $TargetDate,
        //     //     "y" => $thermalSum,
        //     //     "drilldown" => true
        //     // ),
        // ];
    }
    // Add the $dataForParentOne array to the final_drill_down array
    $final_drill_down["DataForParentOne"] = [
        "DataParentLayerHydro" => $dataForParentOneHydro,
        "DataParentLayerRenewable" => $dataForParentOneRenewable,
        "DataParentLayerNuclear" => $dataForParentOneNuclear,
        "DataParentLayerThermal" => $dataForParentOneThermal,
        "DataParentLayerIPPS" => $dataForParentOneIPPS,
        "DataParentLayerGENCOS" => $dataForParentOneGENCOS,
    ];
    // Convert the final associative array to JSON format
    $final_drill_down_JSON = json_encode($final_drill_down, JSON_PRETTY_PRINT);

    // Return the final JSON data
    return $final_drill_down_JSON;
}

// Example usage:
$startDatee = $startDate;
$endDatee = $endDate;
// $startDatee = '2022-03-02';
// $endDatee = '2022-03-05';
$final_drill_down_JSON = generateFinalDrillDown($startDatee, $endDatee);
// echo $final_drill_down_JSON;

// $TargetDate = '2022-03-02';
// // Define the categories and target date for GENCOS
// $gencosCategories = ['GENCOS Gas', 'GENCOS Coal', 'GENCOS RLNG'];

// // Process data for GENCOS
// $gencosData = processData($gencosCategories, $TargetDate);

// // Define the categories and target date for IPPS
// $ippsCategories = ['IPPS FOSSIL FUEL Gas', 'IPPS FOSSIL FUEL Coal', 'IPPS FOSSIL FUEL FO', 'IPPS FOSSIL FUEL RLNG'];
// // Process data for IPPS
// $ippsData = processData($ippsCategories, $TargetDate);

// // Define the categories and target date for IPPS
// $ippsGasCategories = ['IPPS FOSSIL FUEL Gas'];
// // Process data for IPPS
// $ippsGasData = processData($ippsGasCategories, $TargetDate);

// // Define the categories and target date for IPPS
// $ippsCoalCategories = ['IPPS FOSSIL FUEL Coal'];
// // Process data for IPPS
// $ippsCoalData = processData($ippsCoalCategories, $TargetDate);

// // Define the categories and target date for IPPS
// $ippsFOCategories = ['IPPS FOSSIL FUEL FO'];
// // Process data for IPPS
// $ippsFOData = processData($ippsFOCategories, $TargetDate);

// // Define the categories and target date for IPPS
// $ippsRLNGCategories = ['IPPS FOSSIL FUEL RLNG'];
// // Process data for IPPS
// $ippsRLNGData = processData($ippsRLNGCategories, $TargetDate);

// // Define the categories and target date for Nuclear
// $nuclearCategories = ['NUCLEAR'];
// // Process data for IPPS
// $nuclearData = processData($nuclearCategories, $TargetDate);


// // Define the categories and target date for Public
// $publicCategories = ['HYDEL'];
// // Process data for IPPS
// $publicData = processData($publicCategories, $TargetDate);


// // Define the categories and target date for Private
// $privateCategories = ['IPPS HYDEL HYDEL'];
// // Process data for IPPS
// $privateData = processData($privateCategories, $TargetDate);


// // Define the categories and target date for Solar
// $solarCategories = ['SOLAR'];
// // Process data for IPPS
// $solarData = processData($solarCategories, $TargetDate);


// // Define the categories and target date for Wind
// $windCategories = ['WIND'];
// // Process data for IPPS
// $windData = processData($windCategories, $TargetDate);


// // Define the categories and target date for Bagasse
// $BagasseCategories = ['IPPS BAGASSE BAGASSE'];
// // Process data for IPPS
// $BagasseData = processData($BagasseCategories, $TargetDate);


// // Capture the data in variables
// $gencos = json_encode($gencosData, JSON_PRETTY_PRINT);
// $ipps = json_encode($ippsData, JSON_PRETTY_PRINT);
// $nuclear = json_encode($nuclearData, JSON_PRETTY_PRINT);
// $private = json_encode($privateData, JSON_PRETTY_PRINT);
// $public = json_encode($publicData, JSON_PRETTY_PRINT);
// $solar = json_encode($solarData, JSON_PRETTY_PRINT);
// $wind = json_encode($windData, JSON_PRETTY_PRINT);
// $bagasse = json_encode($BagasseData, JSON_PRETTY_PRINT);
// $ippsGas = json_encode($ippsGasData, JSON_PRETTY_PRINT);
// $ippsCoal = json_encode($ippsCoalData, JSON_PRETTY_PRINT);
// $ippsFO = json_encode($ippsFOData, JSON_PRETTY_PRINT);
// $ippsRLNG = json_encode($ippsRLNGData, JSON_PRETTY_PRINT);
// echo $ippsGas;
// echo "<br>";
// echo "<br>";
// echo $ippsCoal;
// echo "<br>";
// echo "<br>";
// echo $ippsFO;
// echo "<br>";
// echo "<br>";
// echo $ippsRLNG;
// echo "<br>";
// echo "<br>";
// // Output each variable
// echo $gencos;
// echo "<br>";
// echo "<br>";
// echo $ipps;
// // echo "<br>";
// // echo "<br>";
// // echo $nuclear;
// // echo "<br>";
// // echo "<br>";
// // echo $private;
// // echo "<br>";
// // echo "<br>";
// // echo $public;
// // echo "<br>";
// // echo "<br>";
// // echo $solar;
// // echo "<br>";
// // echo "<br>";
// // echo $wind;
// // echo "<br>";
// // echo "<br>";
// // echo $bagasse;
// // echo "<br>";
// // echo "<br>";
// // echo trim($bagasse, '{}');
// // Combine the data into an associative array
// $Renewables = [
//     "Solar" => $solarData['Solar'],
//     "Wind" => $windData['Wind'],
//     "Bagasse" => $BagasseData['Bagasse']
// ];

// // Convert the array to JSON format if needed
// $RenewablesJSON = json_encode($Renewables, JSON_PRETTY_PRINT);

// // Output the JSON data
// echo 'RenewablesJSON';
// echo '<br>';
// echo $RenewablesJSON;
// // Combine the data into an associative array
// $Hydro = [
//     "Private" => $privateData['Private'],
//     "Public" => $publicData['Public']
// ];

// // Convert the array to JSON format if needed
// $HydroJSON = json_encode($Hydro, JSON_PRETTY_PRINT);
// echo "<br>";
// echo "<br>";
// // Combine the data into an associative array
// $IPPS = [
//     "Gas" => $ippsGasData['Gas'],
//     "Coal" => $ippsCoalData['Coal'],
//     "FO" => $ippsFOData['FO'],
//     "RLNG" => $ippsRLNGData['RLNG']
// ];

// // Convert the array to JSON format if needed
// $ippsJSON = json_encode($IPPS, JSON_PRETTY_PRINT);
// echo "<br>";
// echo "<br>";
// // Output the JSON data
// // echo $HydroJSON;
// // Create the final associative array with the specified structure
// $final_drill_down = [
//     $TargetDate => [
//         "Hydro" => json_decode($HydroJSON, true),
//         "Renewable" => json_decode($RenewablesJSON, true),
//         "IPPS" => json_decode($ippsJSON, true),
//         "GENCOS" => json_decode($gencos, true),
//         "Nuclear" => json_decode($nuclear, true)
//     ]
// ];

// // Convert the final associative array to JSON format
// $final_drill_down_JSON = json_encode($final_drill_down, JSON_PRETTY_PRINT);

// // Output the result
// echo $final_drill_down_JSON;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HTML 5 Boilerplate</title>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <!-- Custom CSS to style data labels -->
    <style>
        .highcharts-data-label text {
            fill: rgb(185, 122, 202) !important;
            /* Set text color to white */
            text-decoration: none !important;
            /* Remove underline */
        }
    </style>
</head>

<body>
    <figure class="highcharts-figure">
        <div class="row">
            <form id="dateRangeForm">
                <label for="startDate">Start Date:</label>
                <input type="date" id="startDate" name="startDate" min="<?php echo $startDate; ?>" max="<?php echo $endDate; ?>">
                <label for="endDate">End Date:</label>
                <input type="date" id="endDate" name="endDate" min="<?php echo $startDate; ?>" max="<?php echo $endDate; ?>">


                <button type="submit">Apply Date Range</button>
            </form>
        </div>
        <div id="container"></div>
    </figure>


    <script>
        var javascriptArray = <?php echo $final_drill_down_JSON; ?>;
        // Access DataParentLayerHydro object
        var dataParentLayerHydro = javascriptArray.DataForParentOne.DataParentLayerHydro;
        var dataParentLayerNuclear = javascriptArray.DataForParentOne.DataParentLayerNuclear;
        var dataParentLayerThermal = javascriptArray.DataForParentOne.DataParentLayerThermal;
        var dataParentLayerRenewable = javascriptArray.DataForParentOne.DataParentLayerRenewable;
        var dataParentLayerIPPS = javascriptArray.DataForParentOne.DataParentLayerIPPS;
        var dataParentLayerGENCOS = javascriptArray.DataForParentOne.DataParentLayerGENCOS;
        // Initialize an array to store the desired output
        var desiredOutputHydro = [];
        var desiredOutputRenewable = [];
        var desiredOutputNuclear = [];
        var desiredOutputThermal = [];
        var desiredOutputIPPS = [];
        var desiredOutputGENCOS = [];
        // Loop through the data and push each entry to the desired output array
        for (var date in dataParentLayerHydro) {
            if (dataParentLayerHydro.hasOwnProperty(date)) {
                desiredOutputHydro.push(dataParentLayerHydro[date]);
            }
        }
        // Loop through the data and push each entry to the desired output array
        for (var date in dataParentLayerRenewable) {
            if (dataParentLayerRenewable.hasOwnProperty(date)) {
                desiredOutputRenewable.push(dataParentLayerRenewable[date]);
            }
        }
        // Loop through the data and push each entry to the desired output array
        for (var date in dataParentLayerNuclear) {
            if (dataParentLayerNuclear.hasOwnProperty(date)) {
                desiredOutputNuclear.push(dataParentLayerNuclear[date]);
            }
        }
        // Loop through the data and push each entry to the desired output array
        for (var date in dataParentLayerThermal) {
            if (dataParentLayerThermal.hasOwnProperty(date)) {
                desiredOutputThermal.push(dataParentLayerThermal[date]);
            }
        }
        // Loop through the data and push each entry to the desired output array
        for (var date in dataParentLayerGENCOS) {
            if (dataParentLayerGENCOS.hasOwnProperty(date)) {
                desiredOutputGENCOS.push(dataParentLayerGENCOS[date]);
            }
        }
        // Loop through the data and push each entry to the desired output array
        for (var date in dataParentLayerIPPS) {
            if (dataParentLayerIPPS.hasOwnProperty(date)) {
                desiredOutputIPPS.push(dataParentLayerIPPS[date]);
            }
        }
        // // Now, desiredOutput contains the desired data
        // console.log(desiredOutputHydro);
        // console.log(desiredOutputHydro);
        // console.log(desiredOutputHydro);
        // console.log(desiredOutputHydro);
        // console.log(desiredOutputHydro);

        Highcharts.Tick.prototype.drillable = function() {};
        Highcharts.chart('container', {
            chart: {
                type: 'column',

                events: {
                    drilldown: function(e) {
                        if (!e.seriesOptions) {
                            // if (e.point.name == "2022-03-02") {
                            //     alert(e.point.name);
                            // }
                            var specificDate = javascriptArray[e.point.name]
                            console.log(specificDate);
                            console.log(specificDate.GENCOS);
                            console.log(specificDate.IPPS);
                            console.log(specificDate.Nuclear);
                            var chart = this,
                                Hydro = specificDate.Hydro,

                                Renewables = specificDate.Renewable,

                                Thermal = {

                                    'IPPS': {
                                        name: 'IPPS',
                                        color: 'Brown',
                                        data: desiredOutputIPPS
                                        // [{
                                        //     name: "2022-03-01",
                                        //     y: 1,
                                        //     drilldown: true
                                        // }, {
                                        //     name: "2022-03-02",
                                        //     y: 2,
                                        //     drilldown: true
                                        // }, {
                                        //     name: "2022-03-03",
                                        //     y: 3,
                                        //     drilldown: true
                                        // }, {
                                        //     name: "2022-03-04",
                                        //     y: 4,
                                        //     drilldown: true
                                        // }]
                                        ,
                                        stack: "move"

                                    },


                                    'GENCOS': {

                                        name: 'GENCOS',
                                        color: 'DarkGrey',
                                        data: desiredOutputGENCOS
                                        // [{
                                        //     name: "2022-03-01",
                                        //     y: 1,
                                        //     drilldown: true
                                        // }, {
                                        //     name: "2022-03-02",
                                        //     y: 2,
                                        //     drilldown: true
                                        // }, {
                                        //     name: "2022-03-03",
                                        //     y: 3,
                                        //     drilldown: true
                                        // }, {
                                        //     name: "2022-03-04",
                                        //     y: 4,
                                        //     drilldown: true
                                        // }]
                                        ,
                                        stack: "move"

                                    }

                                },


                                IPPS = specificDate.IPPS,


                                Gencos = specificDate.GENCOS,



                                Nuclear = specificDate.Nuclear

                            if (e.point.name == "2022-03-02") {
                                console.log(e.point.name)
                                console.log(e); // Log the entire e object to the console
                            } else {
                                console.log(e.point.name + '_' + 'ipps')
                            }


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

                            } else if (e.point.color == "yellow") {
                                chart.addSingleSeriesAsDrilldown(e.point, Nuclear.Nuclear);

                            }


                            if (e.point.color == "Brown") {
                                chart.addSingleSeriesAsDrilldown(e.point, IPPS.Gas);
                                chart.addSingleSeriesAsDrilldown(e.point, IPPS.Coal);
                                chart.addSingleSeriesAsDrilldown(e.point, IPPS.RLNG);
                                chart.addSingleSeriesAsDrilldown(e.point, IPPS.FO);
                            } else if (e.point.color == "DarkGrey") {
                                chart.addSingleSeriesAsDrilldown(e.point, Gencos.Gas);
                                chart.addSingleSeriesAsDrilldown(e.point, Gencos.RLNG);
                                chart.addSingleSeriesAsDrilldown(e.point, Gencos.Coal);
                            }


                            chart.applyDrilldown();

                        }
                    }
                }
            },


            xAxis: {

                type: 'category'
            },
            tooltip: {
                enabled: true
            },

            plotOptions: {
                series: {

                    stacking: 'normal'
                }
            },

            series: [{
                    color: 'blue',
                    name: "Hydro",
                    data: desiredOutputHydro
                        //     [
                        //     {
                        //         name: "2022-03-01",
                        //         y: 1,
                        //         drilldown: true
                        //     }, {
                        //         name: "2022-03-02",
                        //         y: 1,
                        //         drilldown: true
                        //     }, {
                        //         name: "2022-03-03",
                        //         y: 1,
                        //         drilldown: true
                        //     }, {
                        //         name: "2022-03-04",
                        //         y: 2,
                        //         drilldown: true
                        //     }, {
                        //         name: "2022-03-05",
                        //         y: 3,
                        //         drilldown: true
                        //     }, {
                        //         name: "2022-03-06",
                        //         y: 4,
                        //         drilldown: true
                        //     }, {
                        //         name: "2022-03-07",
                        //         y: 2,
                        //         drilldown: true
                        //     }, {
                        //         name: "2022-03-08",
                        //         y: 3,
                        //         drilldown: true
                        //     }, {
                        //         name: "2022-03-09",
                        //         y: 4,
                        //         drilldown: true
                        //     }, {
                        //         name: "2022-03-10",
                        //         y: 2,
                        //         drilldown: true
                        //     }, {
                        //         name: "2022-03-11",
                        //         y: 3,
                        //         drilldown: true
                        //     }, {
                        //         name: "2022-03-12",
                        //         y: 4,
                        //         drilldown: true
                        //     }, {
                        //         name: "2022-03-13",
                        //         y: 2,
                        //         drilldown: true
                        //     }, {
                        //         name: "2022-03-14",
                        //         y: 3,
                        //         drilldown: true
                        //     }, {
                        //         name: "2022-03-15",
                        //         y: 4,
                        //         drilldown: true
                        //     }, {
                        //         name: "2022-03-16",
                        //         y: 2,
                        //         drilldown: true
                        //     }, {
                        //         name: "2022-03-17",
                        //         y: 3,
                        //         drilldown: true
                        //     }, {
                        //         name: "2022-03-18",
                        //         y: 4,
                        //         drilldown: true
                        //     }, {
                        //         name: "2022-03-19",
                        //         y: 2,
                        //         drilldown: true
                        //     }, {
                        //         name: "2022-03-20",
                        //         y: 3,
                        //         drilldown: true
                        //     }, {
                        //         name: "2022-03-21",
                        //         y: 4,
                        //         drilldown: true
                        //     }, {
                        //         name: "2022-03-22",
                        //         y: 2,
                        //         drilldown: true
                        //     }, {
                        //         name: "2022-03-23",
                        //         y: 3,
                        //         drilldown: true
                        //     }, {
                        //         name: "2022-03-24",
                        //         y: 4,
                        //         drilldown: true
                        //     }, {
                        //         name: "2022-03-25",
                        //         y: 2,
                        //         drilldown: true
                        //     }, {
                        //         name: "2022-03-26",
                        //         y: 3,
                        //         drilldown: true
                        //     }, {
                        //         name: "2022-03-27",
                        //         y: 4,
                        //         drilldown: true
                        //     }, {
                        //         name: "2022-03-28",
                        //         y: 4,
                        //         drilldown: true
                        //     }, {
                        //         name: "2022-03-29",
                        //         y: 2,
                        //         drilldown: true
                        //     }, {
                        //         name: "2022-03-30",
                        //         y: 3,
                        //         drilldown: true
                        //     }, {
                        //         name: "2022-03-31",
                        //         y: 4,
                        //         drilldown: true
                        //     }
                        // ]
                        ,
                    stack: "move",
                    // drilldown: true
                },

                {
                    color: 'green',
                    name: "Renewables",
                    data: desiredOutputRenewable
                //     [
                //     {
                //         name: "2022-03-01",
                //         y: 1,
                //         drilldown: true
                //     }, {
                //         name: "2022-03-02",
                //         y: 1,
                //         drilldown: true
                //     }, {
                //         name: "2022-03-03",
                //         y: 1,
                //         drilldown: true
                //     }, {
                //         name: "2022-03-04",
                //         y: 2,
                //         drilldown: true
                //     }, {
                //         name: "2022-03-05",
                //         y: 3,
                //         drilldown: true
                //     }, {
                //         name: "2022-03-06",
                //         y: 4,
                //         drilldown: true
                //     }, {
                //         name: "2022-03-07",
                //         y: 2,
                //         drilldown: true
                //     }, {
                //         name: "2022-03-08",
                //         y: 3,
                //         drilldown: true
                //     }, {
                //         name: "2022-03-09",
                //         y: 4,
                //         drilldown: true
                //     }, {
                //         name: "2022-03-10",
                //         y: 2,
                //         drilldown: true
                //     }, {
                //         name: "2022-03-11",
                //         y: 3,
                //         drilldown: true
                //     }, {
                //         name: "2022-03-12",
                //         y: 4,
                //         drilldown: true
                //     }, {
                //         name: "2022-03-13",
                //         y: 2,
                //         drilldown: true
                //     }, {
                //         name: "2022-03-14",
                //         y: 3,
                //         drilldown: true
                //     }, {
                //         name: "2022-03-15",
                //         y: 4,
                //         drilldown: true
                //     }, {
                //         name: "2022-03-16",
                //         y: 2,
                //         drilldown: true
                //     }, {
                //         name: "2022-03-17",
                //         y: 3,
                //         drilldown: true
                //     }, {
                //         name: "2022-03-18",
                //         y: 4,
                //         drilldown: true
                //     }, {
                //         name: "2022-03-19",
                //         y: 2,
                //         drilldown: true
                //     }, {
                //         name: "2022-03-20",
                //         y: 3,
                //         drilldown: true
                //     }, {
                //         name: "2022-03-21",
                //         y: 4,
                //         drilldown: true
                //     }, {
                //         name: "2022-03-22",
                //         y: 2,
                //         drilldown: true
                //     }, {
                //         name: "2022-03-23",
                //         y: 3,
                //         drilldown: true
                //     }, {
                //         name: "2022-03-24",
                //         y: 4,
                //         drilldown: true
                //     }, {
                //         name: "2022-03-25",
                //         y: 2,
                //         drilldown: true
                //     }, {
                //         name: "2022-03-26",
                //         y: 3,
                //         drilldown: true
                //     }, {
                //         name: "2022-03-27",
                //         y: 4,
                //         drilldown: true
                //     }, {
                //         name: "2022-03-28",
                //         y: 4,
                //         drilldown: true
                //     }, {
                //         name: "2022-03-29",
                //         y: 2,
                //         drilldown: true
                //     }, {
                //         name: "2022-03-30",
                //         y: 3,
                //         drilldown: true
                //     }, {
                //         name: "2022-03-31",
                //         y: 4,
                //         drilldown: true
                //     }
                // ]
                ,
                    stack: "move",
                    // drilldown: true
                },

                {
                    color: 'red',
                    name: "Thermal",
                    data: desiredOutputThermal
                    // [
                    // {
                    //     name: "2022-03-01",
                    //     y: 1,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-02",
                    //     y: 1,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-03",
                    //     y: 1,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-04",
                    //     y: 2,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-05",
                    //     y: 3,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-06",
                    //     y: 4,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-07",
                    //     y: 2,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-08",
                    //     y: 3,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-09",
                    //     y: 4,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-10",
                    //     y: 2,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-11",
                    //     y: 3,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-12",
                    //     y: 4,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-13",
                    //     y: 2,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-14",
                    //     y: 3,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-15",
                    //     y: 4,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-16",
                    //     y: 2,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-17",
                    //     y: 3,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-18",
                    //     y: 4,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-19",
                    //     y: 2,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-20",
                    //     y: 3,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-21",
                    //     y: 4,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-22",
                    //     y: 2,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-23",
                    //     y: 3,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-24",
                    //     y: 4,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-25",
                    //     y: 2,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-26",
                    //     y: 3,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-27",
                    //     y: 4,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-28",
                    //     y: 4,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-29",
                    //     y: 2,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-30",
                    //     y: 3,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-31",
                    //     y: 4,
                    //     drilldown: true
                    // }]
                    ,
                    stack: "move",
                    drilldown: true
                },

                {

                    color: 'yellow',
                    name: "Nuclear",
                    data: desiredOutputNuclear
                    // [
                    // {
                    //     name: "2022-03-01",
                    //     y: 1,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-02",
                    //     y: 1,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-03",
                    //     y: 1,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-04",
                    //     y: 2,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-05",
                    //     y: 3,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-06",
                    //     y: 4,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-07",
                    //     y: 2,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-08",
                    //     y: 3,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-09",
                    //     y: 4,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-10",
                    //     y: 2,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-11",
                    //     y: 3,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-12",
                    //     y: 4,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-13",
                    //     y: 2,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-14",
                    //     y: 3,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-15",
                    //     y: 4,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-16",
                    //     y: 2,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-17",
                    //     y: 3,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-18",
                    //     y: 4,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-19",
                    //     y: 2,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-20",
                    //     y: 3,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-21",
                    //     y: 4,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-22",
                    //     y: 2,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-23",
                    //     y: 3,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-24",
                    //     y: 4,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-25",
                    //     y: 2,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-26",
                    //     y: 3,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-27",
                    //     y: 4,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-28",
                    //     y: 4,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-29",
                    //     y: 2,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-30",
                    //     y: 3,
                    //     drilldown: true
                    // }, {
                    //     name: "2022-03-31",
                    //     y: 4,
                    //     drilldown: true
                    // }]
                    ,
                    stack: "move"
                    // drilldown: true
                }
            ]

        });
    </script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.js"
    integrity="sha256-tA8y0XqiwnpwmOIl3SGAcFl2RvxHjA8qp0+1uCGmRmg=" crossorigin="anonymous"></script> -->

</body>

</html>