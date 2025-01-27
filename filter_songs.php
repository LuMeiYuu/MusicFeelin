<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "musicfeelin";
$conn = new mysqli($servername, $username, $password, $dbname);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get selected genres and moods
    $selectedGenres = isset($_POST['genre']) ? $_POST['genre'] : [];
    $selectedMoods = isset($_POST['mood']) ? $_POST['mood'] : [];

    if (!empty($selectedGenres) && !empty($selectedMoods)) {
        // Convert arrays to comma-separated strings
        $genreIds = implode(',', array_map('intval', $selectedGenres));
        $moodIds = implode(',', array_map('intval', $selectedMoods));

        // Query to fetch songs
        $sql = "
            SELECT DISTINCT songName
FROM songs
WHERE genre_id IN ($genreIds)
  AND mood_id IN ($moodIds);

        ";

        $result = $conn->query($sql);

        // Generate HTML output
        if ($result->num_rows > 0) {
            echo "<h2>Filtered Songs:</h2><ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . htmlspecialchars($row['songName']) . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No songs found matching your criteria.</p>";
        }
    } else {
        echo "<p>Please select at least one genre and one mood.</p>";
    }
}

$conn->close();
?>
