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

    $mood = $_POST['mood'];
    $color = $_POST['color'];
    

    // Prepare SQL statement to insert data into database
    $sql = "INSERT INTO mood ( mood, color ) VALUES ('$mood', '$color')";

    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        echo "<script>
            alert('Data saved successfully!');
            window.history.back();
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close database connection
    $conn->close();
}
?>

</body>
</html>
