<?php
// Read the max_min_avg.csv file
$file = fopen('C:/xampp/htdocs/latest_Dash/html/iconbar/include/csv/max_min_avg.csv', 'r');

// Initialize arrays to store unique dates and names
$datesMaxMinAvg = [];
$namesMaxMinAvg = [];
$recordsMaxMinAvg = []; // Store all records

// Skip the header row
fgetcsv($file);

while (($row = fgetcsv($file)) !== false) {
    $dateMaxMinAvg = date('n/j/Y', strtotime($row[0])); // Assuming the date format is "m/d/Y"
    $nameMaxMinAvg = $row[1];

    // Add the date to the datesMaxMinAvg array if it's not already present
    if (!in_array($dateMaxMinAvg, $datesMaxMinAvg)) {
        $datesMaxMinAvg[] = $dateMaxMinAvg;
    }

    // Add the name to the namesMaxMinAvg array for the corresponding date
    if (!isset($namesMaxMinAvg[$dateMaxMinAvg])) {
        $namesMaxMinAvg[$dateMaxMinAvg] = [];
    }

    // Add the name to the namesMaxMinAvg array if it's not already present
    if (!in_array($nameMaxMinAvg, $namesMaxMinAvg[$dateMaxMinAvg])) {
        $namesMaxMinAvg[$dateMaxMinAvg][] = $nameMaxMinAvg;
    }

    // Store the record
    $recordsMaxMinAvg[$dateMaxMinAvg][$nameMaxMinAvg][] = $row;
}

// Close the max_min_avg.csv file
fclose($file);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dropdown Example</title>
</head>

