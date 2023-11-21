<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="handF.css">
    <title>Document</title>
</head>
<body>
  <?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'dcme_web';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to retrieve data from the table
$sql = "SELECT * FROM users"; // Replace 'your_table' with your actual table name
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"] . " - Name: " . $row["userName"] . " - mobileNumber: " . $row["mobileNumber"] . " - Email: " . $row["email"] . "<br>";
        // Adjust the field names ("id", "name", "email") based on your table's column names
    }
} else {
    echo "0 results";
}

$conn->close();
?>

    </body>
</html>