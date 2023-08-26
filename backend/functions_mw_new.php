<?php
function getDatabaseConnectionNow()
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
$conn = getDatabaseConnectionNow();
$totalEnergy = 0;
// Mapping of category names to their corresponding classes
$categoryClasses = array(
"HYDRO" => "text-info",
"RENEWABLE" => "text-success",
"NUCLEAR" => "text-danger",
"THERMAL" => "text-warning"
);
for ($i = 0; $i < $numSubCategories; $i++) { $sql=$subCategoryQueries[$i]; $result=$conn->query($sql);
    $row = $result->fetch_assoc();
    $subCategoryEnergy = $row["TotalEnergy"];
    $totalEnergy += (int) $subCategoryEnergy;
    }
    // if category is thermal, its mean its last card, so don't add margin to the right
    echo '<div class="card ' . ($categoryName != " THERMAL" ? 'mr-3' : '' ) . '">
        <div class="card-body text-center">
            <h4 class="text-center ' . $categoryClasses[$categoryName] . '">' . $categoryName . '</h4>
            <h2>' . $totalEnergy . '</h2>
        <div class="row p-t-10 p-b-10">
            <div class="col text-center align-self-center">
                <div data-label="20%" class="css-bar m-b-0 css-bar-primary css-bar-20"><i class="display-6 ' . $iconClass . '"></i></div>
            </div>
        </div>' ; echo '<div class="row">' ; for ($i=0; $i < $numSubCategories; $i++) { $sql=$subCategoryQueries[$i]; $result=$conn->query($sql);
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