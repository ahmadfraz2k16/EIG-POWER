<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'C:/xampp/htdocs/latest_Dash/backend/functions.php';
// $startDate = date_format(date_create(startDate()), "Y-m-d");
// $endDate = date_format(date_create(endDate()), "Y-m-d");
?>
<?php include('include/header.php'); ?>
<!-- ============================================================== -->
<!-- End Topbar header -->
<!-- ============================================================== -->
<?php include('include/sidebar.php'); ?>
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Upload Files</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Upload</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <form id="uploadForm" action="upload_transport.php" method="post" enctype="multipart/form-data">
            <div class="container mt-5">
                <div class="d-flex justify-content-center">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="folderInput" webkitdirectory directory multiple>
                        <label class="custom-file-label" for="folderInput">Choose Folder(s)</label>
                    </div>

                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="fileInput" multiple>
                        <label class="custom-file-label" for="fileInput">Choose File(s)</label>
                    </div>

                    <button type="button" id="uploadButton" class="btn btn-primary ml-3">Upload</button>
                </div>
                <!-- Add a list to display uploaded files -->
                <div id="uploadedFiles" class="mt-3">
                    <h5>Uploaded Files:</h5>
                    <ul id="fileList"></ul>
                </div>

                <!-- Add a loading indicator -->
                <div id="loadingIndicator" class="mt-3" style="display: none;">
                    Uploading files... <div class="spinner-border" role="status"></div>
                </div>
            </div>
        </form>
        <!-- button for uploading data to database -->
        <a href="http://localhost/latest_dash/backend/upload.php" class="btn btn-success" id="upload-button-db" style="display: none;">Upload to Database</a>
    </div>

    <!-- loaders and success messages start -->
    <!-- Add a loading indicator for checking CSV file -->
    <div id="checkingCSVLoader" style="display: none;">
        Cleaning and Preprocessing Data ... <div class="spinner-border" role="status"></div>
    </div>

    <!-- Add a message for when the CSV file is found -->
    <div id="csvFileFoundMessage" style="display: none;">
        Data is Preprocessed. You can upload data...
    </div>

    <!-- Add a message for when the upload is successful -->
    <div id="uploadSuccessMessage" style="display: none;">
        Data successfully uploaded to the database.
    </div>

    <!-- loaders and success messages end -->
    <!-- End Row -->




</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->

</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->


