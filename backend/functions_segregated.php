<?php
function getDatabaseConnectionV2()
{
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

function updateDatabaseWithCSV($csvFilePath, $chunkSize = 100) {
    // Create connection
    $conn = getDatabaseConnectionV2();

    // Get the list of existing records
    $existingRecords = array();
    $existingQuery = "SELECT `Time`, `Name`, `category`, `Energy_MWh`, `sub_categories_by_fuel` FROM `mw_new`";
    $existingResult = $conn->query($existingQuery);
    if ($existingResult) {
        while ($row = $existingResult->fetch_assoc()) {
            $existingRecords[] = $row;
        }
        $existingResult->free_result();
    }

    // Read the CSV file
    if (($handle = fopen($csvFilePath, "r")) !== false) {
        // Skip the header row
        fgetcsv($handle);

        // ... (rest of your code)

        // Prepare the SQL statement
        $sql = "INSERT INTO `mw_new` (`Time`, `Name`, `category`, `Energy_MWh`, `sub_categories_by_fuel`) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("sssds", $formattedTime, $name, $category, $energy, $subCategory);

        // Read data from CSV and insert into the database
        $batchCount = 0;
        $newRecordsCount = 0;
        $batchValues = array(); // To hold values for batch insertion
        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            $time = $data[0]; // Original time from CSV
            $name = $data[1];
            $category = $data[2];
            $energy = floatval($data[3]);
            $subCategory = isset($data[4]) ? $data[4] : null; // Handle potential missing data

            // Format the time value to match the expected format "Y-m-d H:i:s"
            $formattedTime = date("Y-m-d H:i:s",
                strtotime($time)
            );

            // Check if the record already exists
            $recordExists = false;
            foreach ($existingRecords as $existingRecord) {
                if ($existingRecord['Time'] === $formattedTime && $existingRecord['Name'] === $name && $existingRecord['category'] === $category) {
                    $recordExists = true;
                    break;
                }
            }

            if (!$recordExists) {
                // Add values to the batch
                $batchValues[] = array($formattedTime, $name, $category, $energy, $subCategory);
                $newRecordsCount++;
            }

            $batchCount++;

            // Insert the batch if batch size is reached
            if ($batchCount % $chunkSize === 0 || feof($handle)
            ) {
                // Insert the batch
                if (!empty($batchValues)) {
                    foreach ($batchValues as $values) {
                        $stmt->bind_param("sssds", ...$values);
                        $stmt->execute();
                    }
                    $batchValues = array();
                }
                // Commit the current batch and start a new transaction
                $conn->commit();
                $conn->begin_transaction();
            }
        }

        // Commit any remaining batch
        $conn->commit();

// ... (rest of your code)


        fclose($handle);

        // Close the prepared statement
        $stmt->close();

        if ($newRecordsCount > 0) {
            echo "Successfully added $newRecordsCount new records to the database.";
        } else {
            echo "Database is already up to date.";
        }
    }

    // Close the database connection
    $conn->close();
}

// $csvFilePath = "C:/xampp/htdocs/latest_Dash/worksheets/collective_data.csv";
$csvFilePath = "C:/Users/python/Documents/projR/processed_mw_sheets/collective_data.csv";
updateDatabaseWithCSV($csvFilePath);
?>

