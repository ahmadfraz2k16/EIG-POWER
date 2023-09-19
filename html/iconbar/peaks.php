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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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

    <div id="cardContainer" class="row justify-content-between">
        <!-- Cards will be dynamically generated here -->
    </div>


    <!-- JavaScript code to display records in cards -->
    <script>
        // Get references to the dropdowns and card container
        var dateSelect = document.getElementById('dateSelect');
        var nameSelect = document.getElementById('nameSelect');
        var cardContainer = document.getElementById('cardContainer');

        // Event listener for date selection
        dateSelect.addEventListener('change', function() {
            // Clear previous options and cards
            nameSelect.innerHTML = '<option value="">Select a Name</option>';
            cardContainer.innerHTML = '';

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

            // Clear previous cards
            cardContainer.innerHTML = '';

            // Display the cards with records for the selected date and name
            <?php if (!empty($records)) : ?>
                var records = <?php echo json_encode($records); ?>;
                if (selectedDate in records && selectedName in records[selectedDate]) {
                    var selectedRecords = records[selectedDate][selectedName];
                    selectedRecords.forEach(function(record) {
                        var cardDiv = document.createElement('div');
                        cardDiv.className = 'col-sm-12 col-md-4';
                        cardDiv.innerHTML = `
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h4 class="m-b-0">${record[0]}</h4>
                                    </div>
                                    <div class="ml-auto align-self-center">
                                        <h2 class="font-medium m-b-0">${record[2]}</h2>
                                        <h5 class="font-medium m-b-0">${record[3]}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                        cardContainer.appendChild(cardDiv);
                    });
                }
            <?php endif; ?>
        });
    </script>
</body>

</html>