<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'C:/xampp/htdocs/latest_Dash/backend/functions.php';
$startDate = date_format(date_create(startDate()), "Y-m-d");
$endDate = date_format(date_create(endDate()), "Y-m-d");
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

    </div>


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
        });

        fileInput.addEventListener("change", function() {
            const files = fileInput.files;
            if (files.length === 0) {
                alert("Please select a file.");
                return;
            }

            processFiles(files);
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