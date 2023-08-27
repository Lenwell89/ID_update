<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Upload and Management</title>

</head>
<body>
  <h2>Upload CSV File</h2>
  <form action="upload_process.php" method="post" enctype="multipart/form-data">
    Select CSV file to upload:
    <input type="file" name="fileToUpload" accept=".csv">
    <input type="submit" value="Upload File" name="submit">
  </form>

  <h2>Manual Data Input</h2>
  <form action="manual_process.php" method="post">
    <label for="formNumber">Form Number</label>
    <input type="text" name="formNumber" required>
    
    <label for="firstName">First Name</label>
    <input type="text" name="firstName" required>
    
    <label for="surname">Surname</label>
    <input type="text" name="surname" required>
    
    <label for="nationalId">National ID</label>
    <input type="text" name="nationalId" required>
    
    <input type="submit" value="Submit">
  </form>

  <h2>Total Submitions</h2>
  <a href="download_data.php">Download Processed Data</a>
  <?php 
  include "view_data.php"; 
  ?>
</body>
</html>
