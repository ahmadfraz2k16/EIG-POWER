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
// fetch all data to show in bootstrap table
function fetchPowerData($page = 1, $perPage = 20)
{
    $conn = getDatabaseConnection();
    $offset = ($page - 1) * $perPage;

    $query = "SELECT * FROM mw LIMIT ?, ?";
    $statement = $conn->prepare($query);
    $statement->bind_param("ii", $offset, $perPage);
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

// // FUNCTION WITH SEARCH, DATE FILTER AND PAGINATION TOO
// function fetchPowerData($page = 1, $perPage = 20, $search = '', $fromDate = '', $toDate = '')
// {
//     $conn = getDatabaseConnection();
//     $offset = ($page - 1) * $perPage;

//     // Prepare the basic query
//     $query = "SELECT * FROM mw";

//     // Add search criteria if provided
//     if (!empty($search)) {
//         $query .= " WHERE Name LIKE ?";
//     }

//     // Add date range criteria if provided
//     if (!empty($fromDate) && !empty($toDate)) {
//         $query .= empty($search) ? " WHERE" : " AND";
//         $query .= " Time BETWEEN ? AND ?";
//     }

//     // Add limit and offset for pagination
//     $query .= " LIMIT ? OFFSET ?";

//     $statement = $conn->prepare($query);

//     // Bind parameters
//     if (!empty($search)) {
//         $searchParam = '%' . $search . '%';
//         $statement->bind_param("ssii", $searchParam, $searchParam, $offset, $perPage);
//     } else {
//         $statement->bind_param("ii", $offset, $perPage);
//     }

//     if (!empty($fromDate) && !empty($toDate)) {
//         $statement->bind_param("ss", $fromDate, $toDate);
//     }

//     $statement->execute();

//     $result = $statement->get_result();

//     $data = array();
//     while ($row = $result->fetch_assoc()) {
//         $data[] = $row;
//     }

//     $statement->close();
//     $conn->close();

//     return $data;
// }

// function fetchPowerData($limit = 10)
// {
//     $conn = getDatabaseConnection();

//     $query = "SELECT * FROM mw LIMIT ?";
//     $statement = $conn->prepare($query);
//     $statement->bind_param("i", $limit);
//     $statement->execute();

//     $result = $statement->get_result();

//     $data = array();
//     while ($row = $result->fetch_assoc()) {
//         $data[] = $row;
//     }

//     $statement->close();
//     $conn->close();

//     return $data;
// }
// var_dump(fetchPowerData(10))

// # daily production version 2
// // In functions.php
// function getPerDayProductionData()
// {
//     $conn = getDatabaseConnection();

//     $sql = "SELECT category, DATE(Time) AS day, SUM(Energy_MWh) AS total_energy FROM mw GROUP BY category, DATE(Time)";
//     $result = $conn->query($sql);

//     $data = array();

//     if ($result->num_rows > 0) {
//         while ($row = $result->fetch_assoc()) {
//             $category = $row["category"];
//             $day = $row["day"];
//             $totalEnergy = $row["total_energy"];

//             if (!isset($data[$category])) {
//                 $data[$category] = array();
//             }

//             $data[$category][$day] = $totalEnergy;
//         }
//     }

//     $conn->close();

//     return $data;
// }

// # daily production version 1
// function getCategoryDailyProductionData2()
// {
//     $conn = getDatabaseConnection();

//     $sql = "SELECT Date(Time) AS production_date, category, SUM(Energy_MWh) AS total_energy FROM mw GROUP BY production_date, category";
//     $result = $conn->query($sql);

//     $data = array();

//     if ($result->num_rows > 0) {
//         while ($row = $result->fetch_assoc()) {
//             $data[] = $row;
//         }
//     }

//     $conn->close();

//     return $data;
// }
