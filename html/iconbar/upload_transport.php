<?php
$targetDirectory = "C:/Users/python/Documents/projR/phpUploads/"; // Specify the target directory for file uploads
$allowedExtensions = ["xlsx", "xls", "xlsm"]; // Allowed file extensions
$maxFileSize = 5 * 1024 * 1024; // 5MB (in bytes)

if (!empty($_FILES['excelFiles']['name'])) {
    foreach ($_FILES['excelFiles']['name'] as $key => $name) {
        $targetFile = $targetDirectory . basename($name);
        $fileExtension = pathinfo($targetFile, PATHINFO_EXTENSION);

        if (in_array(strtolower($fileExtension), $allowedExtensions)) {
            if ($_FILES['excelFiles']['size'][$key] <= $maxFileSize) {
                if (file_exists($targetFile)) {
                    // File already exists; prompt to overwrite
                    $confirmOverwrite = isset($_POST['overwrite']) ? $_POST['overwrite'] : false;

                    if (file_exists($targetFile)) {
                        // File already exists; prompt to overwrite
                        $confirmOverwrite = isset($_POST['overwrite']) ? $_POST['overwrite'] : false;

                        if (!$confirmOverwrite) {
                            echo "File '$name' already exists. Do you want to overwrite it?";
                            echo '<form method="post"><input type="hidden" name="overwrite" value="true"><input type="submit" value="Yes, Overwrite"></form>';
                            echo '<form method="post"><input type="hidden" name="overwrite" value="false"><input type="submit" value="No, Skip"></form>';
                        } else {
                            if (move_uploaded_file($_FILES['excelFiles']['tmp_name'][$key], $targetFile)) {
                                echo "File '$name' has been overwritten successfully.";
                            } else {
                                echo "Sorry, there was an error overwriting '$name'.";
                            }
                        }
                    }

                } else {
                    if (move_uploaded_file($_FILES['excelFiles']['tmp_name'][$key], $targetFile)) {
                        echo "File '$name' has been uploaded successfully.";
                    } else {
                        echo "Sorry, there was an error uploading '$name'.";
                    }
                }
            } else {
                echo "File '$name' exceeds the maximum file size limit of 5MB.";
            }
        } else {
            echo "Invalid file type for '$name'. Only .xlsx and .xls files are allowed.";
        }
    }
} else {
    echo "No files were selected for upload.";
}
