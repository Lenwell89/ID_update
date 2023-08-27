<?php
require 'C:\Xampp\phpMyAdmin\vendor\autoload.php'; // Correct autoload.php file
use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if ($fileType != "csv") {
        echo "Only CSV files are allowed.";
        exit;
    }

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) { // Fixed "tmp_name"
        
        $spreadsheet = IOFactory::load($targetFile);
        $worksheet = $spreadsheet->getActiveSheet();

        $conn = new mysqli("localhost", "root", "", "UserInformation");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $matchesFound = false; // Initialize a variable to track matches

        foreach ($worksheet->getRowIterator() as $row) {
            $rowData = $row->getCellIterator();
            $formNumber = $rowData->current()->getValue();
            $firstName = $rowData->next()->getValue();
            $surname = $rowData->next()->getValue();
            $nationalId = $rowData->next()->getValue();

            // Perform database comparison and update
            $sql = "UPDATE PreloadedData SET nationalId = ? WHERE formNumber = ? AND firstName = ? AND surname = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $nationalId, $formNumber, $firstName, $surname);
            $stmt->execute();
            $stmt->close();

            $matchesFound = true; // Set to true if at least one match is found
        }

        $conn->close();

        if ($matchesFound) {
            echo "File uploaded and data processed successfully.";
        } else {
            echo "No match found in the database.";
        }
    } else {
        echo "Error uploading file.";
    }
}
?>
