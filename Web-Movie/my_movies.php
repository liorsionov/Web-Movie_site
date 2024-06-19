<?php
session_start();
include 'db.php';

if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Please log in to view your movies.'); window.location.href = 'login.html';</script>";
    exit;
}

$userId = $_SESSION['userid'];

// Fetch movies purchased by the user
$sql = "SELECT Movies.Title, Movies.Description, Movies.ThumbnailURL, Movies.MovieURL
        FROM Purchases 
        JOIN Movies ON Purchases.MovieID = Movies.MovieID
        WHERE Purchases.UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

echo "<h1>My Movies</h1>";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<img src='" . htmlspecialchars($row['ThumbnailURL']) . "' alt='Movie Image' style='width:150px;'><br>";
        echo "Title: " . htmlspecialchars($row['Title']) . "<br>";
        echo "Description: " . htmlspecialchars($row['Description']) . "<br>";
        echo "<a href='" . htmlspecialchars($row['MovieURL']) . "' target='_blank'>Watch Now</a>";
        echo "</div><hr>";
    }
} else {
    echo "You have not purchased any movies yet.";
}

echo "<a href='index.php' class='btn btn-secondary'>Return to Main Page</a>";

$conn->close();
?>
