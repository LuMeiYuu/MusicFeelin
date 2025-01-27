<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Song Categorizer</title>
    <link type="text/css" href="style.css" rel="stylesheet">
   
   
</head>
<body>
<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "musicfeelin";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Fetch genres for the dropdown
// Fetch genres
$sql_genres = "SELECT id, genre FROM genre";
$result_genres = $conn->query($sql_genres);

// Fetch moods
$sql_moods = "SELECT id, mood FROM mood";
$result_moods = $conn->query($sql_moods);

// Check for errors (optional)
if (!$result_genres || !$result_moods) {
    die("Query failed: " . $conn->error);
}



?>
  <div class="logo">
        <img src="logo.png">
    </div>

    <div class="main-div">
<div class="side-div">
   <div class="div2">
    <img src="genre.png">

    
        <h3> Add a New Genre and color</h3>

        <form action="submit.php" method="post" class="reg-form">
        <input type="text" id="genre" name="genre" required>
       
        
        <input type="color" id="color" name="color" value="#ff0000">
       
       
        <br> 
        <input type="submit" value="Submit">

    </form>

    </div>
    
     <br>
    <div class="div2">
    <img src="mood.png">
    <form action="moodsubmit.php" method="post" class="reg-form">
        <h3> Add a New Mood and color</h3>
              
        <input type="text" id="mood" name="mood" placeholder="add mood here" required>
       
        <input type="color" id="color" name="color" value="#ff0000">
       
       
        <br> 
        <input type="submit" value="Submit">

    </form>
    </div>
</div>
        



<div class="div3">
    <form method="POST" action="save_song.php">
        <h3> Create a new song</h3>
        <label for="songName">Song Name:</label>`
        <input type="text" id="songName" name="songName" required><br><br>
        <label for="songArtist">Song Artist:</label>
        <input type="text" id="songArtist" name="songArtist" required><br><br>

        <label for="songLink">Song Link:</label>
        <input type="text" id="songLink" name="songLink" required><br><br>
        

        <label for="genre">Choose Genre:</label>
        <select id="genre" name="genre" required>
            <option value="">--Select Genre--</option>

            <?php
            if ($result_genres->num_rows > 0) {
                while ($row = $result_genres->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['genre']}</option>";
                }
            } else {
                echo "<option value=''>No genres available</option>";
            }
            ?>
            
        </select><br><br>
        <label for="mood">Choose Mood:</label>
        <select id="mood" name="mood" required>
        
            <option value="">--Select mood--</option>

            <?php
            if ($result_moods->num_rows > 0) {
                while ($row = $result_moods->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['mood']}</option>";
                }
            } else {
                echo "<option value=''>No moods available</option>";
            }
            ?>
            
        </select><br>

        <input type="submit" placeholder="Save Song">
    </form>


   
        </div>
    </div>
    
    <div class="main-div">
    <div class="container">
        <div class="header">
            <h1>Song Categorizer</h1>
        </div>

        <form id="filterForm">
        <label for="genre">Select Genres:</label><br>
        <select name="genre[]" id="genre" multiple>
            <?php
            // Fetch genres from the database
            
            $genresQuery = "SELECT id, genre FROM genre";
            $genresResult = $conn->query($genresQuery);

            while ($row = $genresResult->fetch_assoc()) {
                echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['genre']) . '</option>';
            }
            ?>
        </select><br><br>

        <label for="mood">Select Moods:</label><br>
        <select name="mood[]" id="mood" multiple>
            <?php
            // Fetch moods from the database
            $moodsQuery = "SELECT id, mood FROM mood";
            $moodsResult = $conn->query($moodsQuery);

            while ($row = $moodsResult->fetch_assoc()) {
                echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['mood']) . '</option>';
            }
            ?>
        </select><br><br>

        <button type="button" id="filterButton">Filter Songs</button>
    </form>

    <div id="results">
        <!-- Filtered songs will be displayed here -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Handle the filter button click
        document.getElementById('filterButton').addEventListener('click', function () {
            const formData = new FormData(document.getElementById('filterForm'));

            // Send data to the server using AJAX
            fetch('filter_songs.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.text())
            .then(data => {
                // Update the results section
                document.getElementById('results').innerHTML = data;
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>      
    </div>
    </div>
</body>
</html>