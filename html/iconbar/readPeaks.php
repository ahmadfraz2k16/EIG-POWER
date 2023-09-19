<?php
// Read the CSV file
$file = fopen('C:/xampp/htdocs/latest_Dash/html/iconbar/include/csv/peakhours.csv', 'r');

// Initialize arrays to store unique dates and names
$dates = [];
$names = [];
$records = []; // Store all records

// Skip the header row
fgetcsv($file);

while (($row = fgetcsv($file)) !== false) {
    $date = date('Y-m-d', strtotime($row[3]));
    $name = $row[0];

    // Add the date to the dates array if it's not already present
    if (!in_array($date, $dates)) {
        $dates[] = $date;
    }

    // Add the name to the names array for the corresponding date
    if (!isset($names[$date])) {
        $names[$date] = [];
    }

    // Add the name to the names array if it's not already present
    if (!in_array($name, $names[$date])) {
        $names[$date][] = $name;
    }

    // Store the record
    $records[$date][$name][] = $row;
}

// Close the CSV file
fclose($file);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dropdown Example</title>
</head>

<body>
    <label for="dateSelect">Select Date:</label>
    <select id="dateSelect">
        <option value="">Select a Date</option>
        <?php foreach ($dates as $date) : ?>
            <option value="<?php echo $date; ?>"><?php echo $date; ?></option>
        <?php endforeach; ?>
    </select>

    <label for="nameSelect">Select Name:</label>
    <select id="nameSelect" disabled>
        <option value="">Select a Name</option>
    </select>

    <table id="recordTable" style="display: none;">
        <thead>
            <tr>
                <th>Name</th>
                <th>Peak No</th>
                <th>Peak Values</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <script>
        // Get references to the dropdowns and table
        var dateSelect = document.getElementById('dateSelect');
        var nameSelect = document.getElementById('nameSelect');
        var recordTable = document.getElementById('recordTable');

        // Event listener for date selection
        dateSelect.addEventListener('change', function() {
            // Clear previous options
            nameSelect.innerHTML = '<option value="">Select a Name</option>';
            recordTable.style.display = 'none';

            // Get the selected date
            var selectedDate = dateSelect.value;

            // Populate the name dropdown with names for the selected date
            <?php foreach ($dates as $date) : ?>
                <?php if (isset($names[$date])) : ?>
                    if (selectedDate === '<?php echo $date; ?>') {
                        <?php foreach ($names[$date] as $name) : ?>
                            var option = document.createElement('option');
                            option.value = '<?php echo $name; ?>';
                            option.text = '<?php echo $name; ?>';
                            nameSelect.appendChild(option);
                        <?php endforeach; ?>
                        nameSelect.removeAttribute('disabled');
                    }
                <?php endif; ?>
            <?php endforeach; ?>
        });

        // Event listener for name selection
        nameSelect.addEventListener('change', function() {
            // Get the selected date and name
            var selectedDate = dateSelect.value;
            var selectedName = nameSelect.value;

            // Clear previous table content
            while (recordTable.tBodies[0].hasChildNodes()) {
                recordTable.tBodies[0].removeChild(recordTable.tBodies[0].lastChild);
            }

            // Display the table with records for the selected date and name
            <?php if (!empty($records)) : ?>
                var records = <?php echo json_encode($records); ?>;
                if (selectedDate in records && selectedName in records[selectedDate]) {
                    var selectedRecords = records[selectedDate][selectedName];
                    selectedRecords.forEach(function(record) {
                        var row = recordTable.tBodies[0].insertRow();
                        row.insertCell(0).textContent = record[0]; // Name
                        row.insertCell(1).textContent = record[1]; // Peak No
                        row.insertCell(2).textContent = record[2]; // Peak Values
                        row.insertCell(3).textContent = record[3]; // Time
                    });
                    recordTable.style.display = 'table';
                }
            <?php endif; ?>
        });
    </script>
</body>

</html>