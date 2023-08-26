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
