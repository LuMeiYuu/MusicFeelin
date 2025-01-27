<html>
<head>
</head>
<body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establish database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "musicfeelin";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $genre = $_POST['genre'];
    $color = $_POST['color'];
    

    // Prepare SQL statement to insert data into database
    $sql = "INSERT INTO genre ( genre, color ) VALUES ('$genre', '$color')";

    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        // Redirect to display information page
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close database connection
    $conn->close();
}
?>
<h1>YA DID IT MFER</h1>
</body>
</html>
