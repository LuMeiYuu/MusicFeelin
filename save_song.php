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
    }

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

 
    

    if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
        $songName = $_POST['songName'];
        $songArtist = $_POST['songArtist'];
        $songLink = $_POST['songLink'];
        $genreId = (int) $_POST['genre']; // Cast to integer for safety
        $moodId = (int) $_POST['mood'];   // Cast to integer for safety
    
        // Insert into songs table
        $stmt = $conn->prepare("INSERT INTO songs (songName, artist, spotifyLink, genre_id, mood_id) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssii", $songName, $songArtist, $songLink, $genreId, $moodId);
    
        if ($stmt->execute()) {
            echo "Song successfully saved!";
        } else {
            echo "Error saving song: " . $stmt->error;
        }
    
        $stmt->close();
    } else {
        echo "Invalid form submission.";
    }
    
    $conn->close();
    ?>

</body>
</html>
