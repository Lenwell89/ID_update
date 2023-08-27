<?php
$conn = new mysqli("localhost", "root", "", "userinformation");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM ProcessedData";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Set the HTTP headers to indicate a CSV file download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="processed_data.csv"');

    // Open the output stream
    $output = fopen('php://output', 'w');

    // Write the CSV header
    fputcsv($output, array('Form Number', 'First Name', 'Surname', 'National ID'));

    // Write each row of data
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }

    // Close the output stream
    fclose($output);
} else {
    echo "No data found.";
}

$conn->close();
?>