<body>
    <label for="dateSelectMaxMinAvg">Select Date:</label>
    <select id="dateSelectMaxMinAvg">
        <option value="">Select a Date</option>
        <?php foreach ($datesMaxMinAvg as $dateMaxMinAvg) : ?>
            <option value="<?php echo $dateMaxMinAvg; ?>"><?php echo $dateMaxMinAvg; ?></option>
        <?php endforeach; ?>
    </select>

    <label for="nameSelectMaxMinAvg">Select Name:</label>
    <select id="nameSelectMaxMinAvg" disabled>
        <option value="">Select a Name</option>
    </select>

    <table id="recordTableMaxMinAvg" style="display: none;">
        <thead>
            <tr>
                <th>Name</th>
                <th>Time Range One</th>
                <th>Max 1</th>
                <th>Min 1</th>
                <th>Average</th>
                <th>Time Range Two</th>
                <th>Max 2</th>
                <th>Min 2</th>
                <th>Time Range Three</th>
                <th>Max 3</th>
                <th>Min 3</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <script>
        // Get references to the dropdowns and table
        var dateSelectMaxMinAvg = document.getElementById('dateSelectMaxMinAvg');
        var nameSelectMaxMinAvg = document.getElementById('nameSelectMaxMinAvg');
        var recordTableMaxMinAvg = document.getElementById('recordTableMaxMinAvg');

        // Function to populate the name dropdown based on the selected date
        function populateNameDropdown(selectedDate) {
            // Clear previous options
            nameSelectMaxMinAvg.innerHTML = '<option value="">Select a Name</option>';

            // Populate the name dropdown with names for the selected date
            <?php foreach ($datesMaxMinAvg as $dateMaxMinAvg) : ?>
                <?php if (isset($namesMaxMinAvg[$dateMaxMinAvg])) : ?>
                    if (selectedDate === '<?php echo $dateMaxMinAvg; ?>') {
                        <?php foreach ($namesMaxMinAvg[$dateMaxMinAvg] as $nameMaxMinAvg) : ?>
                            var option = document.createElement('option');
                            option.value = '<?php echo $nameMaxMinAvg; ?>';
                            option.text = '<?php echo $nameMaxMinAvg; ?>';
                            nameSelectMaxMinAvg.appendChild(option);
                        <?php endforeach; ?>
                        nameSelectMaxMinAvg.removeAttribute('disabled');
                    }
                <?php endif; ?>
            <?php endforeach; ?>
        }

        // Function to display records for a selected date and name
        function displayRecords(selectedDate, selectedName) {
            // Clear previous table content
            while (recordTableMaxMinAvg.tBodies[0].hasChildNodes()) {
                recordTableMaxMinAvg.tBodies[0].removeChild(recordTableMaxMinAvg.tBodies[0].lastChild);
            }

            // Display the table with records for the selected date and name
            <?php if (!empty($recordsMaxMinAvg)) : ?>
                var recordsMaxMinAvg = <?php echo json_encode($recordsMaxMinAvg); ?>;
                if (selectedDate in recordsMaxMinAvg && selectedName in recordsMaxMinAvg[selectedDate]) {
                    var selectedRecordsMaxMinAvg = recordsMaxMinAvg[selectedDate][selectedName];
                    selectedRecordsMaxMinAvg.forEach(function(record) {
                        var row = recordTableMaxMinAvg.tBodies[0].insertRow();
                        row.insertCell(0).textContent = record[1]; // Name
                        row.insertCell(1).textContent = record[2]; // Time Range One
                        row.insertCell(2).textContent = record[3]; // Max 1
                        row.insertCell(3).textContent = record[4]; // Min 1
                        row.insertCell(4).textContent = record[5]; // Average
                        row.insertCell(5).textContent = record[6]; // Time Range Two
                        row.insertCell(6).textContent = record[7]; // Max 2
                        row.insertCell(7).textContent = record[8]; // Min 2
                        row.insertCell(8).textContent = record[9]; // Time Range Three
                        row.insertCell(9).textContent = record[10]; // Max 3
                        row.insertCell(10).textContent = record[11]; // Min 3
                    });
                    recordTableMaxMinAvg.style.display = 'table';
                }
            <?php endif; ?>
        }

        // Event listener for date selection
        dateSelectMaxMinAvg.addEventListener('change', function() {
            // Get the selected date
            var selectedDateMaxMinAvg = dateSelectMaxMinAvg.value;

            // Populate the name dropdown based on the selected date
            populateNameDropdown(selectedDateMaxMinAvg);

            // Select the first name for the selected date
            if (selectedDateMaxMinAvg in namesMaxMinAvg && namesMaxMinAvg[selectedDateMaxMinAvg].length > 0) {
                nameSelectMaxMinAvg.value = namesMaxMinAvg[selectedDateMaxMinAvg][0];
            }

            // Display records for the selected date and name
            displayRecords(selectedDateMaxMinAvg, nameSelectMaxMinAvg.value);
        });

        // Event listener for name selection
        nameSelectMaxMinAvg.addEventListener('change', function() {
            // Get the selected date and name
            var selectedDateMaxMinAvg = dateSelectMaxMinAvg.value;
            var selectedNameMaxMinAvg = nameSelectMaxMinAvg.value;

            // Display records for the selected date and name
            displayRecords(selectedDateMaxMinAvg, selectedNameMaxMinAvg);
        });

        // Set default values when the page loads
        var defaultSelectedDateMaxMinAvg = dateSelectMaxMinAvg.options[1].value; // Assuming the first date is at index 1
        var defaultSelectedNameMaxMinAvg = '<?php echo isset($namesMaxMinAvg[$datesMaxMinAvg[0]]) ? $namesMaxMinAvg[$datesMaxMinAvg[0]][0] : ''; ?>'; // Assuming the first name for the first date is at index 0
        dateSelectMaxMinAvg.value = defaultSelectedDateMaxMinAvg;
        populateNameDropdown(defaultSelectedDateMaxMinAvg);
        nameSelectMaxMinAvg.value = defaultSelectedNameMaxMinAvg;
        displayRecords(defaultSelectedDateMaxMinAvg, defaultSelectedNameMaxMinAvg);
    </script>

</body>

</html