<!-- ============================================================== -->
<!-- customizer Panel -->
<!-- ============================================================== -->
<?php
// include('include/customizer.php'); 
?>
<?php include('include/footer.php'); ?>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get references to the loading indicator and message elements
        const checkingCSVLoader = document.getElementById("checkingCSVLoader");
        const csvFileFoundMessage = document.getElementById("csvFileFoundMessage");
        const uploadSuccessMessage = document.getElementById("uploadSuccessMessage");
        // Function to check for the presence of the CSV file
        function checkForCSVFile() {
            // Show the loading indicator
            checkingCSVLoader.style.display = "block";
            // Send an AJAX request to check if the file exists
            fetch("check_for_csv_file.php")
                .then(response => response.text())
                .then(data => {
                    if (data === 'true') {
                        // The CSV file is found, hide the loading indicator and show the CSV file found message
                        checkingCSVLoader.style.display = "none";
                        csvFileFoundMessage.style.display = "block";
                        // The CSV file is found, trigger the upload process
                        uploadCSVFile();
                    } else {
                        // The file is not found, continue checking
                        setTimeout(checkForCSVFile, 5000); // Poll every 5 seconds (adjust as needed)
                    }
                })
                .catch(error => {
                    console.error("Error checking for CSV file:", error);
                    // Retry after an interval in case of an error
                    setTimeout(checkForCSVFile, 5000); // Retry after 5 seconds (adjust as needed)
                });
        }

        // Function to trigger the upload process
        // Function to trigger the upload process
        function uploadCSVFile() {
            // Show a message indicating that data is being processed
            // You can implement this using a loading indicator or a message on your page

            // Assuming that the upload process in upload.php will handle the success message,
            // no need to display a success message here.
            // You can implement the success message in upload.php.

            // // Redirect to upload.php
            // window.location.href = "http://localhost/latest_dash/backend/upload.php";

            // upload button will appear
            // get the button element by its id
            var button = document.getElementById("upload-button-db");
            // change the display property to block or inline
            button.style.display = "block";
        }
        // Check for the success parameter in the URL and display a success message if it exists
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has("success")) {
            uploadSuccessMessage.style.display = "block";
        }
        // function uploadCSVFile() {
        //     // Show a message indicating that data is being processed
        //     // You can implement this using a loading indicator or a message on your page

        //     // Send an AJAX request to trigger the upload process
        //     fetch("C:/xampp/htdocs/latest_Dash/backend/upload.php")
        //         .then(response => response.text())
        //         .then(data => {
        //             if (data === 'true') {
        //                 // Show the upload success message
        //                 uploadSuccessMessage.style.display = "block";
        //                 // The upload process was successful
        //                 // Show a message indicating successful upload

        //                 // You can implement this using a success message on your page

        //                 // Continue checking for new CSV files
        //                 checkForCSVFile();
        //             } else {
        //                 // The upload process failed
        //                 // Handle the error, you can show an error message
        //             }
        //         })
        //         .catch(error => {
        //             console.error("Error uploading CSV file:", error);
        //             // Retry after an interval in case of an error
        //             setTimeout(uploadCSVFile, 5000); // Retry after 5 seconds (adjust as needed)
        //         });
        // }

        const folderInput = document.getElementById("folderInput");
        const fileInput = document.getElementById("fileInput");
        const uploadButton = document.getElementById("uploadButton");
        const fileList = document.getElementById("fileList");
        const uploadedFiles = document.getElementById("uploadedFiles");
        const loadingIndicator = document.getElementById("loadingIndicator");

        function resetInputs() {
            folderInput.value = ''; // Reset the folder input
            fileInput.value = ''; // Reset the file input
        }

        uploadButton.addEventListener("click", function() {
            const folderFiles = folderInput.files;
            const fileFiles = fileInput.files;
            const allFiles = [...folderFiles, ...fileFiles]; // Combine files from both inputs

            if (allFiles.length === 0) {
                alert("Please select at least one file or folder.");
                return;
            }

            // Show loading indicator
            loadingIndicator.style.display = "block";

            processFiles(allFiles);
            // Start checking for the CSV file when the page loads
            checkForCSVFile();
        });

        fileInput.addEventListener("change", function() {
            const files = fileInput.files;
            if (files.length === 0) {
                alert("Please select a file.");
                return;
            }

            processFiles(files);
            // Start checking for the CSV file when the page loads
            checkForCSVFile();
        });

        function processFiles(files) {
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (file.type === "") {
                    // It's a directory (folder)
                    processFolder(file);
                } else {
                    // It's a file (Excel file)
                    const formData = new FormData();
                    formData.append("excelFiles[]", file);

                    // Example AJAX request to upload the file (replace with your actual endpoint)
                    fetch("upload_transport.php", {
                            method: "POST",
                            body: formData,
                        })
                        .then(response => response.text())
                        .then(data => {
                            console.log("Response from server:", data);

                            // Update the list of uploaded files
                            const listItem = document.createElement("li");
                            listItem.textContent = "File uploaded successfully: " + file.name;
                            fileList.appendChild(listItem);

                            // Hide loading indicator
                            loadingIndicator.style.display = "none";
                            // Reset the input elements
                            resetInputs();
                        })
                        .catch(error => {
                            console.error("Error uploading file:", error);

                            // Hide loading indicator
                            loadingIndicator.style.display = "none";
                            // Reset the input elements
                            resetInputs();

                        });
                }
            }
        }

        function processFolder(folder) {
            const reader = folder.createReader();
            reader.readEntries(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isDirectory) {
                        processFolder(entry);
                    } else {
                        const formData = new FormData();
                        formData.append("excelFiles[]", entry);

                        // Example AJAX request to upload the file (replace with your actual endpoint)
                        fetch("upload_transport.php", {
                                method: "POST",
                                body: formData,
                            })
                            .then(response => response.text())
                            .then(data => {
                                console.log("Response from server:", data);
                                alert("File uploaded successfully: " + entry.name);
                                // Reset the input elements
                                resetInputs();
                            })
                            .catch(error => {
                                console.error("Error uploading file:", error);
                                // Reset the input elements
                                resetInputs();
                            });
                    }
                });
            });
        }
    });
</script>
<!-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        const folderInput = document.getElementById("folderInput");
        const uploadButton = document.getElementById("uploadButton");

        uploadButton.addEventListener("click", function() {
            const files = folderInput.files;
            if (files.length === 0) {
                alert("Please select a folder.");
                return;
            }

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (file.type === "") {
                    // It's a directory (folder)
                    processFolder(file);
                } else {
                    // It's a file (Excel file)
                    const formData = new FormData();
                    formData.append("excelFiles[]", file);

                    // Example AJAX request to upload the file (replace with your actual endpoint)
                    fetch("upload_transport.php", {
                            method: "POST",
                            body: formData,
                        })
                        .then(response => response.text())
                        .then(data => {
                            console.log("Response from server:", data);
                        })
                        .catch(error => {
                            console.error("Error uploading file:", error);
                        });
                }
            }
        });

        function processFolder(folder) {
            const reader = folder.createReader();
            reader.readEntries(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isDirectory) {
                        processFolder(entry);
                    } else {
                        const formData = new FormData();
                        formData.append("excelFiles[]", entry);

                        // Example AJAX request to upload the file (replace with your actual endpoint)
                        fetch("upload_transport.php", {
                                method: "POST",
                                body: formData,
                            })
                            .then(response => response.text())
                            .then(data => {
                                console.log("Response from server:", data);
                            })
                            .catch(error => {
                                console.error("Error uploading file:", error);
                            });
                    }
                });
            });
        }
    });
</script> -->

</body>

</html>