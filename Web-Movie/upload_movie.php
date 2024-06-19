<?php
include 'db.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $tokenCost = $conn->real_escape_string($_POST['tokenCost']);
    $thumbnail = $_FILES['thumbnail'];
    $movieFile = $_FILES['movieFile'];

    // Check if files were uploaded without errors
    if (isset($thumbnail, $movieFile) && $thumbnail['error'] == 0 && $movieFile['error'] == 0) {
        $thumbnail_name = $thumbnail['name'];
        $movie_name = $movieFile['name'];
        $thumbnail_temp = $thumbnail['tmp_name'];
        $movie_temp = $movieFile['tmp_name'];

        // Set paths for file uploads
        $thumbnail_path = 'movies/thumbnails/' . basename($thumbnail_name);
        $movie_path = 'movies/videos/' . basename($movie_name);

        // Move the uploaded files to their respective directories
        if (move_uploaded_file($thumbnail_temp, $thumbnail_path) && move_uploaded_file($movie_temp, $movie_path)) {
            // Insert movie data into database
            $sql = "INSERT INTO Movies (Title, Description, TokenCost, ThumbnailURL, MovieURL) VALUES ('$title', '$description', '$tokenCost', '$thumbnail_path', '$movie_path')";
            if ($conn->query($sql) === TRUE) {
                echo "Movie uploaded successfully!";
            } else {
                echo "Error uploading movie: " . $conn->error;
            }
        } else {
            echo "Error uploading files.";
        }
    } else {
        echo "Error with file uploads: " . $thumbnail['error'] . " & " . $movieFile['error'];
    }
    $conn->close(); // Close the database connection
}
?>
