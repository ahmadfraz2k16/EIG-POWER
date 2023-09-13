<?php
$csvFilePath = "C:/Users/python/Documents/projR/processed_mw_sheets/collective_data.csv";

if (file_exists($csvFilePath)) {
    echo 'true'; // File found
} else {
    echo 'false'; // File not found
}
