<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "power";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$csvFilePath = "C:/Users/python/Documents/projR/processed_mw_sheets/collective_data.csv"; // Provide the actual path to your CSV file

$chunkSize = 100; // Number of rows to process in one batch

// Read the CSV file
if (($handle = fopen($csvFilePath, "r")) !== false) {
    // Skip the header row
    fgetcsv($handle);

    // Prepare the SQL statement
    $sql = "INSERT INTO `mw_new` (`Time`, `Name`, `Energy_MWh`, `category`, `sub_categories_by_fuel`) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("ssdss", $formattedTime, $name, $energy, $category,  $subCategory);

    // Read data from CSV and insert into the database
    $batchCount = 0;
    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
        $time = $data[0]; // Original time from CSV
        $name = $data[1];
        $energy = floatval($data[2]);
        $category = $data[3];
        $subCategory = $data[4]; // New sub-category column value

        // Format the time value to match the expected format "Y-m-d H:i:s"
        $formattedTime = date("Y-m-d H:i:s", strtotime($time));

        $stmt->execute();

        $batchCount++;
        if ($batchCount % $chunkSize === 0) {
            // Commit the current batch and start a new transaction
            $conn->commit();
            $conn->begin_transaction();
        }
    }

    // Commit any remaining batch
    $conn->commit();

    fclose($handle);

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
// After successful data upload
// header("Location: http://localhost/latest_dash/html/iconbar/filesuploader.php?success=1");
// header("Location: http://localhost/latest_dash/html/iconbar/index.php", true, 301);
// header("Location: http://localhost/latest_dash/html/iconbar/index.php");
// exit();
