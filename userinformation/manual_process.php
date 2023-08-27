<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $formNumber = $_POST["formNumber"];
    $firstName = $_POST["firstName"];
    $surname = $_POST["surname"];
    $nationalId = $_POST["nationalId"];

    $conn = new mysqli("localhost", "root", "", "userinformation");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Perform database comparison and update
    $sql = "UPDATE PreloadedData SET nationalId = ? WHERE formNumber = ? AND firstName = ? AND surname = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siss", $nationalId, $formNumber, $firstName, $surname);
    $stmt->execute();
    $stmt->close();

    $conn->close();
    echo "Manual data updated successfully.";
}
else{}
?>
